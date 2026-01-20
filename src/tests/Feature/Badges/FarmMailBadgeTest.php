<?php

namespace Tests\Feature\Badges;

use App\Events\FarmCreated;
use App\Jobs\SendFarmCreatedEmailJob;
use App\Mail\FarmCreatedMail;
use App\Models\Crop;
use App\Models\Farm;
use App\Models\FarmMailBadge;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class FarmMailBadgeTest extends TestCase
{

    use refreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testFarmMailUntilDispatch(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        Crop::factory()->create();
        $state = State::factory()->create();

        $farm = Farm::factory()->for($user, 'user')->for($state, 'state')->create();

        $this->assertDatabaseHas('farm_mail_badges', [
            'farm_id' => $farm->id,
            'user_id' => $user->id,
        ]);

        Queue::assertPushedOn('mail', SendFarmCreatedEmailJob::class, function ($job) {
            return is_int($job->badgeId);
        });
    }


    public function testFarmMailFromDispatchSuccess(): void
    {
        Mail::fake();

        $testTime = Carbon::parse('2026-01-01 10:00:00');
        Carbon::setTestNow($testTime);

        $user = User::factory()->create(['email' => 'test@example.com']);
        Crop::factory()->create();
        $state = State::factory()->create();

        $farm = Farm::factory()->for($user, 'user')->for($state, 'state')->createQuietly();

        $badge = FarmMailBadge::create([
            'user_id' => $user->id,
            'farm_id' => $farm->id,
        ]);

        SendFarmCreatedEmailJob::dispatch($badge->id)->onQueue('mail');
        $this->artisan('queue:work --once --queue=mail');

        $this->assertDatabaseHas('farm_mail_badges', [
            'send_at'    => $testTime->format('Y-m-d H:i'),
            'failed_at'  => null,
            'last_error' => null,
        ]);


        Mail::assertSent(FarmCreatedMail::class, 'test@example.com');
    }


    public function testFarmMailFromDispatchFail(): void
    {
        $testTime = Carbon::parse('2026-01-01 10:00:00');
        Carbon::setTestNow($testTime);

        $user = User::factory()->create(['email' => 'test@example.com']);
        Crop::factory()->create();
        $state = State::factory()->create();

        $farm = Farm::factory()->for($user, 'user')->for($state, 'state')->createQuietly();

        $badge = FarmMailBadge::create([
            'user_id' => $user->id,
            'farm_id' => $farm->id,
            'send_at' => null,
            'failed_at' => null,
            'last_error' => null,
        ]);


        SendFarmCreatedEmailJob::dispatch($badge->id)->onQueue('mail');
        Mail::shouldReceive('to')->andThrow(new \Exception('Mail failure'));
        $this->artisan('queue:work --once --queue=mail');
        $this->artisan('queue:work --once --queue=mail');
        $this->artisan('queue:work --once --queue=mail');


        $this->assertDatabaseHas('farm_mail_badges', [
            'id'         => $badge->id,
            'sent_at'    => null,
            'failed_at'  => $testTime->format('Y-m-d H:i:s'),
            'last_error'  => 'Mail failure',
        ]);

        Mail::shouldReceive('send')->never();
    }
}
