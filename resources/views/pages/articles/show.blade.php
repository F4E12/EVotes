<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Article') }}
            </h2>
            <a href="{{ route('articles.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                &larr; {{ __('Back to Articles') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <article class="bg-white overflow-hidden shadow-sm sm:rounded-[2.5rem] border border-gray-200 px-4 sm:px-8">
                <div class="h-4"></div>
                @if($article->thumbnail_url)
                    <div class="relative w-full h-64 md:h-96 bg-gray-100 group">
                        <img src="{{ Storage::url($article->thumbnail_url) }}"
                             alt="{{ $article->title }}"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent pointer-events-none"></div>
                    </div>
                @endif

                <div class="px-6 py-10 sm:px-10 sm:py-12">

                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-8 border-b border-gray-100 pb-6">

                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs uppercase border border-blue-200">
                                {{ substr($article->author->name ?? 'A', 0, 2) }}
                            </div>
                            <span class="font-semibold text-gray-900">{{ $article->author->name ?? __('Unknown Author') }}</span>
                        </div>

                        <span class="text-gray-300">&bull;</span>

                        <div class="flex items-center gap-1.5" title="{{ $article->created_at->format('d M Y H:i') }}">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>{{ $article->created_at->format('M d, Y') }}</span>
                        </div>

                        @if($article->room)
                            <span class="text-gray-300">&bull;</span>
                            <a href="{{ route('rooms.show', $article->room->room_id) }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition-colors border border-indigo-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                {{ $article->room->title }}
                            </a>
                        @endif
                    </div>

                    <h1 class="text-3xl md:text-5xl font-black text-gray-900 mb-8 leading-tight tracking-tight">
                        {{ $article->title }}
                    </h1>

                    <div class="prose prose-lg prose-blue max-w-none text-gray-700 leading-relaxed">
                        {!! $article->content !!}
                    </div>

                </div>

                @if(auth()->id() === $article->author_id)
                    <div class="bg-gray-50 px-8 py-6 border-t border-gray-100 flex justify-end">
                        <a href="{{ route('articles.edit', $article->id) }}" class="inline-flex items-center px-6 py-2.5 bg-white border border-gray-300 rounded-xl font-bold text-sm text-gray-700 shadow-sm hover:bg-gray-50 hover:text-blue-600 hover:border-blue-300 transition-all">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            {{ __('Edit Article') }}
                        </a>
                    </div>
                @endif

            </article>
        </div>
    </div>
</x-app-layout>
