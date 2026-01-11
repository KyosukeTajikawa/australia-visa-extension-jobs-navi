<?php

namespace App\Jobs;

use App\Mail\FarmCreatedMail;
use App\Models\FarmMailBadge;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendFarmCreatedEmailJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $tries =3;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $badgeId) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $badge = FarmMailBadge::query()->with(['user', 'farm'])->findOrFail($this->badgeId);

        // 冪等：すでに送信済みなら何もしない（再実行されても安全）
        if ($badge->send_at) {
            return;
        }

        Mail::to($badge->user->email)->send(new FarmCreatedMail($badge->farm));

        $badge->update([
            'send_at'    => now(),
            'failed_at'  => null,
            'last_error' => null,
        ]);
    }

    public function failed(Throwable $e)
    {
        FarmMailBadge::whereKey($this->badgeId)->update([
            'failed_at'  => now(),
            'last_error' => $e->getMessage(),
        ]);
    }
}
