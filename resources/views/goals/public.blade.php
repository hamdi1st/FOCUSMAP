<x-app-layout> 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Public Goals</h2>
    </x-slot>

    <div class="py-10 max-w-5xl mx-auto px-4">
        <h3 class="text-2xl font-semibold mb-6 text-center">Explore Goals Shared by Others</h3>

        @forelse ($publicGoals as $goal)
            <div class="mb-6 p-6 border border-gray-200 rounded-lg shadow-sm bg-white">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="text-xl font-bold text-indigo-700">{{ $goal->title }}</h4>
                        <p class="text-gray-800 mt-1">{{ $goal->description }}</p>
                        <p class="text-sm text-gray-500 mt-2">
                            By <span class="font-medium text-gray-700">{{ $goal->user->name }}</span> |
                            Progress: {{ $goal->progress }}% 
                            @if ($goal->deadline)
                                | Deadline: {{ \Carbon\Carbon::parse($goal->deadline)->format('M d, Y') }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center">No public goals available yet.</p>
        @endforelse

        <div class="mt-6">
            {{ $publicGoals->links() }}
        </div>
    </div>
</x-app-layout>
