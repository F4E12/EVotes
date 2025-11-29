<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
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
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Your Rooms</h3>
                    @if($rooms->isEmpty())
                        <p>You haven't created any rooms yet.</p>
                        <a href="{{ route('host-a-room') }}"
                            class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create a Room
                        </a>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($rooms as $room)
                                <div class="bg-white border rounded-lg shadow-sm p-4 flex flex-col justify-between">
                                    <div>
                                        <h4 class="font-bold text-lg">{{ $room->title }}</h4>
                                        <p class="text-gray-600 mt-2">{{ Str::limit($room->description, 100) }}</p>
                                        <div class="mt-2">
                                            @php
                                                $statusColor = '';
                                                switch ($room->status) {
                                                    case 'upcoming':
                                                        $statusColor = 'bg-yellow-200 text-yellow-800';
                                                        break;
                                                    case 'ongoing':
                                                        $statusColor = 'bg-green-200 text-green-800';
                                                        break;
                                                    case 'ended':
                                                        $statusColor = 'bg-red-200 text-red-800';
                                                        break;
                                                    default:
                                                        $statusColor = 'bg-gray-200 text-gray-800';
                                                        break;
                                                }
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                                {{ ucfirst($room->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('rooms.show', $room->room_id) }}"
                                            class="text-blue-500 hover:text-blue-700 font-semibold">
                                            View Details &rarr;
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
