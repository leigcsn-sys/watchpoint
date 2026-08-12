<?php

use App\Models\Watch;
use App\Jobs\CheckWatchJob;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    Watch::where('is_active', true)
        ->where(function ($q) {
            $q->whereNull('last_checked_at')
              ->orWhereRaw('(strftime("%s","now") - strftime("%s", last_checked_at)) / 60 >= check_frequency_minutes');
        })
        ->each(fn ($watch) => CheckWatchJob::dispatch($watch));
})->everyMinute();
