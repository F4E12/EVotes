<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Manage Articles') }}
            </h2>
            <a href="{{ route('articles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                {{ __('Write Article') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @php
                $myArticles = $articles->where('author_id', auth()->id());
                $otherArticles = $articles->where('author_id', '!=', auth()->id());
            @endphp

            <div class="space-y-4">
                <h3 class="text-xl font-bold text-gray-900 pl-1 border-l-4 border-blue-600 leading-none">&nbsp;{{ __('My Articles') }}</h3>
                <div class = "h-8"></div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto">
                            <table class="min-w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Image') }}</th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Title') }}</th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Room Tag') }}</th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Date') }}</th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($myArticles as $article)
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            @if($article->thumbnail_url)
                                                <img src="{{ Storage::url($article->thumbnail_url) }}" alt="Thumb" class="h-10 w-10 rounded object-cover border border-gray-100">
                                            @else
                                                <span class="text-gray-400 text-xs">{{ __('No Image') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap font-bold">{{ $article->title }}</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            @if($article->room)
                                                <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                    <span class="relative">{{ $article->room->title }}</span>
                                                </span>
                                            @else
                                                <span class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                    <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                                    <span class="relative">{{ __('General') }}</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{ $article->created_at->format('d M Y') }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <div class="flex items-center gap-3">
                                                <a href="{{ route('articles.show', $article->id) }}" class="text-gray-600 hover:text-gray-900 font-medium">{{ __('View') }}</a>
                                                <a href="{{ route('articles.edit', $article->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">{{ __('Edit') }}</a>
                                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">{{ __('Delete') }}</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                            {{ __('You haven\'t written any articles yet. Click "Write Article" to start!') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class = "h-8"></div>

            <div class="space-y-4">
                <h3 class="text-xl font-bold text-gray-900 pl-1 border-l-4 border-purple-600 leading-none">&nbsp;{{ __('Community News') }}</h3>
                 <div class = "h-4"></div>
                @if($otherArticles->isEmpty())
                    <div class="bg-white rounded-lg border border-gray-200 p-8 text-center text-gray-500">
                        {{ __('No articles from other users yet.') }}
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($otherArticles as $article)
                            <article class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-200 flex flex-col h-full">

                                <a href="{{ route('articles.show', $article->id) }}" class="relative h-48 bg-gray-100 overflow-hidden block group">
                                    @if($article->thumbnail_url)
                                        <img src="{{ Storage::url($article->thumbnail_url) }}"
                                             alt="{{ $article->title }}"
                                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-50 text-gray-300">
                                            <svg class="w-12 h-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif

                                    @if($article->room)
                                        <div class="absolute top-3 left-3">
                                            <span class="px-2 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-bold text-gray-800 rounded-md shadow-sm">
                                                {{ $article->room->title }}
                                            </span>
                                        </div>
                                    @endif
                                </a>

                                <div class="p-5 flex flex-col flex-grow">

                                    <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                                        <span class="font-medium text-gray-900">{{ $article->author->name ?? __('Unknown') }}</span>
                                        <span>{{ $article->created_at->format('M d') }}</span>
                                    </div>

                                    <h4 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 hover:text-blue-600 transition-colors">
                                        <a href="{{ route('articles.show', $article->id) }}">
                                            {{ $article->title }}
                                        </a>
                                    </h4>

                                    <div class="text-gray-500 text-sm line-clamp-3 mb-4 flex-grow">
                                        {!! Str::limit($article->content, 150) !!}

                                    </div>

                                    <div class="pt-4 border-t border-gray-100 mt-auto">
                                        <a href="{{ route('articles.show', $article->id) }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors flex items-center gap-1 group">
                                            {{ __('Read Article') }}
                                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
