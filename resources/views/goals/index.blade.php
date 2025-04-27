<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">My Goals</h1>

        @foreach ($goals as $goal)
            <div class="mb-4 p-4 border rounded shadow">
            <h2 class="text-xl font-semibold">
               <a href="{{ route('goals.show', $goal) }}" class="text-blue-600 hover:underline">
                {{ $goal->title }}
               </a>
            </h2>

                <p class="text-gray-700">{{ $goal->description }}</p>
                <p class="text-gray-500 text-sm">Deadline: {{ $goal->deadline ?? 'No deadline' }}</p>
                <p class="text-green-600 font-semibold">Progress: {{ $goal->progress }}%</p>

                <form method="POST" action="{{ route('goals.destroy', $goal) }}" onsubmit="return confirm('Are you sure you want to delete this goal?');" class="inline-block mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="mt-2 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                      Delete
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</x-app-layout>
