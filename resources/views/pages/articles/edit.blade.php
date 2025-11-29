<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Article') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Article Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $article->title)" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="related_room_id" :value="__('Tag to Room')" />
                            <select name="related_room_id" id="related_room_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                                <option value="">-- General News --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ $article->related_room_id == $room->id ? 'selected' : '' }}>
                                        {{ $room->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="content" :value="__('Content')" />
                            <textarea name="content" id="content" rows="6" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1" required>{{ old('content', $article->content) }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="thumbnail" :value="__('Thumbnail Image')" />
                            
                            @if($article->thumbnail_url)
                                <div class="mb-3">
                                    <p class="text-sm text-gray-500 mb-1">Current Image:</p>
                                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}" class="h-32 w-auto object-cover rounded border">
                                </div>
                            @endif

                            <input type="file" name="thumbnail" id="thumbnail" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="text-xs text-gray-500 mt-1">Upload a new file to replace the current one.</p>
                            <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('articles.index') }}" class="text-gray-600 hover:text-gray-900 underline text-sm">Cancel</a>
                            <x-primary-button>
                                {{ __('Update Article') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>