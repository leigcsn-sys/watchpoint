<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add a Watch
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-md">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('watches.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="url" class="block text-sm font-medium text-gray-700">Page URL</label>
                        <input type="url" name="url" id="url" required
                               value="{{ old('url') }}"
                               placeholder="https://example.com/page"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label for="css_selector" class="block text-sm font-medium text-gray-700">
                            CSS Selector <span class="text-gray-400 font-normal">(optional — scopes tracking to one part of the page)</span>
                        </label>
                        <input type="text" name="css_selector" id="css_selector"
                               value="{{ old('css_selector') }}"
                               placeholder="e.g. #main-content, .article-body"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label for="check_frequency_minutes" class="block text-sm font-medium text-gray-700">
                            Check Frequency (minutes)
                        </label>
                        <input type="number" name="check_frequency_minutes" id="check_frequency_minutes" required
                               value="{{ old('check_frequency_minutes', 60) }}" min="5"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm hover:bg-gray-700">
                            Create Watch
                        </button>
                        <a href="{{ route('watches.index') }}" class="text-sm text-gray-500 hover:underline">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>