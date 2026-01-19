<?php

namespace App\Listeners;

use App\Events\FarmCreated;
use App\Jobs\SendFarmCreatedEmailJob;
use App\Models\FarmMailBadge;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CreateFarmMailBadges
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
    public function handle(FarmCreated $event): void
    {
        $farm = $event->farm;

        // 例：通知対象ユーザー（全員なのか、購読者だけなのかは要件次第）
        $users = User::query()->whereNotNull('email')->get(['id']);

        foreach($users as $user) {
            $badge = FarmMailBadge::firstOrCreate([
                'farm_id' => $farm->id,
                'user_id' => $user->id,
            ]);

            SendFarmCreatedEmailJob::dispatch($badge->id)->onQueue('mail');
        }
    }
}
