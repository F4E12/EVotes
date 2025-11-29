<x-app-layout>
    {{-- 1. LOAD LIBRARY CHART.JS DARI CDN --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Room Results') }}
        </h2>
        {{-- Script Chart.js dimuat di header agar siap digunakan --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- HEADER: Judul Room --}}
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-800">
                            Results for Room: {{ $room->title }}
                        </h3>

                        {{-- Tampilkan Total Suara HANYA jika hasil dibuka --}}
                        @if ($showResults && !$candidates->isEmpty())
                            <div class="text-sm bg-gray-100 text-gray-600 px-4 py-2 rounded-lg">
                                Total Votes: <span
                                    class="font-bold text-gray-900">{{ $candidates->sum('votes_count') }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- LOGIKA UTAMA: TAMPILKAN HASIL ATAU SEMBUNYIKAN --}}
                    @if ($showResults)

                        {{-- KONDISI 1: Hasil Dibuka --}}
                        @if ($candidates->isEmpty())
                            <div class="text-center py-10 text-gray-500">
                                <p>No candidates found for this room.</p>
                            </div>
                        @else
                            {{-- ========================================== --}}
                            {{-- BAGIAN 1: GRAFIK / CHART                   --}}
                            {{-- ========================================== --}}
                            <div class="mb-10 p-4 border border-gray-100 rounded-xl bg-gray-50">
                                <h4 class="text-lg font-semibold text-gray-700 mb-4 ml-2">Vote Visualization</h4>
                                <div class="relative h-64 w-full">
                                    <canvas id="voteChart"></canvas>
                                </div>
                            </div>

                            {{-- ========================================== --}}
                            {{-- BAGIAN 2: TABEL DETAIL                     --}}
                            {{-- ========================================== --}}
                            @php
                                $totalVotes = $candidates->sum('votes_count');
                            @endphp

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                                                #</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Candidate</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">
                                                Performance</th>
                                            <th
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Total Votes</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($candidates as $index => $candidate)
                                            @php
                                                $percentage =
                                                    $totalVotes > 0 ? ($candidate->votes_count / $totalVotes) * 100 : 0;
                                            @endphp
                                            <tr class="{{ $index === 0 ? 'bg-gray-50' : '' }}">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-500">
                                                    {{ $loop->iteration }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        @if ($candidate->photo_url)
                                                            <img src="{{ filter_var($candidate->photo_url, FILTER_VALIDATE_URL) ? $candidate->photo_url : asset('storage/' . $candidate->photo_url) }}"
                                                                alt="{{ $candidate->name }}"
                                                                class="w-10 h-10 rounded-full mr-4 object-cover border border-gray-200">
                                                        @else
                                                            <div
                                                                class="w-10 h-10 bg-gray-200 rounded-full mr-4 flex items-center justify-center border border-gray-300">
                                                                <span
                                                                    class="text-gray-600 font-bold text-xs">{{ strtoupper(substr($candidate->name, 0, 2)) }}</span>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="text-sm font-bold text-gray-900">
                                                                {{ $candidate->name }}</div>
                                                            @if ($index === 0 && $candidate->votes_count > 0)
                                                                <span
                                                                    class="text-xs text-green-600 font-semibold">Leading</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 align-middle">
                                                    <div class="w-full">
                                                        <div class="flex justify-between items-end mb-1">
                                                            <span
                                                                class="text-xs font-semibold text-gray-700">{{ number_format($percentage, 1) }}%</span>
                                                        </div>
                                                        <div
                                                            class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                                            <div class="bg-gray-800 h-2.5 rounded-full"
                                                                style="width: {{ $percentage }}%"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <span
                                                        class="text-lg font-bold text-gray-900">{{ $candidate->votes_count }}</span>
                                                    <span class="text-xs text-gray-500 block">votes</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @else
                        {{-- KONDISI 2: Hasil Masih Disembunyikan --}}
                        <div class="text-center py-12 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900">Results are currently hidden</h3>
                            <p class="mt-1 text-sm text-gray-500">The voting period is still active or results have not
                                been revealed yet.</p>

                            @if ($room->end_date)
                                <div
                                    class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-yellow-800 bg-yellow-100">
                                    <svg class="mr-2 h-5 w-5 text-yellow-600" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Revealed at: {{ \Carbon\Carbon::parse($room->end_date)->format('d M Y, H:i') }}
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- BAGIAN 3: JAVASCRIPT LOGIC                 --}}
    {{-- ========================================== --}}
    {{-- JS hanya dirender jika ShowResults TRUE dan Candidates TIDAK kosong --}}
    @if ($showResults && !$candidates->isEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // 1. Ambil Data dari PHP ke JS
                const names = @json($candidates->pluck('name'));
                const votes = @json($candidates->pluck('votes_count'));

                // 2. Setup Context Canvas
                const ctx = document.getElementById('voteChart').getContext('2d');

                // 3. Render Chart
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: names,
                        datasets: [{
                            label: 'Total Votes',
                            data: votes,
                            backgroundColor: 'rgba(31, 41, 55, 0.8)',
                            borderColor: 'rgba(31, 41, 55, 1)',
                            borderWidth: 1,
                            borderRadius: 4,
                            barPercentage: 0.5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                titleFont: {
                                    size: 14
                                },
                                bodyFont: {
                                    size: 14
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                },
                                ticks: {
                                    stepSize: 1,
                                    font: {
                                        family: 'sans-serif'
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endif
</x-app-layout>
