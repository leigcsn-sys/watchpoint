<x-app-layout>
    <x-slot name="header">
        <p class="font-['JetBrains_Mono'] text-xs text-[#9CA3AF] tracking-widest uppercase mb-1">02 — new</p>
        <h2 class="text-2xl text-[#111111]">Add a Watch</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-6 pb-4 border-b border-[#111111]">
                    <ul class="font-['JetBrains_Mono'] text-xs text-[#111111] space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>&rarr; {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('watches.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="url" class="block font-['JetBrains_Mono'] text-xs uppercase tracking-widest text-[#9CA3AF] mb-2">Page URL</label>
                    <input type="url" name="url" id="url" required
                           value="{{ old('url') }}"
                           placeholder="https://example.com/page"
                           class="w-full border-0 border-b border-[#E5E5E5] font-['JetBrains_Mono'] text-sm text-[#111111] px-0 py-2 focus:border-[#111111] focus:ring-0 placeholder:text-[#D1D5DB]">
                </div>

                <div>
                    <label for="css_selector" class="block font-['JetBrains_Mono'] text-xs uppercase tracking-widest text-[#9CA3AF] mb-2">
                        CSS Selector <span class="normal-case text-[#D1D5DB]">(optional)</span>
                    </label>
                    <input type="text" name="css_selector" id="css_selector" value="{{ old('css_selector') }}"
                           placeholder="#main-content"
                           class="w-full border-0 border-b border-[#E5E5E5] font-['JetBrains_Mono'] text-sm text-[#111111] px-0 py-2 focus:border-[#111111] focus:ring-0 placeholder:text-[#D1D5DB]">
                </div>

                <div>
                    <label for="check_frequency_minutes" class="block font-['JetBrains_Mono'] text-xs uppercase tracking-widest text-[#9CA3AF] mb-2">Check Frequency (minutes)</label>
                    <input type="number" name="check_frequency_minutes" id="check_frequency_minutes" required
                           value="{{ old('check_frequency_minutes', 60) }}" min="5"
                           class="w-full border-0 border-b border-[#E5E5E5] font-['JetBrains_Mono'] text-sm text-[#111111] px-0 py-2 focus:border-[#111111] focus:ring-0">
                </div>

                <div class="flex items-center gap-6 pt-4">
                    <button type="submit"
                            class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest bg-[#111111] text-white px-6 py-3 hover:bg-[#333333] transition-colors">
                        Create Watch
                    </button>
                    <a href="{{ route('watches.index') }}" class="font-['JetBrains_Mono'] text-xs uppercase tracking-widest text-[#9CA3AF] hover:text-[#111111]">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>