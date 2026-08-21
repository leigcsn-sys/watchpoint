<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="eyebrow mb-2">03 — detail</p>
                <h2 class="text-3xl font-semibold tracking-tight text-[#111827]">Watch Overview</h2>
            </div>
            <a href="{{ route('watches.index') }}" class="secondary-button">
                &larr; All Watches
            </a>
        </div>
    </x-slot>

    <div class="app-shell" @if ($watch->is_checking) x-data x-init="setTimeout(() => window.location.reload(), 5000)" @endif>
        <div class="mx-auto max-w-4xl space-y-8">
            @if (session('status'))
                <p role="status" class="rounded-xl border border-[#dfe3e8] bg-white/80 px-4 py-3 text-sm text-[#111827] shadow-sm">
                    <span class="font-['JetBrains_Mono'] text-[10px] uppercase tracking-[0.18em] text-[#6B7280]">status</span>
                    <span class="ml-3">{{ session('status') }}</span>
                </p>
            @endif

            <div class="panel p-5 sm:p-6">
                <div class="flex flex-col gap-5 border-b border-[#e5e7eb] pb-6 sm:flex-row sm:items-start sm:justify-between">
                    <div class="min-w-0">
                        <p class="section-label mb-2">Tracking</p>
                        <a href="{{ $watch->url }}" target="_blank" rel="noopener noreferrer"
                           class="break-words font-['JetBrains_Mono'] text-sm text-[#111827] hover:text-[#374151] hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[#111827] focus-visible:ring-offset-2">
                            {{ $watch->url }}
                        </a>
                    </div>
                    <form action="{{ route('watches.check', $watch) }}" method="POST">
                        @csrf
                        <button type="submit" @disabled($watch->is_checking)
                                class="primary-button w-full whitespace-nowrap sm:w-auto disabled:cursor-wait disabled:bg-[#9CA3AF]">
                            {{ $watch->is_checking ? 'Checking...' : 'Check Now' }}
                        </button>
                    </form>
                </div>

                @if ($watch->last_error)
                    <div role="alert" class="mt-5 rounded-xl border border-[#FECACA] bg-[#FEF2F2] p-4">
                        <p class="font-['JetBrains_Mono'] text-[10px] uppercase tracking-[0.18em] text-[#B91C1C]">check failed</p>
                        <p class="mt-2 text-sm text-[#7F1D1D] break-words">{{ Str::limit($watch->last_error, 220) }}</p>
                        <p class="mt-2 font-['JetBrains_Mono'] text-[10px] uppercase tracking-[0.18em] text-[#991B1B]">Run Check Now to retry.</p>
                    </div>
                @elseif ($watch->is_checking)
                    <div role="status" class="mt-5 rounded-xl border border-[#FDE68A] bg-[#FFFBEB] p-4">
                        <p class="font-['JetBrains_Mono'] text-[10px] uppercase tracking-[0.18em] text-[#92400E]">check queued</p>
                        <p class="mt-2 text-sm text-[#78350F]">The page will be fetched in the background.</p>
                    </div>
                @endif

                <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-xl border border-[#e5e7eb] bg-[#F9FAFB] p-4">
                        <p class="section-label mb-2">frequency</p>
                        <p class="text-sm font-medium text-[#111827]">every {{ $watch->check_frequency_minutes }}m</p>
                    </div>
                    <div class="rounded-xl border border-[#e5e7eb] bg-[#F9FAFB] p-4">
                        <p class="section-label mb-2">last checked</p>
                        <p class="text-sm font-medium text-[#111827]">{{ $watch->last_checked_at?->diffForHumans() ?? 'never' }}</p>
                    </div>
                    <div class="rounded-xl border border-[#e5e7eb] bg-[#F9FAFB] p-4">
                        <p class="section-label mb-2">scope</p>
                        <p class="font-['JetBrains_Mono'] text-sm text-[#111827]">{{ $watch->css_selector ?? 'full page' }}</p>
                    </div>
                </div>
            </div>

            <div class="panel p-5 sm:p-6">
                <p class="section-label mb-5">change history</p>

                @if ($changeLogs->isEmpty())
                    <p class="rounded-xl border border-dashed border-[#dfe3e8] bg-[#F9FAFB] px-4 py-8 text-sm text-[#6B7280]">
                        No changes detected yet. Run a check to establish a baseline.
                    </p>
                @else
                    <div class="space-y-5">
                        @foreach ($changeLogs as $log)
                            <div class="rounded-xl border border-[#e5e7eb] bg-[#F9FAFB] p-4">
                                <div class="mb-3 flex items-center gap-3">
                                    <span class="font-['JetBrains_Mono'] text-[10px] uppercase tracking-[0.18em] text-[#9CA3AF]">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="font-['JetBrains_Mono'] text-[10px] uppercase tracking-[0.18em] text-[#6B7280]">{{ $log->detected_at->diffForHumans() }}</span>
                                </div>
                                <div class="overflow-x-auto rounded-lg border border-[#e5e7eb] bg-white p-3">
                                    <pre class="font-['JetBrains_Mono'] text-[11px] leading-relaxed">@foreach (explode("\n", $log->diff_summary) as $line)
@if (str_starts_with(ltrim($line), '+') && !str_starts_with(ltrim($line), '+++'))<span class="text-[#059669]">{{ $line }}</span>
@elseif (str_starts_with(ltrim($line), '-') && !str_starts_with(ltrim($line), '---'))<span class="text-[#DC2626]">{{ $line }}</span>
@else<span class="text-[#6B7280]">{{ $line }}</span>
@endif
@endforeach</pre>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>