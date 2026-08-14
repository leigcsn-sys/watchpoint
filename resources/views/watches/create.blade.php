<x-app-layout>
    <x-slot name="header">
        <p class="text-xs font-medium tracking-widest text-[#F5A524] uppercase mb-1">New</p>
        <h2 class="font-['Space_Grotesk'] font-semibold text-2xl text-[#E7ECF5]">
            Add a Watch
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#121B2E] border border-[#253449] rounded-xl p-7">

                @if ($errors->any())
                    <div class="mb-5 p-4 bg-[#F87171]/10 border border-[#F87171]/30 rounded-lg">
                        <ul class="text-sm text-[#F87171] space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('watches.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="url" class="block text-sm font-medium text-[#E7ECF5] mb-1.5">Page URL</label>
                        <input type="url" name="url" id="url" required value="{{ old('url') }}"
                               placeholder="https://example.com/page"
                               class="w-full rounded-lg bg-[#0B1120] border-[#253449] text-[#E7ECF5] font-['JetBrains_Mono'] text-sm placeholder:text-[#8996AC]/60 focus:border-[#F5A524] focus:ring-[#F5A524]/20">
                    </div>

                    <div>
                        <label for="css_selector" class="block text-sm font-medium text-[#E7ECF5] mb-1.5">
                            CSS Selector <span class="text-[#8996AC] font-normal">— optional</span>
                        </label>
                        <input type="text" name="css_selector" id="css_selector" value="{{ old('css_selector') }}"
                               placeholder="#main-content, .article-body"
                               class="w-full rounded-lg bg-[#0B1120] border-[#253449] text-[#E7ECF5] font-['JetBrains_Mono'] text-sm placeholder:text-[#8996AC]/60 focus:border-[#F5A524] focus:ring-[#F5A524]/20">
                        <p class="text-xs text-[#8996AC] mt-1.5">Scopes tracking to one part of the page. Leave blank to watch the whole page.</p>
                    </div>

                    <div>
                        <label for="check_frequency_minutes" class="block text-sm font-medium text-[#E7ECF5] mb-1.5">Check Frequency</label>
                        <div class="relative">
                            <input type="number" name="check_frequency_minutes" id="check_frequency_minutes" required
                                   value="{{ old('check_frequency_minutes', 60) }}" min="5"
                                   class="w-full rounded-lg bg-[#0B1120] border-[#253449] text-[#E7ECF5] text-sm focus:border-[#F5A524] focus:ring-[#F5A524]/20">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-[#8996AC]">minutes</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit"
                                class="px-5 py-2.5 bg-[#F5A524] text-[#0B1120] rounded-lg text-sm font-semibold hover:bg-[#FFBB43] transition-colors">
                            Create Watch
                        </button>
                        <a href="{{ route('watches.index') }}" class="text-sm text-[#8996AC] hover:text-[#E7ECF5] transition-colors">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>