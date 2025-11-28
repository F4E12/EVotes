<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Room Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold">{{ $room->title }}</h3>
                    <p class="mt-2">{{ $room->description }}</p>
                    <div class="mt-4">
                        <p><strong>Start Date:</strong> {{ $room->start_date->format('d M Y H:i') }}</p>
                        <p><strong>End Date:</strong> {{ $room->end_date->format('d M Y H:i') }}</p>
                        <p class="mt-2"><strong>Status:</strong> <span
                                class="font-semibold">{{ ucfirst($status) }}</span></p>
                        <p class="mt-2"><strong>Room Token:</strong>
                            <span
                                class="font-mono bg-gray-200 text-gray-800 px-2 py-1 rounded">{{ $room->unique_token }}</span>
                        </p>
                    </div>

                    <div class="mt-6 flex items-center space-x-4">
                        <a href="{{ route('rooms.edit', $room->room_id) }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Room
                        </a>
                        @if ($status !== 'ended')
                            <form action="{{ route('rooms.close', $room->room_id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to close voting for this room?');">
                                @csrf
                                <button type="submit"
                                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Close Voting
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('rooms.destroy', $room->room_id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this room? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Delete Room
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold">Candidates</h3>
                    <div class="mt-4">
                        @foreach ($candidates as $candidate)
                            <div class="flex items-center justify-between mt-2 p-2 border-b">
                                <div class="flex items-center">
                                    @if ($candidate->photo_url)
                                        <img src="{{ asset('storage/' . $candidate->photo_url) }}" alt="{{ $candidate->name }}"
                                            class="w-16 h-16 object-cover rounded-full">
                                    @else
                                        <div
                                            class="w-16 h-16 flex items-center justify-center bg-gray-300 rounded-full text-gray-600 font-bold">
                                            <i class="fas fa-user text-2xl"></i>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <p class="font-semibold">{{ $candidate->name }}</p>
                                        <p class="text-sm text-gray-600"><strong>Vision:</strong> {{ $candidate->vision }}
                                        </p>
                                        <p class="text-sm text-gray-600"><strong>Mission:</strong> {{ $candidate->mission }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    {{-- Edit button/modal will go here --}}
                                    <form action="{{ route('candidates.destroy', $candidate) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this candidate?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        <h4 class="text-xl font-bold">Add New Candidate</h4>
                        <form action="{{ route('rooms.candidates.store', $room->room_id) }}" method="POST"
                            enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                                <input id="name" name="name" type="text" class="mt-1 block w-full" required>
                            </div>
                            <div class="mt-4">
                                <label for="vision" class="block font-medium text-sm text-gray-700">Vision</label>
                                <textarea id="vision" name="vision" class="mt-1 block w-full" required></textarea>
                            </div>
                            <div class="mt-4">
                                <label for="mission" class="block font-medium text-sm text-gray-700">Mission</label>
                                <textarea id="mission" name="mission" class="mt-1 block w-full" required></textarea>
                            </div>
                            <div class="mt-4">
                                <label for="photo_url" class="block font-medium text-sm text-gray-700">Photo</label>
                                <input id="photo_url" name="photo_url" type="file" class="mt-1 block w-full">
                            </div>
                            <div class="mt-4">
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Add Candidate
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>