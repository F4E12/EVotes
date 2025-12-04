<x-app-layout>
    <x-slot name="header">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('articles.index') }}" class="p-2 rounded-full bg-white border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-200 transition shadow-sm group">
                    <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Edit Article
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen pb-32">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-10 items-start">

                    <!-- LEFT COLUMN (MAIN CONTENT) -->
                    <div class="lg:col-span-3 space-y-8">

                        <!-- Card: Article Content -->
                        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-200 overflow-hidden">

                            <!-- Header -->
                            <div class="px-6 sm:px-8 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-3">
                                <div class="p-2 bg-white rounded-lg border border-gray-200 text-blue-600 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-lg text-gray-900">Article Content</h3>
                            </div>

                            <!-- Body -->
                            <div class="px-6 sm:px-8 py-6 space-y-6">

                                <!-- Title -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-3">Headline</label>
                                    <input 
                                        type="text"
                                        name="title"
                                        value="{{ old('title', $article->title) }}"
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-4 px-5 text-lg font-bold placeholder-gray-300 transition-all"
                                        placeholder="Enter a catchy title..."
                                        required
                                    >
                                    @error('title')
                                        <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Content -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-3">Body Content</label>

                                    <div class="rounded-xl overflow-hidden border border-gray-300 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all">
                                        <textarea id="content" name="content" rows="15" class="w-full">{{ old('content', $article->content) }}</textarea>
                                    </div>

                                    @error('content')
                                        <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN (SIDEBAR) -->
                    <div class="lg:col-span-1 space-y-8">

                        <!-- COVER IMAGE CARD -->
                        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-200 overflow-hidden sticky top-6">

                            <div class="px-6 sm:px-8 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-3">
                                <div class="p-2 bg-white rounded-lg border border-gray-200 text-purple-600 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-lg text-gray-900">Cover Image</h3>
                            </div>

                            <div class="px-6 sm:px-8 py-6 space-y-4">

                                @if($article->thumbnail_url)
                                    <div>
                                        <img src="{{ asset('storage/'.$article->thumbnail_url) }}"
                                            class="w-full h-40 object-cover rounded-xl border border-gray-200 shadow-sm">
                                    </div>
                                @endif

                                <input 
                                    type="file"
                                    name="thumbnail"
                                    class="block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                >

                                <p class="text-xs text-gray-500">Upload a new image to replace the current one.</p>

                                @error('thumbnail')
                                    <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                                @enderror

                            </div>
                        </div>

                        <div class = "h-8"></div>

                        <!-- SETTINGS CARD -->
                        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-200 overflow-hidden">

                            <div class="px-6 sm:px-8 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-3">
                                <div class="p-2 bg-white rounded-lg border border-gray-200 text-green-600 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-lg text-gray-900">Settings</h3>
                            </div>

                            <div class="px-6 sm:px-8 py-6 space-y-4">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Related Room</label>

                                <select 
                                    name="related_room_id"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 py-3.5 px-5"
                                >
                                    <option value="">-- General News --</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ $article->related_room_id == $room->id ? 'selected' : '' }}>
                                            {{ $room->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

                <div class = "h-8"></div>

                <!-- FOOTER BUTTONS -->
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('articles.index') }}"
                       class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        Cancel
                    </a>

                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg
                                   font-semibold text-xs text-white uppercase tracking-widest
                                   hover:bg-blue-700 active:bg-blue-900
                                   focus:outline-none focus:border-blue-900 focus:ring ring-blue-300
                                   disabled:opacity-25 transition shadow-md gap-2">
                        Update Article
                    </button>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#content'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
        }).catch(error => console.error(error));
    </script>
    @endpush

</x-app-layout>
