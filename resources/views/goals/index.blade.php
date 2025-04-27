<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">My Goals</h1>

        <!-- Filter form for visibility -->
        <div class="mb-4">
            <form method="GET" action="{{ route('goals.index') }}">
                <label for="visibility" class="block font-semibold mb-2">Filter by Visibility</label>
                <select name="visibility" id="visibility" class="w-full border p-2 rounded">
                    <option value="">All</option>
                    <option value="private" {{ request('visibility') == 'private' ? 'selected' : '' }}>Private</option>
                    <option value="public" {{ request('visibility') == 'public' ? 'selected' : '' }}>Public</option>
                </select>
                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
            </form>
        </div>

        <!-- Button to create new goal -->
        <div class="mb-6">
            <a href="{{ route('goals.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                + Create New Goal
            </a>
        </div>

        <!-- Displaying goals -->
        @if ($goals->count())
            <div class="space-y-6">
                @foreach ($goals as $goal)
                    <div class="p-4 border rounded shadow-sm bg-white flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold">{{ $goal->title }}</h2>
                            <p class="text-gray-600 text-sm">Progress: {{ $goal->progress }}%</p>
                            @if($goal->deadline)
                                <p class="text-gray-500 text-sm">Deadline: {{ $goal->deadline }}</p>
                            @endif
                        </div>

                        <div class="flex items-center space-x-4">
                            <a href="{{ route('goals.show', $goal) }}" class="text-blue-500 hover:underline">View</a>
                            
                            <form method="POST" action="{{ route('goals.destroy', $goal) }}" onsubmit="return confirm('Are you sure you want to delete this goal?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">You have no goals yet. Start by creating one!</p>
        @endif
    </div>
</x-app-layout>
