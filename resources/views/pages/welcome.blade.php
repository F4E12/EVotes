@section('title', 'EVotes — Secure Digital Voting')

<x-app-layout>
  <div class="min-h-screen bg-white text-gray-900">
    <div class="max-w-6xl mx-auto px-6 py-12">

      <header class="mb-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

          <div>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-blue-800 leading-tight">
              EVotes
            </h1>

            <p class="mt-4 text-gray-700 text-lg max-w-md">
              {{ __('A clean and dependable digital voting system.') }}
            </p>
            <div class="mt-6 flex flex-col sm:flex-row gap-3">
              <a href="{{ route('host-a-room') }}" class="px-6 py-3 rounded-lg bg-blue-700 text-white font-semibold hover:bg-blue-800 transition">
                {{ __('Host a Room') }}
              </a>
              <a href="{{ route('join-a-room') }}" class="px-6 py-3 rounded-lg border border-blue-200 text-blue-700 bg-white hover:bg-blue-50 transition">
                {{ __('Join with Code') }}
              </a>
            </div>
          </div>

          <div>
            <div class="border border-blue-200 rounded-xl p-6 bg-blue-50">
              <h4 class="font-semibold text-blue-800 mb-2">{{ __('Live Room Preview') }}</h4>
              <p class="text-sm text-blue-700 mb-4">{{ __('Student Council Election 2026') }}</p>

              <div class="flex items-center justify-between mb-6">
                <div>
                  <div class="text-3xl font-bold text-blue-900">184</div>
                  <div class="text-xs text-blue-600">{{ __('Votes counted') }}</div>
                </div>

                <div class="w-32 h-20 border border-blue-200 rounded-md flex items-end justify-around p-2 bg-white">
                  <div class="w-3 bg-blue-400 h-6 rounded-sm"></div>
                  <div class="w-3 bg-blue-600 h-10 rounded-sm"></div>
                  <div class="w-3 bg-blue-300 h-14 rounded-sm"></div>
                  <div class="w-3 bg-blue-500 h-8 rounded-sm"></div>
                </div>
              </div>

              <div class="text-sm text-blue-600">{{ __('Results hidden until host reveals them.') }}</div>
            </div>
          </div>

        </div>
      </header>

      <section class="mb-20">
        <h2 class="text-2xl font-bold text-blue-800 mb-6">{{ __('Core Features') }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

          <div class="p-6 bg-white border border-blue-200 rounded-xl shadow-sm">
            <h3 class="font-semibold text-blue-800">{{ __('Authentication') }}</h3>
            <p class="mt-2 text-sm text-gray-700">{{ __('User accounts, login, profiles, passwords, and secure sessions.') }}</p>
          </div>

          <div class="p-6 bg-white border border-blue-200 rounded-xl shadow-sm">
            <h3 class="font-semibold text-blue-800">{{ __('Host Dashboard') }}</h3>
            <p class="mt-2 text-sm text-gray-700">{{ __('Create rooms, manage candidates, schedules, and access tokens.') }}</p>
          </div>

          <div class="p-6 bg-white border border-blue-200 rounded-xl shadow-sm">
            <h3 class="font-semibold text-blue-800">{{ __('Voting Interface') }}</h3>
            <p class="mt-2 text-sm text-gray-700">{{ __('Simple ballot, candidate visuals, and backend double-vote prevention.') }}</p>
          </div>

          <div class="p-6 bg-white border border-blue-200 rounded-xl shadow-sm">
            <h3 class="font-semibold text-blue-800">{{ __('Results & Analytics') }}</h3>
            <p class="mt-2 text-sm text-gray-700">{{ __('Counts, percentages, and reveal controls — straightforward and clear.') }}</p>
          </div>

        </div>
      </section>

      <section class="border border-blue-200 rounded-xl p-6 bg-blue-50 flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
          <h3 class="text-lg font-bold text-blue-800">{{ __('Ready to run your election?') }}</h3>
          <p class="text-sm text-blue-700 mt-1">{{ __('Create a room, share access tokens, and stay fully in control.') }}</p>
        </div>

        <a href="{{ route('host-a-room') }}" class="px-6 py-3 rounded-lg bg-blue-700 text-white font-semibold hover:bg-blue-800 transition">
          {{ __('Create Room') }}
        </a>
      </section>

    </div>
  </div>
</x-app-layout>
