<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Watch Details
            </h2>
            <a href="{{ route('watches.index') }}" class="text-sm text-gray-500 hover:underline">
                &larr; Back to all watches
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">URL</p>
                        <a href="{{ $watch->url }}" target="_blank" class="text-blue-600 hover:underline break-all">
                            {{ $watch->url }}
                        </a>
                    </div>
                    <form action="{{ route('watches.check', $watch) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm hover:bg-gray-700 whitespace-nowrap">
                            Check Now
                        </button>
                    </form>
                </div>

                <div class="mt-4 grid grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Frequency</p>
                        <p class="font-medium">Every {{ $watch->check_frequency_minutes }} min</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Last Checked</p>
                        <p class="font-medium">{{ $watch->last_checked_at?->diffForHumans() ?? 'Never' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">CSS Selector</p>
                        <p class="font-medium">{{ $watch->css_selector ?? 'Full page' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Change History</h3>

                @if ($changeLogs->isEmpty())
                    <p class="text-gray-500 text-sm">No changes detected yet. Click "Check Now" to run the first check.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($changeLogs as $log)
                            <div class="border-l-4 border-gray-300 pl-4 py-1">
                                <p class="text-sm text-gray-500">{{ $log->detected_at->diffForHumans() }}</p>
                                <pre class="mt-2 text-xs bg-gray-50 p-3 rounded-md overflow-x-auto whitespace-pre-wrap">{{ $log->diff_summary }}</pre>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>