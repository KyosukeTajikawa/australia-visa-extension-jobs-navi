<?php

namespace Tests\Feature\Badges;

use App\Events\ReviewCommentCreated;
use App\Jobs\SendReviewCreatedEmailJob;
use App\Mail\ReviewCreateMail;
use App\Models\ApplicationMethod;
use App\Models\Farm;
use App\Models\Review;
use App\Models\ReviewComments;
use App\Models\ReviewMailBadge;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ReviewMailBadgeTest extends TestCase
{
    /**
     * コメントを受けてからjobまでの動きをテスト
     */
    public function testReviewBadgeUntilListener(): void
    {
        Queue::fake();

        $user        = User::factory()->create();
        $commentUser = User::factory()->create();
        $state       = State::factory()->create();
        $farm        = Farm::factory()->for($user, 'user')->for($state, 'state')->create();
        $method      = ApplicationMethod::factory()->create();
        $review      = Review::factory()->for($method, 'applicationMethod')->for($user, 'reviewUser')->for($farm, 'farm')->create();
        ReviewComments::create([
            'review_id' => $review->id,
            'user_id'   => $commentUser->id,
            'comment'   => 'テストコメント',
        ]);

        $this->assertDatabaseHas('review_comments', [
            'review_id' => $review->id,
            'user_id'   => $commentUser->id,
            'comment'   => 'テストコメント',
        ]);

        $badge = ReviewMailBadge::where('review_id', $review->id)->firstOrFail();

        $this->assertDatabaseHas('development.review_mail_badges', [
            'user_id'   => $user->id,
            'review_id' => $review->id,
        ]);

        Queue::assertPushedOn('mail', SendReviewCreatedEmailJob::class, function ($job) use ($badge) {
            return $job->badgeId === $badge->id;
        });
    }

    /**
     * jobからメール発送の動きをテスト
     */
    public function testReviewBadgeFromJob(): void
    {
        Mail::fake();

        $setTime    = Carbon::parse('2026-01-01 10:00:00');
        Carbon::setTestNow($setTime);

        $user        = User::factory()->create();
        $commentUser = User::factory()->create();
        $state       = State::factory()->create();
        $farm        = Farm::factory()->for($user, 'user')->for($state, 'state')->create();
        $method      = ApplicationMethod::factory()->create();
        $review      = Review::factory()->for($method, 'applicationMethod')->for($user, 'reviewUser')->for($farm, 'farm')->create();
        ReviewComments::createQuietly([
            'review_id' => $review->id,
            'user_id'   => $commentUser->id,
            'comment'   => 'テストコメント',
        ]);

        $this->assertDatabaseHas('review_comments', [
            'review_id' => $review->id,
            'user_id'   => $commentUser->id,
            'comment'   => 'テストコメント',
        ]);

        $badge = $badge = ReviewMailBadge::create([
            'user_id'   => $user->id,
            'review_id' => $review->id,
        ]);

        (new SendReviewCreatedEmailJob($badge->id))->handle();

        Mail::assertSent(function (ReviewCreateMail $mail) use ($badge) {
            return $mail->hasTo($badge->user->email)
                && $mail->review->is($badge->review);
        });

        $this->assertDatabaseHas('review_mail_badges', [
            'id'         => $badge->id,
            'sent_at'    => $setTime,
            'failed_at'  => null,
            'last_error' => null,
        ]);
    }

    /**
     * jobからメール発送の動きをテスト(失敗)
     */
    public function testReviewBadgeFromJobFailed(): void
    {
        Mail::fake();

        $setTime    = Carbon::parse('2026-01-01 10:00:00');
        Carbon::setTestNow($setTime);

        $user        = User::factory()->create();
        $commentUser = User::factory()->create();
        $state       = State::factory()->create();
        $farm        = Farm::factory()->for($user, 'user')->for($state, 'state')->create();
        $method      = ApplicationMethod::factory()->create();
        $review      = Review::factory()->for($method, 'applicationMethod')->for($user, 'reviewUser')->for($farm, 'farm')->create();
        ReviewComments::createQuietly([
            'review_id' => $review->id,
            'user_id'   => $commentUser->id,
            'comment'   => 'テストコメント',
        ]);

        $this->assertDatabaseHas('review_comments', [
            'review_id' => $review->id,
            'user_id'   => $commentUser->id,
            'comment'   => 'テストコメント',
        ]);

        $badge = $badge = ReviewMailBadge::create([
            'user_id'   => $user->id,
            'review_id' => $review->id,
        ]);

        $job   = (new SendReviewCreatedEmailJob($badge->id));
        $error = new \Exception('Mail Failure');
        $job->failed($error);

        $this->assertDatabaseHas('review_mail_badges', [
            'id'         => $badge->id,
            'sent_at'    => null,
            'failed_at'  => $setTime,
            'last_error'  => 'Mail failure',
        ]);
    }
}
