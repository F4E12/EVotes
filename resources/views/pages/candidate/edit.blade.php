<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Candidate') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('candidates.update', $candidate) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                            <input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $candidate->name) }}" required autofocus>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <label for="vision" class="block font-medium text-sm text-gray-700">Vision</label>
                            <textarea id="vision" name="vision" class="mt-1 block w-full" required>{{ old('vision', $candidate->vision) }}</textarea>
                            <x-input-error :messages="$errors->get('vision')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <label for="mission" class="block font-medium text-sm text-gray-700">Mission</label>
                            <textarea id="mission" name="mission" class="mt-1 block w-full" required>{{ old('mission', $candidate->mission) }}</textarea>
                            <x-input-error :messages="$errors->get('mission')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <label for="photo_url" class="block font-medium text-sm text-gray-700">Photo</label>
                            @if ($candidate->photo_url)
                                <img src="{{ asset('storage/' . $candidate->photo_url) }}" alt="{{ $candidate->name }}" class="w-24 h-24 object-cover rounded-full mt-2">
                                <p class="text-sm text-gray-600 mt-1">Current Photo</p>
                            @endif
                            <input id="photo_url" name="photo_url" type="file" class="mt-1 block w-full">
                            <x-input-error :messages="$errors->get('photo_url')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Leave blank to keep current photo.</p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Update Candidate') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
