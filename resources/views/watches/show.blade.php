<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-xs font-medium tracking-widest text-[#F5A524] uppercase mb-1">Watch Details</p>
                <h2 class="font-['Space_Grotesk'] font-semibold text-2xl text-[#E7ECF5]">Overview</h2>
            </div>
            <a href="{{ route('watches.index') }}" class="text-sm text-[#8996AC] hover:text-[#E7ECF5] transition-colors">
                &larr; All watches
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-5">

            @if (session('status'))
                <div class="p-4 bg-[#34D399]/10 border border-[#34D399]/30 text-[#34D399] rounded-lg text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-[#121B2E] border border-[#253449] rounded-xl p-6">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <p class="text-xs text-[#8996AC] mb-1">Tracking</p>
                        <a href="{{ $watch->url }}" target="_blank"
                           class="font-['JetBrains_Mono'] text-sm text-[#38BDF8] hover:underline break-all">
                            {{ $watch->url }}
                        </a>
                    </div>
                    <form action="{{ route('watches.check', $watch) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 bg-[#F5A524] text-[#0B1120] rounded-lg text-sm font-semibold hover:bg-[#FFBB43] transition-colors whitespace-nowrap">
                            Check Now
                        </button>
                    </form>
                </div>

                @if ($watch->last_error)
                    <div class="mt-4 p-3 bg-[#F87171]/10 border border-[#F87171]/30 rounded-lg">
                        <p class="text-xs text-[#F87171]">{{ $watch->last_error }}</p>
                    </div>
                @endif

                <div class="mt-6 grid grid-cols-3 gap-4 pt-5 border-t border-[#253449]">
                    <div>
                        <p class="text-xs text-[#8996AC] mb-1">Frequency</p>
                        <p class="text-sm text-[#E7ECF5] font-medium">Every {{ $watch->check_frequency_minutes }} min</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#8996AC] mb-1">Last Checked</p>
                        <p class="text-sm text-[#E7ECF5] font-medium">{{ $watch->last_checked_at?->diffForHumans() ?? 'Never' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#8996AC] mb-1">Scope</p>
                        <p class="text-sm text-[#E7ECF5] font-medium font-['JetBrains_Mono']">{{ $watch->css_selector ?? 'Full page' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-[#121B2E] border border-[#253449] rounded-xl p-6">
                <h3 class="font-['Space_Grotesk'] font-semibold text-[#E7ECF5] mb-5">Change History</h3>

                @if ($changeLogs->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-sm text-[#8996AC]">No changes detected yet.</p>
                        <p class="text-xs text-[#8996AC]/70 mt-1">Run a check to establish a baseline.</p>
                    </div>
                @else
                    <div class="space-y-5">
                        @foreach ($changeLogs as $log)
                            <div class="border-l-2 border-[#F5A524]/40 pl-4">
                                <p class="text-xs text-[#8996AC] mb-2">{{ $log->detected_at->diffForHumans() }}</p>
                                <div class="bg-[#0B1120] border border-[#253449] rounded-lg p-4 overflow-x-auto">
                                    <pre class="font-['JetBrains_Mono'] text-xs leading-relaxed">@foreach (explode("\n", $log->diff_summary) as $line)
@if (str_starts_with(ltrim($line), '+') && !str_starts_with(ltrim($line), '+++'))<span class="text-[#34D399]">{{ $line }}</span>
@elseif (str_starts_with(ltrim($line), '-') && !str_starts_with(ltrim($line), '---'))<span class="text-[#F87171]">{{ $line }}</span>
@else<span class="text-[#8996AC]">{{ $line }}</span>
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