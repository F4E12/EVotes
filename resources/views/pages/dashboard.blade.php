<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('host-a-room') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                {{ __('Create New Room') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm" role="alert">
                    <p class="font-bold">{{ __('Error') }}</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="space-y-4">

                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Your Rooms') }}</h3>
                    <span class="px-3 py-1 text-xs font-semibold bg-white border border-gray-200 rounded-full text-gray-500">
                        {{ $rooms->count() }} {{ __('Total') }}
                    </span>
                </div>

                <div class="h-4"></div>

                @if ($rooms->isEmpty())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border-2 border-dashed border-gray-300 p-8 text-center">
                        <div class="mx-auto h-20 w-20 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="h-10 w-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1">{{ __('No rooms created yet') }}</h3>
                        <p class="text-sm text-gray-500 mb-6 max-w-sm mx-auto">{{ __('Get started by creating your first voting room. It only takes a minute to set up.') }}</p>

                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($rooms as $room)
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 flex flex-col h-full group">
                                <div class="p-5 flex-grow">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="p-2 bg-blue-50 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        </div>

                                        @php
                                            $statusColor = match($room->status) {
                                                'upcoming' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'ongoing' => 'bg-green-100 text-green-800 border-green-200',
                                                'ended' => 'bg-gray-100 text-gray-800 border-gray-200',
                                                default => 'bg-gray-100 text-gray-800 border-gray-200',
                                            };
                                            $statusDot = match($room->status) {
                                                'upcoming' => 'bg-yellow-400',
                                                'ongoing' => 'bg-green-400 animate-pulse',
                                                'ended' => 'bg-gray-400',
                                                default => 'bg-gray-400',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide border {{ $statusColor }}">
                                            <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $statusDot }}"></span>
                                            {{ __(ucfirst($room->status)) }}
                                        </span>
                                    </div>

                                    <h4 class="font-bold text-lg text-gray-900 mb-1 line-clamp-1 group-hover:text-blue-600 transition-colors">
                                        {{ $room->title }}
                                    </h4>
                                    <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed">
                                        {{ $room->description }}
                                    </p>
                                </div>

                                <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 rounded-b-xl flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ __('Room Token:') }}</span>
                                        <span class="text-xs font-mono font-bold text-gray-600 bg-white border border-gray-200 px-2 py-1 rounded select-all cursor-pointer hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-colors" title="Copy Token">
                                            {{ $room->unique_token }}
                                        </span>
                                    </div>
                                    <a href="{{ route('rooms.show', $room->room_id) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-colors">
                                        {{ __('Manage') }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
