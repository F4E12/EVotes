<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Room Results') }}
            </h2>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-200 overflow-hidden px-4 sm:px-8">

                <div class="px-8 sm:px-12 py-8 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white">
                    <div>
                        <div class = "h-8"></div>
                        <h3 class="text-3xl font-black text-gray-900 tracking-tight">{{ $room->title }}</h3>
                        <p class="text-gray-500 mt-1">{{ __('Real-time election analytics.') }}</p>
                    </div>

                    @if ($showResults && !$candidates->isEmpty())
                        <div class="flex items-center gap-3 bg-blue-50 px-5 py-3 rounded-2xl border border-blue-100">
                            <div class="p-2 bg-blue-100 text-blue-600 rounded-full">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-blue-400 uppercase tracking-wider">{{ __('Total Votes') }}</span>
                                <span class="block text-2xl font-black text-blue-700 leading-none">{{ $candidates->sum('votes_count') }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="p-8 sm:p-12">

                    @if ($showResults)

                        @if ($candidates->isEmpty())
                            <div class="text-center py-16 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                                <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <h3 class="text-lg font-bold text-gray-900">{{ __('No Candidates Found') }}</h3>
                                <p class="text-gray-500">{{ __('There are no candidates listed in this room yet.') }}</p>
                            </div>
                        @else

                            <div class="mb-12">
                                <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6 sm:p-8">
                                    <div class="flex items-center justify-between mb-6">
                                        <h4 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                                            {{ __('Visual Analytics') }}
                                        </h4>
                                    </div>
                                    <div class="relative w-full h-[400px]">
                                        <canvas id="voteChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2 px-1">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    {{ __('Leaderboard') }}
                                </h4>

                                @php $totalVotes = $candidates->sum('votes_count'); @endphp

                                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm p-4 sm:p-6">
                                    <table class="min-w-full divide-y divide-gray-100">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-8 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider w-16">
                                                    {{ __('Rank') }}
                                                </th>
                                                <th scope="col" class="px-8 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                                    {{ __('Candidate') }}
                                                </th>
                                                <th scope="col" class="px-8 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider w-1/3">
                                                    {{ __('Performance') }}
                                                </th>
                                                <th scope="col" class="px-8 py-5 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">
                                                    {{ __('Count') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 bg-white">
                                            @foreach ($candidates->sortByDesc('votes_count')->values() as $index => $candidate)
                                                @php
                                                    $percentage = $totalVotes > 0 ? ($candidate->votes_count / $totalVotes) * 100 : 0;
                                                    $isWinner = $index === 0 && $candidate->votes_count > 0;
                                                @endphp
                                                <tr class="hover:bg-blue-50/20 transition-colors {{ $isWinner ? 'bg-yellow-50/30' : '' }}">

                                                    <td class="px-8 py-6 whitespace-nowrap">
                                                        <div class="flex items-center justify-center w-8 h-8 rounded-full font-bold text-sm {{ $isWinner ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-500' }}">
                                                            {{ $index + 1 }}
                                                        </div>
                                                    </td>

                                                    <td class="px-8 py-6 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="h-12 w-12 shrink-0">
                                                                @if ($candidate->photo_url)
                                                                    <img src="{{ filter_var($candidate->photo_url, FILTER_VALIDATE_URL) ? $candidate->photo_url : asset('storage/' . $candidate->photo_url) }}"
                                                                         class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-sm ring-1 ring-gray-100" alt="">
                                                                @else
                                                                    <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center border-2 border-white shadow-sm text-gray-400 font-bold">
                                                                        {{ substr($candidate->name, 0, 1) }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-base font-bold text-gray-900">{{ $candidate->name }}</div>
                                                                @if ($isWinner)
                                                                    <div class="inline-flex items-center text-xs font-bold text-yellow-600 mt-0.5">
                                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                                        {{ __('Current Leader') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="px-8 py-6 align-middle">
                                                        <div class="w-full max-w-xs">
                                                            <div class="flex justify-between items-end mb-1.5">
                                                                <span class="text-xs font-bold text-gray-700">{{ number_format($percentage, 1) }}%</span>
                                                            </div>
                                                            <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden shadow-inner">
                                                                <div class="h-2.5 rounded-full {{ $isWinner ? 'bg-blue-600' : 'bg-gray-400' }}" style="width: {{ $percentage }}%"></div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="px-8 py-6 whitespace-nowrap text-right">
                                                        <span class="text-xl font-black text-gray-900">{{ $candidate->votes_count }}</span>
                                                        <span class="text-xs font-bold text-gray-400 block uppercase tracking-wide">{{ __('Votes') }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                    @else

                        <div class="flex flex-col items-center justify-center py-20 text-center">
                            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6 shadow-inner">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ __('Results are Hidden') }}</h3>
                            <p class="text-gray-500 max-w-md mx-auto mb-8 text-lg">{{ __('The voting period is still active or the host has chosen to keep results private for now.') }}</p>

                            @if ($room->end_date)
                                <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-yellow-50 text-yellow-800 rounded-xl border border-yellow-200 shadow-sm">
                                    <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="font-bold text-sm">{{ __('Results Revealed:') }} {{ \Carbon\Carbon::parse($room->end_date)->format('d M Y, H:i') }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class = "h-8"></div>
                </div>
            </div>
        </div>
    </div>

    @if ($showResults && !$candidates->isEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const names = @json($candidates->pluck('name'));
                const votes = @json($candidates->pluck('votes_count'));

                const ctx = document.getElementById('voteChart').getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: names,
                        datasets: [{
                            label: '{{ __('Total Votes') }}',
                            data: votes,
                            backgroundColor: 'rgba(59, 130, 246, 0.8)', // Tailwind Blue-500
                            borderColor: 'rgba(37, 99, 235, 1)', // Tailwind Blue-600
                            borderWidth: 0,
                            borderRadius: 8, // Soft rounded bars
                            barPercentage: 0.6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(17, 24, 39, 0.9)', // Dark Gray
                                padding: 12,
                                titleFont: { size: 14, family: "'Figtree', sans-serif" },
                                bodyFont: { size: 14, family: "'Figtree', sans-serif" },
                                cornerRadius: 8,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                                ticks: { font: { family: "'Figtree', sans-serif" }, stepSize: 1 }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { family: "'Figtree', sans-serif", weight: 'bold' } }
                            }
                        }
                    }
                });
            });
        </script>
    @endif
</x-app-layout>
