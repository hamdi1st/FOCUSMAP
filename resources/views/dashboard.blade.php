<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $goals = Auth::user()->goals;
        $progress = $goals->avg('progress') ?? 0;
        $recentGoals = $goals->sortByDesc('created_at')->take(3);
    @endphp

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-2xl font-semibold mb-6">Welcome back, {{ Auth::user()->name }}!</h3>

                <div class="flex flex-wrap gap-4 mb-6">
                    <a href="{{ route('goals.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                        View All Goals
                    </a>
                    <a href="{{ route('goals.public') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded transition">
                        Browse Public Goals
                    </a>
                </div>

                <div>
                    <p class="text-gray-700 font-medium mb-2">Your Average Progress</p>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-blue-500 h-4 rounded-full transition-all duration-300" style="width: {{ round($progress) }}%"></div>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">{{ round($progress) }}% complete across all goals</p>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h4 class="text-xl font-semibold mb-6">Recent Goals</h4>
                <ul class="space-y-6">
                    @forelse($recentGoals as $goal)
                        @php
                            $completed = $goal->steps->where('is_completed', true)->count();
                            $incomplete = $goal->steps->where('is_completed', false)->count();
                            $deadlineDays = $goal->deadline
                                ? \Carbon\Carbon::parse($goal->deadline)->diffInDays(now(), false)
                                : null;
                        @endphp
                        <li class="p-4 bg-gray-50 rounded shadow flex flex-col sm:flex-row justify-between items-center">
                            <div class="flex-1 mb-4 sm:mb-0">
                                <h5 class="font-semibold text-lg text-gray-800">{{ $goal->title }}</h5>
                                <p class="text-sm text-gray-600">Progress: {{ $goal->progress }}%</p>
                                <p class="text-sm text-gray-500">
                                    @if ($deadlineDays !== null)
                                        {{ $deadlineDays >= 0 ? "$deadlineDays day(s) left" : abs($deadlineDays) . " day(s) overdue" }}
                                    @else
                                        No deadline set
                                    @endif
                                </p>
                            </div>
                            <div class="w-28 h-28">
                                <canvas id="chart-{{ $goal->id }}"></canvas>
                            </div>
                        </li>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                new Chart(document.getElementById('chart-{{ $goal->id }}').getContext('2d'), {
                                    type: 'doughnut',
                                    data: {
                                        labels: ['Completed', 'Incomplete'],
                                        datasets: [{
                                            data: [{{ $completed }}, {{ $incomplete }}],
                                            backgroundColor: ['#10B981', '#EF4444'],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        cutout: '70%',
                                        plugins: {
                                            legend: { display: false }
                                        }
                                    }
                                });
                            });
                        </script>
                    @empty
                        <li class="text-gray-500 text-sm">No recent goals found.</li>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
</x-app-layout>
