<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-baseline">
            <div>
                <p class="font-['JetBrains_Mono'] text-xs text-[#9CA3AF] tracking-widest uppercase mb-1">01 — watches</p>
                <h2 class="text-2xl text-[#111111]">Your Watches</h2>
            </div>
            <a href="{{ route('watches.create') }}"
               class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest border border-[#111111] text-[#111111] px-4 py-2 hover:bg-[#111111] hover:text-white transition-colors">
                + Add Watch
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <p class="font-['JetBrains_Mono'] text-xs text-[#111111] mb-6 pb-3 border-b border-[#E5E5E5]">
                    &rarr; {{ session('status') }}
                </p>
            @endif

            @if ($watches->isEmpty())
                <div class="py-16 text-center border-t border-b border-[#E5E5E5]">
                    <p class="text-[#6B7280] mb-2">Nothing being watched yet.</p>
                    <a href="{{ route('watches.create') }}" class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest text-[#111111] underline">
                        Add your first one &rarr;
                    </a>
                </div>
            @else
                <div class="border-t border-[#E5E5E5]">
                    @foreach ($watches as $watch)
                        <div class="flex items-center justify-between py-5 border-b border-[#E5E5E5] group">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $watch->is_active ? 'bg-[#111111]' : 'bg-[#D1D5DB]' }}"></span>
                                    <span class="font-['JetBrains_Mono'] text-[11px] uppercase tracking-widest text-[#9CA3AF]">
                                        {{ $watch->is_active ? 'active' : 'paused' }} &middot; every {{ $watch->check_frequency_minutes }}m
                                    </span>
                                </div>
                                <a href="{{ route('watches.show', $watch) }}"
                                   class="font-['JetBrains_Mono'] text-sm text-[#111111] group-hover:underline truncate block">
                                    {{ $watch->url }}
                                </a>
                                <p class="text-xs text-[#9CA3AF] mt-1">
                                    last checked {{ $watch->last_checked_at?->diffForHumans() ?? 'never' }}
                                </p>
                            </div>
                            <form action="{{ route('watches.destroy', $watch) }}" method="POST" onsubmit="return confirm('Delete this watch?')">
                                @csrf
                                @method('DELETE')
                                <button class="font-['JetBrains_Mono'] text-xs text-[#9CA3AF] hover:text-[#111111] transition-colors">
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