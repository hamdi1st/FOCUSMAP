<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @endpush

    <div class="max-w-2xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Edit Goal</h1>

        <form method="POST" action="{{ route('goals.update', $goal->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Title</label>
                <input type="text" name="title" class="w-full border p-2 rounded" value="{{ old('title', $goal->title) }}" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Description</label>
                <textarea name="description" class="w-full border p-2 rounded" rows="4">{{ old('description', $goal->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Deadline</label>
                <input type="date" name="deadline" class="w-full border p-2 rounded" value="{{ old('deadline', $goal->deadline) }}">
            </div>

            <div class="mb-4">
                <label for="visibility" class="block mb-1 font-semibold">Visibility</label>
                <select name="visibility" id="visibility" class="w-full border p-2 rounded">
                    <option value="private" {{ old('visibility', $goal->visibility) == 'private' ? 'selected' : '' }}>Private</option>
                    <option value="public" {{ old('visibility', $goal->visibility) == 'public' ? 'selected' : '' }}>Public</option>
                </select>
            </div>

            <!-- Hidden Inputs for Latitude and Longitude -->
            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $goal->latitude) }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $goal->longitude) }}">

            <!-- Map to Select Location -->
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Pick a location (optional)</label>
                <div id="map" class="w-full h-64 rounded border"></div>
            </div>

            <!-- Image Upload Field -->
           <div class="mb-4">
          <label class="block mb-1 font-semibold">Current Image</label>
          @if ($goal->image_path)
           <img src="{{ asset('storage/' . $goal->image_path) }}" alt="Goal Image" class="w-48 h-auto mb-2 rounded">
          @else
           <p class="text-sm text-gray-500 italic">No image uploaded.</p>
           @endif

           <label class="block mt-2 font-semibold">Upload New Image</label>
           <input type="file" name="image" class="w-full border p-2 rounded">
         </div>


            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save Changes</button>
        </form>

        <script>
document.addEventListener('DOMContentLoaded', function () {
    // Check if the goal has valid latitude and longitude
    var lat = {{ $goal->latitude ?? 'null' }};
    var lng = {{ $goal->longitude ?? 'null' }};
    
    // Ensure lat and lng are valid numbers, defaulting to 0 if they are null
    if (lat === null || lng === null) {
        lat = 0;
        lng = 0;
    }

    // Initialize the map with valid coordinates
    var map = L.map('map').setView([lat, lng], 2); // Lower zoom level (2) for a world view if no location
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    var marker;

    map.on('click', function (e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        // If marker exists, move it; else, create it
        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }

        // Update hidden inputs
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    });

    // Pre-set the marker if there are coordinates
    if (lat !== 0 || lng !== 0) {
        marker = L.marker([lat, lng]).addTo(map);
        map.setView([lat, lng], 13); // Zoom in on the marker if coordinates are present
    }
});


        </script>

    </div>
</x-app-layout>
