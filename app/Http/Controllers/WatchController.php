<?php

namespace App\Http\Controllers;

use App\Models\Watch;
use App\Jobs\CheckWatchJob;
use Illuminate\Http\Request;

class WatchController extends Controller
{
    public function index()
    {
        $watches = auth()->user()->watches()->latest()->get();
        return view('watches.index', compact('watches'));
    }

    public function create()
    {
        return view('watches.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url|max:2048',
            'css_selector' => 'nullable|string|max:255',
            'check_frequency_minutes' => 'required|integer|min:5',
        ]);

        $validated['user_id'] = auth()->id();

        Watch::create($validated);

        return redirect()->route('watches.index')->with('status', 'Watch created.');
    }

    public function show(Watch $watch)
    {
        abort_unless($watch->user_id === auth()->id(), 403);

        $changeLogs = $watch->changeLogs()->latest('detected_at')->get();

        return view('watches.show', compact('watch', 'changeLogs'));
    }

    public function destroy(Watch $watch)
    {
        abort_unless($watch->user_id === auth()->id(), 403);

        $watch->delete();

        return redirect()->route('watches.index')->with('status', 'Watch deleted.');
    }

    public function checkNow(Watch $watch)
    {
        abort_unless($watch->user_id === auth()->id(), 403);

        CheckWatchJob::dispatchSync($watch);

        return redirect()->route('watches.show', $watch)->with('status', 'Check complete.');
    }
}