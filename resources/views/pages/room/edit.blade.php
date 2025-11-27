<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('rooms.update', $room) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="title" class="block font-medium text-sm text-gray-700">{{ __('Title') }}</label>
                            <input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title', $room->title) }}" required autofocus />
                        </div>

                        <div class="mt-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">{{ __('Description') }}</label>
                            <textarea id="description" class="block mt-1 w-full" name="description" required>{{ old('description', $room->description) }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label for="start_date" class="block font-medium text-sm text-gray-700">{{ __('Start Date') }}</label>
                            <input id="start_date" class="block mt-1 w-full" type="datetime-local" name="start_date" value="{{ old('start_date', $room->start_date->format('Y-m-d\TH:i')) }}" required />
                        </div>

                        <div class="mt-4">
                            <label for="end_date" class="block font-medium text-sm text-gray-700">{{ __('End Date') }}</label>
                            <input id="end_date" class="block mt-1 w-full" type="datetime-local" name="end_date" value="{{ old('end_date', $room->end_date->format('Y-m-d\TH:i')) }}" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Update Room') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
