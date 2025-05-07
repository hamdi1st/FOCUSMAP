<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">{{ $goal->title }}</h1>

        @if ($goal->image_path)
      <div class="mt-6">
        <h3 class="text-xl font-semibold mb-2">Goal Image</h3>
        <img src="{{ asset('storage/' . $goal->image_path) }}" alt="Goal Image" class="w-full h-auto rounded">
      </div>
    @endif



        <p class="mb-4 text-gray-700">{{ $goal->description }}</p>

        <p class="text-gray-600 mb-4">
            <strong>Deadline:</strong> {{ $goal->deadline ?? 'No deadline' }}
        </p>

        <p class="text-green-600 font-semibold mb-6">
            <strong>Progress:</strong> {{ $goal->progress }}%
        </p>

        @if ($goal->latitude && $goal->longitude)
          <div class="my-6">
            <h2 class="text-xl font-semibold mb-2">Location</h2>
           <div id="goal-map" class="w-full h-64 rounded border"></div>
         </div>

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('goal-map').setView([{{ $goal->latitude }}, {{ $goal->longitude }}], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            // Custom Marker Icon
            var goalIcon = L.icon({
                iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/svgs/solid/star.svg', // Valid Star Icon URL
                iconSize: [32, 32], // Size of the icon
                iconAnchor: [16, 32], // Point of the icon which will correspond to marker's location
                popupAnchor: [0, -32] // Point from which the popup should open relative to the iconAnchor
            });

            // Add custom marker with popup
            L.marker([{{ $goal->latitude }}, {{ $goal->longitude }}], { icon: goalIcon })
                .addTo(map)
                .bindPopup('📍 Goal Location')
                .openPopup();
        });
    </script>
@endpush



        @push('styles')
           <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        @endpush
    @endif


    <div class="flex flex-wrap gap-3 mb-6">
    <a href="{{ route('goals.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
        Back to Goals
    </a>

    <a href="{{ route('goals.mindmap', $goal->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
        🧠 View Mind Map
    </a>

    <form action="{{ route('goals.destroy', $goal) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this goal? This action cannot be undone.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
            Delete Goal
        </button>
    </form>
</div>



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
