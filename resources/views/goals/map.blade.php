<x-app-layout>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush

<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">My Goal Map</h1>

    <div id="map" class="w-full h-[600px] rounded border"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([20, 0], 2); // World view
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            @foreach($goals as $goal)
                L.marker([{{ $goal->latitude }}, {{ $goal->longitude }}])
                    .addTo(map)
                    .bindPopup("<b>{{ $goal->title }}</b>");
            @endforeach
        });
    </script>
</div>

</x-app-layout>
