<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-baseline">
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
                <p class="font-['JetBrains_Mono'] text-xs text-[#111111] pb-3 border-b border-[#E5E5E5]">&rarr; {{ session('status') }}</p>
            @endif

            <div>
                <div class="flex items-start justify-between gap-4 pb-6 border-b border-[#111111]">
                    <div class="min-w-0">
                        <p class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest text-[#9CA3AF] mb-1">tracking</p>
                        <a href="{{ $watch->url }}" target="_blank"
                           class="font-['JetBrains_Mono'] text-sm text-[#111111] hover:underline break-all">
                            {{ $watch->url }}
                        </a>
                    </div>
                    <form action="{{ route('watches.check', $watch) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest bg-[#111111] text-white px-5 py-2.5 hover:bg-[#333333] transition-colors whitespace-nowrap">
                            Check Now
                        </button>
                    </form>
                </div>

                @if ($watch->last_error)
                    <p class="font-['JetBrains_Mono'] text-xs text-[#111111] mt-4 pt-4">&rarr; {{ $watch->last_error }}</p>
                @endif

                <div class="grid grid-cols-3 gap-6 pt-6">
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