<x-app-layout>
    <div class="watchpoint-shell">
        <header class="watchpoint-header">
            <span class="watchpoint-kicker">watchpoint</span>
            <a href="{{ route('watches.create') }}" class="watchpoint-link">+ add watch</a>
        </header>

        <div class="watchpoint-hero">
            <div>
                <h1 class="watchpoint-title">Watch what matters.</h1>
                <p class="watchpoint-subtitle">
                    Track the pages you care about and get notified when the important parts change.
                </p>
            </div>

            <div class="watchpoint-actions">
                <a href="{{ route('watches.create') }}" class="primary-button">+ Add Watch</a>
            </div>
        </div>

        @if (session('status'))
            <p role="status" class="watchpoint-status">
                <span class="watchpoint-inline-label">status</span>
                <span>{{ session('status') }}</span>
            </p>
        @endif

        <div class="watchpoint-section">
            <span class="watchpoint-inline-label">01 — watches</span>
            <a href="{{ route('watches.create') }}" class="watchpoint-link">all watches →</a>
        </div>

        <div class="watchpoint-list">
            @if ($watches->isEmpty())
                <article class="watchpoint-item empty-state">
                    <div class="watchpoint-row">
                        <div class="watchpoint-copy">
                            <p class="watchpoint-item-title">No watches yet</p>
                            <p class="watchpoint-preview">Add your first page to start monitoring meaningful updates.</p>
                        </div>
                        <span class="watchpoint-date">new</span>
                    </div>
                </article>
            @else
                @foreach ($watches as $watch)
                    <article class="watchpoint-item">
                        <a href="{{ route('watches.show', $watch) }}" class="watchpoint-row">
                            <div class="watchpoint-copy">
                                <p class="watchpoint-item-title">{{ Str::limit($watch->url, 80) }}</p>
                                <p class="watchpoint-preview">
                                    {{ $watch->css_selector ? 'Scoped to: ' . $watch->css_selector : 'Monitoring the full page for meaningful changes.' }}
                                </p>
                            </div>
                            <span class="watchpoint-date">{{ $watch->last_checked_at ? $watch->last_checked_at->format('M j, Y') : 'new' }}</span>
                        </a>
                    </article>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>