<x-app-layout>
    <x-slot name="header">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('articles.index') }}" class="p-2 rounded-full bg-white border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-200 transition-colors shadow-sm group">
                    <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Write New Article
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen pb-32">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-10 items-start">

                    
                    <!-- LEFT COLUMN: MAIN CONTENT (2/3) -->
                    <div class="lg:col-span-3 space-y-8">
                        <!-- Card: Article Details -->
                        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 sm:px-8 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-3">

                                <div class="p-2 bg-white rounded-lg border border-gray-200 text-blue-600 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </div>
                                <h3 class="font-bold text-lg text-gray-900">Article Content</h3>
                            </div>
                            
                            <div class="px-6 sm:px-8 py-6 space-y-6">

                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-bold text-gray-700 mb-3">Headline</label>
                                    <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus 
                                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-4 px-5 text-lg font-bold placeholder-gray-300 transition-all"
                                           placeholder="Enter a catchy title..." />
                                    @error('title')
                                        <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- CKEditor Container -->
                                <div>
                                    <label for="content" class="block text-sm font-bold text-gray-700 mb-3">Body Content</label>
                                    <div class="rounded-xl overflow-hidden border border-gray-300 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all">
                                        <textarea name="content" id="content" rows="15" class="w-full">{{ old('content') }}</textarea>
                                    </div>
                                    @error('content')
                                        <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: SETTINGS & MEDIA (1/3) -->
                    <div class="lg:col-span-1 space-y-8">
                        
                        <!-- Card: Cover Image (Media) -->
                        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-200 overflow-hidden sticky top-6">
                            <div class="px-6 sm:px-8 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-3">
                                <div class="p-2 bg-white rounded-lg border border-gray-200 text-purple-600 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <h3 class="font-bold text-lg text-gray-900">Cover Image</h3>
                            </div>
                            
                            <div class="px-6 sm:px-8 py-6">

                                <div class="w-full">
                                    <label for="thumbnail" class="relative flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-purple-50/50 hover:border-purple-400 transition-all group overflow-hidden" id="dropzone">
                                        
                                        <!-- Default State (Upload Prompt) -->
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6" id="upload-prompt">
                                            <div class="p-3 bg-white rounded-full shadow-md mb-3 group-hover:scale-110 transition-transform">
                                                <svg class="w-8 h-8 text-gray-400 group-hover:text-purple-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                            </div>
                                            <p class="mb-1 text-sm text-gray-500 font-medium group-hover:text-purple-700">Click to upload</p>
                                            <p class="text-xs text-gray-400">PNG, JPG (Max 2MB)</p>
                                        </div>

                                        <!-- Preview State (Hidden by default) -->
                                        <img id="image-preview"
                                            class="absolute inset-0 w-full h-full object-cover hidden pointer-events-none z-10"
                                            src="#"
                                            alt="Preview">

                                        <!-- Remove Button (Hidden by default) -->
                                        <button type="button" id="remove-image" class="absolute top-3 right-3 bg-white text-red-500 p-1.5 rounded-full shadow-xl hover:bg-red-50 hidden z-10 ring-2 ring-white">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>

                                        <input id="thumbnail" name="thumbnail" type="file"
                                            class="absolute inset-0 opacity-0 cursor-pointer z-20"
                                            accept="image/*">

                                    </label>
                                    @error('thumbnail')
                                        <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Card: Settings -->
                        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 sm:px-8 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-3">

                                <div class="p-2 bg-white rounded-lg border border-gray-200 text-green-600 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                </div>
                                <h3 class="font-bold text-lg text-gray-900">Settings</h3>
                            </div>
                            
                            <div class="px-6 sm:px-8 py-6 space-y-5">

                                <div>
                                    <label for="related_room_id" class="block text-sm font-bold text-gray-700 mb-3">Related Room</label>
                                    <div class="relative">
                                        <select name="related_room_id" id="related_room_id" 
                                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 py-3.5 px-5 text-gray-700 appearance-none bg-white">
                                            <option value="">-- General News --</option>
                                            @foreach($rooms as $room)
                                                <option value="{{ $room->id }}">{{ $room->title }}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                    <p class="text-xs text-gray-400 mt-2">Tag this article to a specific election room.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Sticky Footer Actions -->
                <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-[0_-8px_30px_rgba(0,0,0,0.1)] z-50">
                    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-end gap-4">
                        <a href="{{ route('articles.index') }}" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg
                                    font-semibold text-xs text-white uppercase tracking-widest
                                    hover:bg-blue-700 active:bg-blue-900
                                    focus:outline-none focus:border-blue-900 focus:ring ring-blue-300
                                    disabled:opacity-25 transition shadow-md gap-2">

                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>

                            Publish Article
                        </button>

                    </div>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. CKEditor Init
            ClassicEditor
                .create(document.querySelector('#content'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'],
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h2', title: 'Heading 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h3', title: 'Heading 2', class: 'ck-heading_heading2' }
                        ]
                    }
                })
                .catch(error => {
                    console.error(error);
                });

            // 2. Image Preview Logic
            const fileInput = document.getElementById('thumbnail');
            const uploadPrompt = document.getElementById('upload-prompt');
            const imagePreview = document.getElementById('image-preview');
            const removeBtn = document.getElementById('remove-image');

            // Show Preview
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        removeBtn.classList.remove('hidden');
                        uploadPrompt.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Remove Image
            removeBtn.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent label click
                e.stopPropagation();
                fileInput.value = ''; // Clear input
                imagePreview.src = '#';
                imagePreview.classList.add('hidden');
                removeBtn.classList.add('hidden');
                uploadPrompt.classList.remove('hidden');
            });
        });
    </script>
    <style>
        /* CKEditor Tweaks for Tailwind */
        .ck-editor__editable_inline {
            min-height: 400px;
            padding: 1.5rem !important;
            border-bottom-left-radius: 0.75rem !important;
            border-bottom-right-radius: 0.75rem !important;
        }
        .ck-toolbar {
            border-top-left-radius: 0.75rem !important;
            border-top-right-radius: 0.75rem !important;
            background-color: #f9fafb !important;
        }
        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
            border-color: #d1d5db !important;
        }
        .ck.ck-editor__main>.ck-editor__editable.ck-focused {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
        }
        /* Content Reset */
        .ck-content h2 { font-size: 1.5em; font-weight: bold; margin-bottom: 0.5em; margin-top: 1em; }
        .ck-content h3 { font-size: 1.25em; font-weight: bold; margin-bottom: 0.5em; margin-top: 1em; }
        .ck-content p { margin-bottom: 1em; line-height: 1.7; color: #374151; }
        .ck-content ul { list-style-type: disc; padding-left: 1.5em; margin-bottom: 1em; }
        .ck-content ol { list-style-type: decimal; padding-left: 1.5em; margin-bottom: 1em; }
        .ck-content blockquote { border-left: 4px solid #e5e7eb; padding-left: 1em; color: #6b7280; font-style: italic; margin-bottom: 1em; }
        .ck-content a { color: #2563eb; text-decoration: underline; }
    </style>
    @endpush
</x-app-layout>