<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Your Watches
            </h2>
            <a href="{{ route('watches.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm hover:bg-gray-700">
                Add Watch
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if ($watches->isEmpty())
                    <div class="p-6 text-center text-gray-500">
                        No watches yet. <a href="{{ route('watches.create') }}" class="text-blue-600 underline">Add your first one</a>.
                    </div>
                @else
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-6 py-3">URL</th>
                                <th class="px-6 py-3">Last Checked</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($watches as $watch)
                                <tr>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('watches.show', $watch) }}" class="text-blue-600 hover:underline">
                                            {{ Str::limit($watch->url, 50) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $watch->last_checked_at?->diffForHumans() ?? 'Never' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $watch->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $watch->is_active ? 'Active' : 'Paused' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('watches.destroy', $watch) }}" method="POST" onsubmit="return confirm('Delete this watch?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 text-sm hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>