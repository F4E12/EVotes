<x-app-layout>
    <div class="bg-gray-50 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="min-w-0 flex-1">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                        Voting History
                    </h2>
                    <p class="mt-2 text-sm text-gray-500">
                        A record of all elections you have participated in.
                    </p>
                </div>
                <div class="mt-4 flex md:ml-4 md:mt-0">
                    <div class="inline-flex items-center rounded-lg bg-white px-4 py-2 shadow-sm ring-1 ring-inset ring-gray-300">
                        <span class="text-sm text-gray-500 mr-2">Total Votes Cast:</span>
                        <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">
                            {{ $votes->count() }}
                        </span>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4 border-l-4 border-green-400">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($votes->isEmpty())
                <div class="text-center rounded-2xl bg-white px-6 py-24 shadow-sm ring-1 ring-gray-900/5">
                    <div class="h-8"></div>
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-gray-100">
                        <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-base font-semibold leading-7 text-gray-900">No votes recorded</h3>
                    <p class="mt-1 text-sm leading-6 text-gray-500">You haven't cast any votes yet. Join a room to get started.</p>
                    <div class="mt-6">
                        <a href="{{ route('join-a-room') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            Join a Room
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                    {{-- Card inner padding --}}
                    <div class="px-4 sm:px-6 lg:px-8 py-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 px-4 sm:px-6 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            Election Details
                                        </th>
                                        <th scope="col"
                                            class="py-3.5 px-4 sm:px-6 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            Your Selection
                                        </th>
                                        <th scope="col"
                                            class="py-3.5 px-4 sm:px-6 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            Date
                                        </th>
                                        <th scope="col"
                                            class="py-3.5 px-4 sm:px-6 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 bg-white text-sm">
                                    @foreach ($votes as $vote)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            {{-- Election Details --}}
                                            <td class="py-4 px-4 sm:px-6 align-top">
                                                <div class="flex items-start">
                                                    <div>
                                                        <div class="font-bold text-gray-900 text-base">
                                                            {{ $vote->room->title ?? 'Room Deleted' }}
                                                        </div>
                                                        <div class="mt-1 flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                                                            <span class="font-mono bg-gray-100 px-1.5 py-0.5 rounded text-gray-600 border border-gray-200">
                                                                {{ $vote->room->unique_token ?? '---' }}
                                                            </span>
                                                            <span>&middot;</span>
                                                            <span>Ref: #{{ $vote->id }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Your Selection --}}
                                            <td class="py-4 px-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        @if ($vote->candidate && $vote->candidate->photo_url)
                                                            <img class="h-10 w-10 rounded-full object-cover border border-gray-200"
                                                                src="{{ filter_var($vote->candidate->photo_url, FILTER_VALIDATE_URL) ? $vote->candidate->photo_url : asset('storage/' . $vote->candidate->photo_url) }}"
                                                                alt="">
                                                        @else
                                                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold border border-indigo-200">
                                                                {{ substr($vote->candidate->name ?? '?', 0, 1) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900">
                                                            {{ $vote->candidate->name ?? 'Unknown' }}
                                                        </div>
                                                        <div class="text-xs text-green-600 font-medium flex items-center mt-0.5">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            Confirmed
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Date --}}
                                            <td class="py-4 px-4 sm:px-6 text-gray-500">
                                                <div class="text-gray-900 font-medium">
                                                    {{ $vote->voted_at->format('M d, Y') }}
                                                </div>
                                                <div class="text-xs text-gray-400 mt-0.5">
                                                    {{ $vote->voted_at->format('h:i A') }}
                                                </div>
                                            </td>

                                            {{-- Actions --}}
                                            <td class="py-4 px-4 sm:px-6 text-right text-sm font-medium">
                                                @if($vote->room)
                                                    <a href="{{ route('rooms.results', $vote->room->room_id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 hover:underline">
                                                        View Results<span class="sr-only">, {{ $vote->room->title }}</span>
                                                    </a>
                                                @else
                                                    <span class="text-gray-400 italic">Expired</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>