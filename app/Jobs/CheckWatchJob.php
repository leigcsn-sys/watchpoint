<?php

namespace App\Jobs;

use App\Models\Watch;
use App\Models\Snapshot;
use App\Models\ChangeLog;
use App\Services\PageFetcher;
use App\Services\DiffGenerator;
use App\Mail\ChangeDetectedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckWatchJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(public Watch $watch) {}

    public function handle(PageFetcher $fetcher, DiffGenerator $differ): void
    {
        try {
            $text = $fetcher->fetchCleanText($this->watch->url, $this->watch->css_selector);
        } catch (\Throwable $e) {
            $this->watch->update([
                'last_checked_at' => now(),
                'last_error' => $e->getMessage(),
                'is_checking' => false,
            ]);
            return;
        }

        $newHash = $fetcher->hash($text);
        $this->watch->update([
            'last_checked_at' => now(),
            'last_error' => null,
            'is_checking' => false,
        ]);

        if ($newHash === $this->watch->last_hash) {
            return;
        }

        $oldSnapshot = $this->watch->snapshots()->latest('fetched_at')->first();

        $newSnapshot = Snapshot::create([
            'watch_id' => $this->watch->id,
            'content_text' => $text,
            'content_hash' => $newHash,
            'fetched_at' => now(),
        ]);

        if ($oldSnapshot) {
            $summary = $differ->summarize($oldSnapshot->content_text, $text);

            ChangeLog::create([
                'watch_id' => $this->watch->id,
                'old_snapshot_id' => $oldSnapshot->id,
                'new_snapshot_id' => $newSnapshot->id,
                'diff_summary' => $summary,
                'detected_at' => now(),
            ]);

            Mail::to($this->watch->user)->send(new ChangeDetectedMail($this->watch, $summary));
        }

        $this->watch->update(['last_hash' => $newHash]);
    }
}