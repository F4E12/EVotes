<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Read Article') }}
            </h2>
            <a href="{{ route('articles.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Back to Articles
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                @if($article->thumbnail_url)
                    <div class="w-full h-64 md:h-96 overflow-hidden">
                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="p-6 md:p-10 text-gray-900">
                    
                    <div class="flex items-center text-sm text-gray-500 mb-4 space-x-4">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ $article->author->name ?? 'Unknown' }}
                        </span>
                        <span>&bull;</span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $article->created_at->format('d M Y') }}
                        </span>
                        @if($article->room)
                            <span>&bull;</span>
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                {{ $article->room->title }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">
                        {{ $article->title }}
                    </h1>

                    <div class="prose max-w-none text-gray-800 leading-relaxed">
                        {!! $article->content !!}
                    </div>

                </div>
                
                @if(auth()->id() === $article->author_id)
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end space-x-3">
                        <a href="{{ route('articles.edit', $article->id) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit Article</a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>