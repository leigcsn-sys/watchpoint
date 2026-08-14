<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-xs font-medium tracking-widest text-[#F5A524] uppercase mb-1">Monitoring</p>
                <h2 class="font-['Space_Grotesk'] font-semibold text-2xl text-[#E7ECF5]">
                    Your Watches
                </h2>
            </div>
            <a href="{{ route('watches.create') }}"
               class="px-5 py-2.5 bg-[#F5A524] text-[#0B1120] rounded-lg text-sm font-semibold hover:bg-[#FFBB43] transition-colors">
                Add Watch
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('status'))
                <div class="p-4 bg-[#34D399]/10 border border-[#34D399]/30 text-[#34D399] rounded-lg text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            @if ($watches->isEmpty())
                <div class="border border-dashed border-[#253449] rounded-xl p-16 text-center">
                    <div class="w-12 h-12 mx-auto mb-4 rounded-full border-2 border-[#253449] flex items-center justify-center">
                        <div class="w-2 h-2 rounded-full bg-[#8996AC]"></div>
                    </div>
                    <p class="text-[#8996AC] mb-3">Nothing being watched yet.</p>
                    <a href="{{ route('watches.create') }}" class="text-[#F5A524] text-sm font-medium hover:underline">
                        Add your first watch &rarr;
                    </a>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($watches as $watch)
                        <div class="bg-[#121B2E] border border-[#253449] rounded-xl p-5 hover:border-[#F5A524]/40 transition-colors">
                            <div class="flex items-center justify-between gap-4">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2.5 mb-1.5">
                                        <span class="relative flex h-2 w-2">
                                            @if ($watch->is_active)
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#34D399] opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#34D399]"></span>
                                            @else
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#8996AC]"></span>
                                            @endif
                                        </span>
                                        <span class="text-xs font-medium {{ $watch->is_active ? 'text-[#34D399]' : 'text-[#8996AC]' }}">
                                            {{ $watch->is_active ? 'Active' : 'Paused' }}
                                        </span>
                                        <span class="text-xs text-[#8996AC]">&middot; every {{ $watch->check_frequency_minutes }} min</span>
                                    </div>
                                    <a href="{{ route('watches.show', $watch) }}"
                                       class="font-['JetBrains_Mono'] text-sm text-[#E7ECF5] hover:text-[#F5A524] transition-colors truncate block">
                                        {{ $watch->url }}
                                    </a>
                                    <p class="text-xs text-[#8996AC] mt-1">
                                        Last checked {{ $watch->last_checked_at?->diffForHumans() ?? 'never' }}
                                    </p>
                                </div>
                                <form action="{{ route('watches.destroy', $watch) }}" method="POST"
                                      onsubmit="return confirm('Delete this watch?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs text-[#8996AC] hover:text-[#F87171] transition-colors px-2 py-1">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>