<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Article') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Article Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="related_room_id" :value="__('Tag to Room (Optional)')" />
                            <select name="related_room_id" id="related_room_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                                <option value="">-- General News (No Specific Room) --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->title }}</option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Connect this article to a specific voting room.</p>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="content" :value="__('Content')" />
                            <textarea name="content" id="content" rows="10">{{ old('content') }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="thumbnail" :value="__('Thumbnail Image')" />
                            <input type="file" name="thumbnail" id="thumbnail" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('articles.index') }}" class="text-gray-600 hover:text-gray-900 underline text-sm">Cancel</a>
                            <x-primary-button>
                                {{ __('Save Article') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        ClassicEditor
            .create(document.querySelector('#content'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                    ]
                }
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>
<style>
    /* Set a minimum height for the editor so it doesn't look too small */
    .ck-editor__editable_inline {
        min-height: 300px;
    }
    /* Fix for Tailwind CSS resetting list styles */
    .ck-content ul {
        list-style-type: disc;
        padding-left: 20px;
    }
    .ck-content ol {
        list-style-type: decimal;
        padding-left: 20px;
    }
</style>
@endpush
</x-app-layout>
