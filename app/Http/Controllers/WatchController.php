<?php

namespace App\Http\Controllers;

use App\Models\Watch;
use App\Jobs\CheckWatchJob;
use App\Http\Requests\StoreWatchRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WatchController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $watches = auth()->user()->watches()->latest()->get();
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
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('watches.index')->with('status', 'Watch created.');
    }

    public function show(Watch $watch)
    {
        $this->authorize('view', $watch);

        $changeLogs = $watch->changeLogs()->latest('detected_at')->get();

        return view('watches.show', compact('watch', 'changeLogs'));
    }

    public function destroy(Watch $watch)
    {
        $this->authorize('delete', $watch);

        $watch->delete();

        return redirect()->route('watches.index')->with('status', 'Watch deleted.');
    }

    public function checkNow(Watch $watch)
    {
        $this->authorize('update', $watch);

        if ($watch->last_checked_at && $watch->last_checked_at->diffInSeconds(now()) < 30) {
            return redirect()->route('watches.show', $watch)
                ->with('status', 'Please wait a moment before checking again.');
        }

        CheckWatchJob::dispatchSync($watch);

        return redirect()->route('watches.show', $watch)->with('status', 'Check complete.');
    }
}