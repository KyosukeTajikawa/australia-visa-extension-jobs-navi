<?php

namespace App\Jobs;

use App\Mail\ReviewCreateMail;
use App\Models\ReviewMailBadge;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendReviewCreatedEmailJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $badgeId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $badge = ReviewMailBadge::findOrFail($this->badgeId);

        Log::info('job reached', [
            'userId' => $badge->user_id,
            'reviewId' => $badge->review_id,
        ]);

        if ($badge->sent_at) {
            return;
        }

        Mail::to($badge->user->email)->send(new ReviewCreateMail($badge->review));

        $badge->update([
            'sent_at'    => now(),
            'failed_at'  => null,
            'last_error' => null,
        ]);
    }

    public function failed(?Throwable $e)
    {
        ReviewMailBadge::whereKey($this->badgeId)->update([
            'failed_at'  => now(),
            'last_error' => $e->getMessage(),
        ]);
    }

}
