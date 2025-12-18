<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Voting Booth') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 text-center">
                    <h1 class="text-3xl font-bold mb-2">{{ $room->title }}</h1>
                    <p class="text-gray-600">{{ $room->description }}</p>
                    <div class="mt-4 text-sm text-gray-500">
                        {{ __('Please select one candidate carefully. This action cannot be undone.') }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($candidates as $candidate)
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300 flex flex-col">

                    <div class="h-64 bg-gray-100 flex items-center justify-center overflow-hidden">
                        @if ($candidate->photo_url)
                            @if (filter_var($candidate->photo_url, FILTER_VALIDATE_URL))
                                <img src="{{ $candidate->photo_url }}" alt="{{ $candidate->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('storage/' . $candidate->photo_url) }}" alt="{{ $candidate->name }}" class="w-full h-full object-cover">
                            @endif
                        @else
                            <div class="text-gray-400 flex flex-col items-center">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="mt-2 text-sm">{{ __('No Photo') }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="p-6 flex-grow">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $candidate->name }}</h3>

                        <div class="mb-4">
                            <h4 class="font-bold text-sm text-blue-600 mt-4">{{ __('Vision') }}</h4>
                            <p class="text-gray-700 text-sm mb-2">{{ $candidate->vision }}</p>

                            <h4 class="font-bold text-sm text-blue-600 mt-3">{{ __('Mission') }}</h4>
                            <p class="text-gray-700 text-sm">{{ $candidate->mission }}</p>
                        </div>
                    </div>

                    <div class="p-6 bg-gray-50 border-t border-gray-100 mt-auto">
                        <form action="{{ route('vote.store', $room->room_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="candidate_id" value="{{ $candidate->candidate_id ?? $candidate->id }}">

                            <button type="submit"
                                    class="w-full justify-center inline-flex items-center px-4 py-3 bg-blue-500 border border-transparent rounded-md font-bold text-white tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    onclick="return confirm('{{ __('Are you sure you want to vote for :name? This cannot be changed.', ['name' => $candidate->name]) }}')">
                                {{ __('Vote for :name', ['name' => $candidate->name]) }}
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
