<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Create a New Goal</h1>

        <form method="POST" action="{{ route('goals.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Title</label>
                <input type="text" name="title" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Description</label>
                <textarea name="description" class="w-full border p-2 rounded" rows="4"></textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Deadline</label>
                <input type="date" name="deadline" class="w-full border p-2 rounded">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
    Save Goal
</button>

        </form>
    </div>
</x-app-layout>
