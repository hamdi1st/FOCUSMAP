<x-app-layout>

<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Mind Map for: {{ $goal->title }}</h1>

    <div id="jsmind_container" class="border h-[600px] w-full rounded shadow"></div>
</div>

@push('styles')
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsmind/style/jsmind.css" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jsmind/js/jsmind.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const mind = {
            meta: {
                name: "goal_mindmap",
                author: "you",
                version: "1.0"
            },
            format: "node_tree",
            data: {
                id: "root",
                topic: "{{ addslashes($goal->title) }}",
                children: [
                    @foreach($goal->steps as $step)
                        {
                            id: "{{ $step->id }}",
                            topic: "{{ addslashes($step->title) }}"
                        },
                    @endforeach
                ]
            }
        };

        const options = {
            container: 'jsmind_container',
            theme: 'primary',
            editable: true
        };

        const jm = new jsMind(options);
        jm.show(mind);
    });
    </script>
@endpush

</x-app-layout>
