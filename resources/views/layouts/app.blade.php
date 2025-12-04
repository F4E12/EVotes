<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EVotes') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 flex flex-col min-h-screen" x-data="{ open: false }">

    <!-- === NAVBAR === -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left Side: Logo & Main Menu -->
                <div class="flex items-center gap-8">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="text-2xl font-bold text-blue-600 tracking-tight flex items-center gap-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        EVotes
                    </a>
                    
                    <!-- Desktop Links -->
                    <div class="hidden sm:flex space-x-1">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" 
                           class="{{ request()->routeIs('dashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-blue-600 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">
                            Dashboard
                        </a>

                        <!-- Join Vote -->
                        <a href="{{ route('join-a-room') }}" 
                           class="{{ request()->routeIs('join-a-room') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-blue-600 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">
                            Join Vote
                        </a>

                        <!-- History -->
                        <a href="{{ route('history') }}" 
                           class="{{ request()->routeIs('history') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-blue-600 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">
                            History
                        </a>

                        <!-- Articles (Route::resource creates 'articles.index') -->
                        <a href="{{ route('articles.index') }}" 
                           class="{{ request()->routeIs('articles.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-blue-600 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">
                            News & Articles
                        </a>
                    </div>
                </div>

                <!-- Right Side: User Dropdown -->
                <div class="hidden sm:flex items-center sm:ml-6">
                    <div class="relative ml-3" x-data="{ open: false }">
                        <div>
                            <button @click="open = ! open" type="button" class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none" 
                             style="display: none;">
                            
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Your Profile
                            </a>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Responsive) -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-200">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('dashboard') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50' }} text-base font-medium transition duration-150 ease-in-out">Dashboard</a>
                <a href="{{ route('join-a-room') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('join-a-room') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50' }} text-base font-medium transition duration-150 ease-in-out">Join Vote</a>
                <a href="{{ route('history') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('history') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50' }} text-base font-medium transition duration-150 ease-in-out">History</a>
                <a href="{{ route('articles.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('articles.*') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50' }} text-base font-medium transition duration-150 ease-in-out">Articles</a>
            </div>
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">Your Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-red-600 hover:text-red-800 hover:bg-gray-50">Log Out</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- === HEADER === -->
    @if (isset($header))
        <header class="bg-white shadow-sm border-b border-gray-100">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- === CONTENT === -->
    <main class="flex-grow">
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </div>
    </main>

    <!-- === FOOTER === -->
    <footer class="bg-gray-800 text-gray-300 mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center">

            <div class="flex justify-center mb-3">
                <div class="flex items-center gap-2 text-white font-semibold">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    EVotes
                </div>
            </div>

            <p class="text-sm text-gray-400">
                &copy; {{ date('Y') }} EVotes — Secure, simple, modern voting.
            </p>

        </div>
    </footer>



</body>
</html>