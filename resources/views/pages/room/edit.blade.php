<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('rooms.show', $room->room_id) }}" class="p-2 rounded-full bg-white border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-200 transition-colors shadow-sm group">
                    <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Edit Room') }}
                </h2>
            </div>

            <span class="px-3 py-1 text-sm font-semibold rounded-full
                {{ \Carbon\Carbon::now()->between($room->start_date, $room->end_date) ? 'bg-green-100 text-green-800' : (\Carbon\Carbon::now()->lt($room->start_date) ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                {{ \Carbon\Carbon::now()->between($room->start_date, $room->end_date) ? __('Ongoing') : (\Carbon\Carbon::now()->lt($room->start_date) ? __('Upcoming') : __('Ended')) }}
            </span>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-[85rem] mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3 shadow-sm">
                    <svg class="w-6 h-6 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h3 class="text-red-800 font-bold text-sm">{{ __('Please fix the following errors:') }}</h3>
                        <ul class="list-disc list-inside text-sm text-red-600 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form id="edit-room-form" action="{{ route('rooms.update', ['room_id' => $room->room_id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 items-start">

                    <div class="space-y-6">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col h-full">
                            <div class="border-b border-gray-100 pb-4 mb-6">
                                <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    {{ __('General Information') }}
                                </h3>
                            </div>

                            <div class="space-y-6 flex-grow">
                                <div>
                                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Room Title') }}</label>
                                    <input id="title" type="text" name="title"
                                           value="{{ old('title', $room->title) }}"
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-3 px-4"
                                           placeholder="{{ __('e.g. 2025 Student Council Election') }}" required autofocus />
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Description') }}</label>
                                    <textarea id="description" name="description" rows="8"
                                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-3 px-4 text-gray-600 leading-relaxed"
                                              placeholder="{{ __('Describe the purpose of this vote, rules, or instructions...') }}" required>{{ old('description', $room->description) }}</textarea>
                                    <p class="mt-2 text-xs text-gray-500 text-right">{{ __('Visible to all participants.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col h-full">
                            <div class="border-b border-gray-100 pb-4 mb-6">
                                <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ __('Schedule') }}
                                </h3>
                            </div>

                            <div class="space-y-6 flex-grow">
                                <div>
                                    <label for="start_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Start Date & Time') }}</label>
                                    <input id="start_date" type="datetime-local" name="start_date"
                                           value="{{ old('start_date', $room->start_date->format('Y-m-d\TH:i')) }}"
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm py-3 px-4" required />
                                    <p class="text-xs text-gray-400 mt-2">{{ __('Voting opens at this time.') }}</p>
                                </div>

                                <div>
                                    <label for="end_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('End Date & Time') }}</label>
                                    <input id="end_date" type="datetime-local" name="end_date"
                                           value="{{ old('end_date', $room->end_date->format('Y-m-d\TH:i')) }}"
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm py-3 px-4" required />
                                    <p class="text-xs text-gray-400 mt-2">{{ __('Voting closes after this time.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-red-50 rounded-xl border border-red-200 p-6 flex flex-col h-full">
                            <div class="border-b border-red-100 pb-4 mb-6">
                                <h3 class="font-bold text-lg text-red-900 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    {{ __('Danger Zone') }}
                                </h3>
                            </div>

                            <div class="flex-grow flex flex-col justify-between space-y-6">
                                <div>
                                    <p class="text-red-700 text-sm leading-relaxed">
                                        {{ __('Deleting this room will') }} <strong>{{ __('permanently remove') }}</strong> {{ __('all associated data, including:') }}
                                    </p>
                                    <ul class="list-disc list-inside text-red-600/80 text-sm mt-2 space-y-1">
                                        <li>{{ __('Candidate profiles') }}</li>
                                        <li>{{ __('Vote records') }}</li>
                                        <li>{{ __('Result history') }}</li>
                                    </ul>
                                    <p class="text-red-700 text-sm mt-4 font-bold">{{ __('This action cannot be undone.') }}</p>
                                </div>

                                <button type="button" onclick="if(confirm('{{ __('Are you sure? This is irreversible.') }}')) document.getElementById('delete-room-form').submit();"
                                        class="w-full px-4 py-3 bg-white border border-red-200 text-red-600 hover:bg-red-600 hover:text-white font-bold rounded-lg shadow-sm transition-colors text-center">
                                    {{ __('Delete Room') }}
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="h-32 w-full"></div>

            </form>

            <form id="delete-room-form" action="{{ route('rooms.destroy', $room->room_id) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>

        </div>
    </div>

    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-[0_-8px_30px_rgba(0,0,0,0.1)] z-50">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-end gap-4">
            <a href="{{ route('rooms.show', $room->room_id) }}" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                {{ __('Cancel') }}
            </a>
            <button onclick="document.getElementById('edit-room-form').submit()"
                    class="inline-flex justify-center items-center px-8 py-3 min-w-[200px] border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors gap-2 whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ __('Save Changes') }}
            </button>
        </div>
    </div>

</x-app-layout>
