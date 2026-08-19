<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-baseline">
            <div>
                <p class="font-['JetBrains_Mono'] text-xs text-[#9CA3AF] tracking-widest uppercase mb-1">03 — detail</p>
                <h2 class="text-2xl text-[#111111]">Watch Overview</h2>
            </div>
            <a href="{{ route('watches.index') }}" class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest text-[#9CA3AF] hover:text-[#111111]">
                &larr; all watches
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-10">

            @if (session('status'))
                <p role="status" class="font-['JetBrains_Mono'] text-xs text-[#111111] pb-3 border-b border-[#E5E5E5]">&rarr; {{ session('status') }}</p>
            @endif

            <div>
                <div class="flex flex-col items-stretch gap-5 pb-6 border-b border-[#111111] sm:flex-row sm:items-start sm:justify-between sm:gap-4">
                    <div class="min-w-0">
                        <p class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest text-[#9CA3AF] mb-1">tracking</p>
                                <a href="{{ $watch->url }}" target="_blank" rel="noopener noreferrer"
                                    class="font-['JetBrains_Mono'] text-sm text-[#111111] hover:underline break-words focus:outline-none focus-visible:ring-2 focus-visible:ring-[#111111] focus-visible:ring-offset-4">
                            {{ $watch->url }}
                        </a>
                    </div>
                    <form action="{{ route('watches.check', $watch) }}" method="POST">
                        @csrf
                        <button type="submit" @disabled($watch->is_checking)
                                class="w-full sm:w-auto font-['JetBrains_Mono'] text-xs uppercase tracking-widest bg-[#111111] text-white px-5 py-3 hover:bg-[#333333] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#111111] focus-visible:ring-offset-4 transition-colors whitespace-nowrap disabled:cursor-wait disabled:bg-[#9CA3AF]">
                            {{ $watch->is_checking ? 'Checking...' : 'Check Now' }}
                        </button>
                    </form>
                </div>

                @if ($watch->last_error)
                    <div role="alert" class="mt-4 border-l-2 border-[#DC2626] bg-[#FEF2F2] px-4 py-3">
                        <p class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest text-[#B91C1C]">check failed</p>
                        <p class="text-sm text-[#7F1D1D] mt-1 break-words">{{ Str::limit($watch->last_error, 220) }}</p>
                        <p class="font-['JetBrains_Mono'] text-xs text-[#991B1B] mt-2">Run Check Now to retry.</p>
                    </div>
                @elseif ($watch->is_checking)
                    <div role="status" class="mt-4 border-l-2 border-[#D97706] bg-[#FFFBEB] px-4 py-3">
                        <p class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest text-[#92400E]">check queued</p>
                        <p class="text-sm text-[#78350F] mt-1">The page will be fetched in the background.</p>
                    </div>
                @endif

                <div class="grid grid-cols-1 gap-5 pt-6 sm:grid-cols-3 sm:gap-6">
                    <div>
                        <p class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest text-[#9CA3AF] mb-1">frequency</p>
                        <p class="text-sm text-[#111111]">every {{ $watch->check_frequency_minutes }}m</p>
                    </div>
                    <div>
                        <p class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest text-[#9CA3AF] mb-1">last checked</p>
                        <p class="text-sm text-[#111111]">{{ $watch->last_checked_at?->diffForHumans() ?? 'never' }}</p>
                    </div>
                    <div>
                        <p class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest text-[#9CA3AF] mb-1">scope</p>
                        <p class="font-['JetBrains_Mono'] text-sm text-[#111111]">{{ $watch->css_selector ?? 'full page' }}</p>
                    </div>
                </div>
            </div>

            <div>
                <p class="font-['JetBrains_Mono'] text-xs text-[#9CA3AF] tracking-widest uppercase mb-5">change history</p>

                @if ($changeLogs->isEmpty())
                    <p class="text-sm text-[#9CA3AF] py-6 border-t border-[#E5E5E5]">
                        No changes detected yet. Run a check to establish a baseline.
                    </p>
                @else
                    <div class="border-t border-[#E5E5E5]">
                        @foreach ($changeLogs as $index => $log)
                            <div class="py-6 border-b border-[#E5E5E5]">
                                <div class="flex items-baseline gap-3 mb-3">
                                    <span class="font-['JetBrains_Mono'] text-xs text-[#D1D5DB]">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="font-['JetBrains_Mono'] text-xs text-[#9CA3AF]">{{ $log->detected_at->diffForHumans() }}</span>
                                </div>
                                <div class="bg-[#FAFAFA] border border-[#E5E5E5] p-4 overflow-x-auto">
                                    <pre class="font-['JetBrains_Mono'] text-xs leading-relaxed">@foreach (explode("\n", $log->diff_summary) as $line)
@if (str_starts_with(ltrim($line), '+') && !str_starts_with(ltrim($line), '+++'))<span class="text-[#059669]">{{ $line }}</span>
@elseif (str_starts_with(ltrim($line), '-') && !str_starts_with(ltrim($line), '---'))<span class="text-[#DC2626]">{{ $line }}</span>
@else<span class="text-[#9CA3AF]">{{ $line }}</span>
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