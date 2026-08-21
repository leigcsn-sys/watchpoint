<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="eyebrow mb-2">02 — new</p>
            <h2 class="text-3xl font-semibold tracking-tight text-[#111827]">Add a Watch</h2>
        </div>
    </x-slot>

    <div class="app-shell">
        <div class="mx-auto max-w-xl">
            @if ($errors->any())
                <div class="panel mb-6 border-[#FECACA] bg-[#FEF2F2] p-4 text-sm text-[#7F1D1D]">
                    <p class="mb-2 font-['JetBrains_Mono'] text-[10px] uppercase tracking-[0.18em] text-[#991B1B]">Please fix</p>
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>&rarr; {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('watches.store') }}" method="POST" class="panel space-y-6 p-5 sm:p-7">
                @csrf

                <div>
                    <label for="url" class="mb-2 block section-label">Page URL</label>
                    <input type="url" name="url" id="url" required
                           value="{{ old('url') }}"
                           placeholder="https://example.com/page"
                           class="field-input font-['JetBrains_Mono'] text-sm">
                </div>

                <div>
                    <label for="css_selector" class="mb-2 block section-label">
                        CSS Selector <span class="normal-case text-[#9CA3AF]">(optional)</span>
                    </label>
                    <input type="text" name="css_selector" id="css_selector" value="{{ old('css_selector') }}"
                           placeholder="#main-content"
                           class="field-input font-['JetBrains_Mono'] text-sm">
                </div>

                <div>
                    <label for="check_frequency_minutes" class="mb-2 block section-label">Check Frequency (minutes)</label>
                    <input type="number" name="check_frequency_minutes" id="check_frequency_minutes" required
                           value="{{ old('check_frequency_minutes', 60) }}" min="5"
                           class="field-input font-['JetBrains_Mono'] text-sm">
                </div>

                <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center">
                    <button type="submit" class="primary-button w-full sm:w-auto">
                        Create Watch
                    </button>
                    <a href="{{ route('watches.index') }}" class="secondary-button w-full sm:w-auto">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>