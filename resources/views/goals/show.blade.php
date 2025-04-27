<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">{{ $goal->title }}</h1>

        <p class="mb-4 text-gray-700">{{ $goal->description }}</p>

        <p class="text-gray-600 mb-4">
            <strong>Deadline:</strong> {{ $goal->deadline ?? 'No deadline' }}
        </p>

        <p class="text-green-600 font-semibold mb-6">
            <strong>Progress:</strong> {{ $goal->progress }}%
        </p>

        <a href="{{ route('goals.index') }}" class="inline-block bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
            Back to Goals
        </a>

        <!-- 🔥 Steps Section -->
        <div class="mt-10">
            <h2 class="text-xl font-bold mb-4">Steps</h2>

            @if ($goal->steps->count())
                <ul class="space-y-4">
                    @foreach ($goal->steps as $step)
                        <li class="flex items-center justify-between p-3 bg-gray-100 rounded">
                            <div class="flex items-center">
                                <!-- Toggle Step Completion -->
                                <form method="POST" action="{{ route('steps.toggle', [$goal, $step]) }}" class="flex items-center">
                                    @csrf
                                    @method('PATCH')

                                    <input type="checkbox" onchange="this.form.submit()" {{ $step->is_completed ? 'checked' : '' }} class="mr-2">
                                    <span class="{{ $step->is_completed ? 'line-through text-gray-500' : '' }}">
                                        {{ $step->title }}
                                    </span>
                                </form>
                            </div>

                            <!-- Delete Step -->
                            <form method="POST" action="{{ route('steps.destroy', [$goal, $step]) }}" onsubmit="return confirm('Are you sure you want to delete this step?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                    Delete
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">No steps added yet.</p>
            @endif

            <!-- Add New Step Form -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold mb-2">Add a New Step</h3>

                <form method="POST" action="{{ route('steps.store', $goal) }}">
                    @csrf

                    <div class="mb-4">
                        <input type="text" name="title" placeholder="Step title" class="w-full border p-2 rounded" required>
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Add Step
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
