<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ $room->title }}
            </h2>
            <span class="px-3 py-1 text-sm font-semibold rounded-full
                {{ $status === 'ongoing' ? 'bg-green-100 text-green-800' : ($status === 'upcoming' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                {{ __('Status:') }} {{ __(ucfirst($status)) }}
            </span>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col justify-center items-center text-center">
                    <h3 class="text-gray-500 font-medium text-sm uppercase tracking-wider mb-4">{{ __('Participant Access Token') }}</h3>

                    <div class="flex items-center gap-4 w-full max-w-lg">
                        <div class="flex-1 bg-gray-100 border-2 border-gray-300 border-dashed rounded-lg py-4 px-6">
                            <span class="text-5xl font-black font-mono text-gray-800 tracking-widest select-all">
                                {{ $room->unique_token }}
                            </span>
                        </div>
                        <button onclick="copyToken('{{ $room->unique_token }}')"
                                class="h-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg transition shadow-md active:scale-95 flex flex-col items-center justify-center min-h-[5rem]">
                            <span class="uppercase tracking-wide text-sm">{{ __('Copy') }}</span>
                        </button>
                    </div>

                    <p class="mt-4 text-gray-500 text-sm">
                        {{ __('Share this code or direct link:') }} <span class="font-mono text-blue-600 bg-blue-50 px-1 rounded">{{ url('/join') }}</span>
                    </p>
                    <p id="copy-feedback" class="text-green-600 text-sm font-bold mt-2 opacity-0 transition-opacity">
                        {{ __('Copied to clipboard!') }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <h3 class="font-bold text-gray-900 border-b border-gray-100 pb-2">{{ __('Room Summary') }}</h3>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">{{ __('Total Votes') }}</span>
                        <span class="text-2xl font-bold text-blue-600">{{ $totalVotes }}</span>
                    </div>

                    <div class="space-y-1">
                        <p class="text-xs text-gray-500 uppercase font-semibold">{{ __('Start Date') }}</p>
                        <p class="text-gray-800 font-medium">{{ $room->start_date->format('d M Y, H:i') }}</p>
                    </div>

                    <div class="space-y-1">
                        <p class="text-xs text-gray-500 uppercase font-semibold">{{ __('End Date') }}</p>
                        <p class="text-gray-800 font-medium">{{ $room->end_date->format('d M Y, H:i') }}</p>
                    </div>

                    <div class="space-y-1">
                        <p class="text-xs text-gray-500 uppercase font-semibold">{{ __('Visibility') }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $room->is_revealed ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $room->is_revealed ? __('Results Public') : __('Results Hidden') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex flex-wrap gap-3 items-center justify-between">
                <div class="flex gap-3">
                    <a href="{{ route('rooms.edit', $room->room_id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition">
                        {{ __('Edit Settings') }}
                    </a>

                    <form action="{{ route('rooms.toggle-reveal', $room->room_id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition !bg-purple-600 !text-white hover:!bg-purple-600 focus:ring-purple-500">
                            {{ $room->is_revealed ? __('Hide Results') : __('Reveal Results') }}
                        </button>

                    </form>
                </div>

                <div class="flex gap-3">
                    @if ($status !== 'ended')
                        <form action="{{ route('rooms.close', $room->room_id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to close voting?') }}');">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition">
                                {{ __('Close Voting') }}
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('rooms.destroy', $room->room_id) }}" method="POST" onsubmit="return confirm('{{ __('PERMANENTLY DELETE ROOM?') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                            {{ __('Delete') }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                <div class="xl:col-span-2 flex flex-col gap-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-6 py-4 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 text-lg">{{ __('Candidates List') }}</h3>
                        <span class="text-xs font-semibold bg-gray-200 text-gray-700 px-2 py-1 rounded-full">{{ $candidates->count() }} {{ __('Candidates') }}</span>
                    </div>

                    @if ($candidates->isEmpty())
                        <div class="bg-white rounded-xl border-2 border-dashed border-gray-300 p-12 text-center">
                            <div class="mx-auto h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('No candidates yet') }}</h3>
                            <p class="mt-1 text-gray-500">{{ __('Add the first candidate using the form on the right.') }}</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            @foreach ($candidates as $candidate)
                                <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-start gap-6">

                                        <div class="flex-shrink-0">
                                            @if ($candidate->photo_url)
                                                <img class="h-16 w-16 rounded-full object-cover border-2 border-gray-200"
                                                     src="{{ filter_var($candidate->photo_url, FILTER_VALIDATE_URL) ? $candidate->photo_url : asset('storage/' . $candidate->photo_url) }}"
                                                     alt="{{ $candidate->name }}">
                                            @else
                                                <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 font-bold text-xl border-2 border-gray-300">
                                                    {{ substr($candidate->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-start mb-2">
                                                <h4 class="text-lg font-bold text-gray-900 truncate">{{ $candidate->name }}</h4>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                                    {{ $candidate->vote_count }} {{ __('Votes') }}
                                                </span>
                                            </div>

                                            <div class="mb-2">
                                                <p class="text-xs text-gray-400 uppercase font-bold mb-1">{{ __('Vision') }}</p>
                                                <p class="text-sm text-gray-700 line-clamp-2">{{ $candidate->vision }}</p>
                                            </div>

                                            <div class="mb-3">
                                                <p class="text-xs text-gray-400 uppercase font-bold mb-1">{{ __('Mission') }}</p>
                                                <p class="text-sm text-gray-700 line-clamp-2">{{ $candidate->mission }}</p>
                                            </div>

                                            <div class="flex space-x-4 pt-2 border-t border-gray-50 items-center">
                                                <a href="{{ route('candidates.edit', $candidate->candidate_id) }}" class="text-xs font-bold text-blue-600 hover:text-blue-500 uppercase">{{ __('Edit') }}</a>
                                                <form action="{{ route('candidates.destroy', $candidate->candidate_id) }}" method="POST" onsubmit="return confirm('{{ __('Remove candidate?') }}');" class="inline flex items-center">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs font-bold text-red-600 hover:text-red-500 uppercase">{{ __('Remove') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 h-fit sticky top-6">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="font-bold text-gray-800">{{ __('Add New Candidate') }}</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('rooms.candidates.store', $room->room_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <div>
                                <label class="block font-medium text-sm text-gray-700">{{ __('Full Name') }}</label>
                                <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">{{ __('Vision (Short)') }}</label>
                                <textarea name="vision" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required></textarea>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">{{ __('Mission (Detailed)') }}</label>
                                <textarea name="mission" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required></textarea>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">{{ __('Photo') }}</label>
                                <input type="file" name="photo_url" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>

                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Add Candidate') }}
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        function copyToken(token) {
            navigator.clipboard.writeText(token).then(() => {
                const msg = document.getElementById('copy-feedback');
                msg.classList.remove('opacity-0');
                setTimeout(() => msg.classList.add('opacity-0'), 2000);
            });
        }
    </script>
</x-app-layout>
