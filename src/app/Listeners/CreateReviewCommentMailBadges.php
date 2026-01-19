<?php

namespace App\Listeners;

use App\Events\ReviewCommentCreated;
use App\Jobs\SendReviewCreatedEmailJob;
use App\Models\ReviewMailBadge;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CreateReviewCommentMailBadges
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ReviewCommentCreated $event): void
    {
        $reviewComments = $event->reviewComments;

        Log::info('listener reached', [
            'comment' => $reviewComments->comment,
            'userId'  => $reviewComments->review->reviewUser->id,
            'reviewId' =>  $reviewComments->review->id,
        ]);

        $userId   = $reviewComments->review->reviewUser->id;
        $reviewId = $reviewComments->review_id;

        $badge = ReviewMailBadge::firstOrCreate([
            'user_id'   => $userId,
            'review_id' => $reviewId
        ]);


        SendReviewCreatedEmailJob::dispatch($badge->id)->onQueue('mail');
    }
}
