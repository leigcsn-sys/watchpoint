<x-app-layout>
    <div class="editorial-shell">
        <div class="editorial-header">
            <div>
                <p class="editorial-kicker">watchpoint</p>
                <h1 class="editorial-title">Watch what matters.</h1>
            </div>

            <div class="editorial-copy">
                <p>Track the pages you care about and get notified when the important parts change.</p>
                <div class="editorial-meta">
                    <a href="{{ route('watches.create') }}" class="text-[#171613] underline decoration-1 underline-offset-4">add watch</a>
                    <span>•</span>
                    <span>public list</span>
                </div>
            </div>
        </div>

        <div class="editorial-grid">
            <aside class="editorial-left">
                <nav aria-label="Main navigation">
                    <a href="#">Home</a>
                </nav>
            </aside>

            <div class="editorial-main">
                @if (session('status'))
                    <p role="status" class="mb-5 rounded-xl border border-[#dfe3e8] bg-white/60 px-4 py-3 text-sm text-[#171613] shadow-sm">
                        <span class="font-['JetBrains_Mono'] text-[10px] uppercase tracking-[0.18em] text-[#6B7280]">status</span>
                        <span class="ml-3">{{ session('status') }}</span>
                    </p>
                @endif

                <div class="watch-hero">
                    <div class="badge">01 — watches</div>
                    <a href="{{ route('watches.create') }}" class="secondary-button">
                        + Add Watch
                    </a>
                </div>

                <div class="watch-list">
                    @if ($watches->isEmpty())
                        <div class="watch-item">
                            <div class="watch-row">
                                <div>
                                    <span class="watch-title">No watches yet</span>
                                    <p class="watch-preview">Add your first page to start tracking meaningful updates.</p>
                                </div>
                                <span class="watch-date">new</span>
                            </div>
                        </div>
                    @else
                        @foreach ($watches as $watch)
                            <a href="{{ route('watches.show', $watch) }}" class="watch-item">
                                <div class="watch-row">
                                    <div>
                                        <span class="watch-title">{{ Str::limit($watch->url, 80) }}</span>
                                        <p class="watch-preview">
                                            {{ $watch->css_selector ? 'Scoped to: ' . $watch->css_selector : 'Monitoring the full page for meaningful changes.' }}
                                        </p>
                                    </div>
                                    <span class="watch-date">{{ $watch->last_checked_at ? $watch->last_checked_at->format('M j, Y') : 'New' }}</span>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>