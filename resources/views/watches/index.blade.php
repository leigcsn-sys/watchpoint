<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="eyebrow mb-2">01 — watches</p>
                <h2 class="text-3xl font-semibold tracking-tight text-[#111827]">Your Watches</h2>
            </div>
            <a href="{{ route('watches.create') }}" class="primary-button">
                + Add Watch
            </a>
        </div>
    </x-slot>

    <div class="app-shell">
        <div class="mx-auto max-w-4xl">
            @if (session('status'))
                <p role="status" class="mb-6 rounded-xl border border-[#dfe3e8] bg-white/80 px-4 py-3 text-sm text-[#111827] shadow-sm">
                    <span class="font-['JetBrains_Mono'] text-[11px] uppercase tracking-[0.18em] text-[#6B7280]">status</span>
                    <span class="ml-3">{{ session('status') }}</span>
                </p>
            @endif

            @if ($watches->isEmpty())
                <div class="panel py-16 text-center">
                    <p class="mb-3 text-lg font-medium text-[#111827]">Nothing being watched yet.</p>
                    <p class="mb-5 text-sm text-[#6B7280]">Add a page to start tracking changes.</p>
                    <a href="{{ route('watches.create') }}" class="secondary-button">
                        Add your first one
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($watches as $watch)
                        <div class="panel group flex flex-col gap-4 p-5 transition duration-200 hover:-translate-y-0.5 hover:shadow-[0_20px_40px_-30px_rgba(17,24,39,0.55)] sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0 flex-1">
                                <div class="mb-2 flex items-center gap-2">
                                    <span class="inline-block h-2.5 w-2.5 rounded-full {{ $watch->is_active ? 'bg-[#22C55E]' : 'bg-[#D1D5DB]' }}"></span>
                                    <span class="font-['JetBrains_Mono'] text-[10px] uppercase tracking-[0.2em] text-[#6B7280]">
                                        {{ $watch->is_active ? 'active' : 'paused' }} &middot; every {{ $watch->check_frequency_minutes }}m
                                    </span>
                                </div>
                                <a href="{{ route('watches.show', $watch) }}" class="block break-words text-base font-medium text-[#111827] transition group-hover:text-[#111827] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#111827] focus-visible:ring-offset-2">
                                    {{ $watch->url }}
                                </a>
                                <p class="mt-2 text-sm text-[#6B7280]">
                                    last checked {{ $watch->last_checked_at?->diffForHumans() ?? 'never' }}
                                </p>
                            </div>

                            <form action="{{ route('watches.destroy', $watch) }}" method="POST" onsubmit="return confirm('Delete this watch?')" class="shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" aria-label="Remove {{ $watch->url }}" class="font-['JetBrains_Mono'] text-[10px] uppercase tracking-[0.18em] text-[#6B7280] transition hover:text-[#DC2626] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#DC2626] focus-visible:ring-offset-2">
                                    remove
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>