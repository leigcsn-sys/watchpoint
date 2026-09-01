<?php

namespace App\Http\Controllers;

use App\Jobs\CheckWatchJob;
use App\Http\Requests\StoreWatchRequest;
use App\Models\User;
use App\Models\Watch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;

class WatchController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $watches = Watch::query()->latest()->get();

        return view('watches.index', compact('watches'));
    }

    public function create()
    {
        return view('watches.create');
    }

    public function store(StoreWatchRequest $request)
    {
        Watch::create([
            ...$request->validated(),
            'user_id' => $this->publicUserId(),
        ]);

        return redirect()->route('watches.index')->with('status', 'Watch created.');
    }

    public function show(Watch $watch)
    {
        $changeLogs = $watch->changeLogs()->latest('detected_at')->get();

        return view('watches.show', compact('watch', 'changeLogs'));
    }

    public function destroy(Watch $watch)
    {
        $watch->delete();

        return redirect()->route('watches.index')->with('status', 'Watch deleted.');
    }

    public function checkNow(Watch $watch)
    {
        if ($watch->is_checking) {
            return redirect()->route('watches.show', $watch)
                ->with('status', 'A check is already in progress.');
        }

        if ($watch->last_checked_at && $watch->last_checked_at->diffInSeconds(now()) < 30) {
            return redirect()->route('watches.show', $watch)
                ->with('status', 'Please wait a moment before checking again.');
        }

        $watch->update([
            'is_checking' => true,
            'last_error' => null,
        ]);

        try {
            CheckWatchJob::dispatch($watch);
        } catch (\Throwable $e) {
            $watch->update([
                'is_checking' => false,
                'last_error' => 'The check could not be queued. Please try again.',
            ]);

            return redirect()->route('watches.show', $watch)
                ->with('status', 'Check could not be queued.');
        }

        return redirect()->route('watches.show', $watch)->with('status', 'Check queued.');
    }

    private function publicUserId(): int
    {
        $user = User::query()->firstOrCreate(
            ['email' => 'public@watchpoint.local'],
            [
                'name' => 'Public Watcher',
                'password' => bcrypt(Str::random(32)),
            ]
        );

        return $user->id;
    }
}