<x-app-layout>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush


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

            <div class="mb-4">
              <label for="visibility" class="block mb-1 font-semibold">Visibility</label>
              <select name="visibility" id="visibility" class="w-full border p-2 rounded">
              <option value="private" {{ old('visibility', 'private') == 'private' ? 'selected' : '' }}>Private</option>
              <option value="public" {{ old('visibility', 'private') == 'public' ? 'selected' : '' }}>Public</option>
             </select>
            </div>


             <input type="hidden" name="latitude" id="latitude">
             <input type="hidden" name="longitude" id="longitude">

             
             <div class="mb-4">
                <label class="block mb-1 font-semibold">Pick a location (optional)</label>
                <div id="map" class="w-full h-64 rounded border"></div>
             </div>


        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
         Save Goal
        </button>

       </form>
       <script>
           document.addEventListener('DOMContentLoaded', function () {
           var map = L.map('map').setView([20, 0], 2); // World view
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
            });
   </script>

    </div>
</x-app-layout>
