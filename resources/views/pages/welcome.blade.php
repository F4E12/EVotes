@section('title', 'EVotes — Secure Digital Voting')

<x-app-layout>
  <div class="min-h-screen bg-white text-gray-900">
    <div class="max-w-6xl mx-auto px-6 py-12">

      <!-- HERO (Blue–White, Simple, Clean) -->
      <header class="mb-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

          <!-- Left side text -->
          <div>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-blue-800 leading-tight">
              EVotes 
            </h1>

            <p class="mt-4 text-gray-700 text-lg max-w-md">
              A clean and dependable digital voting system.
            <div class="mt-6 flex flex-col sm:flex-row gap-3">
              <a href="{{ route('host-a-room') }}" class="px-6 py-3 rounded-lg bg-blue-700 text-white font-semibold hover:bg-blue-800 transition">
                Host a Room
              </a>
              <a href="{{ route('join-a-room') }}" class="px-6 py-3 rounded-lg border border-blue-200 text-blue-700 bg-white hover:bg-blue-50 transition">
                Join with Code
              </a>
            </div>
          </div>

          <!-- Right side visual (Very Simple) -->
          <div>
            <div class="border border-blue-200 rounded-xl p-6 bg-blue-50">
              <h4 class="font-semibold text-blue-800 mb-2">Live Room Preview</h4>
              <p class="text-sm text-blue-700 mb-4">Student Council Election 2026</p>

              <div class="flex items-center justify-between mb-6">
                <div>
                  <div class="text-3xl font-bold text-blue-900">184</div>
                  <div class="text-xs text-blue-600">Votes counted</div>
                </div>

                <!-- Tiny bars -->
                <div class="w-32 h-20 border border-blue-200 rounded-md flex items-end justify-around p-2 bg-white">
                  <div class="w-3 bg-blue-400 h-6 rounded-sm"></div>
                  <div class="w-3 bg-blue-600 h-10 rounded-sm"></div>
                  <div class="w-3 bg-blue-300 h-14 rounded-sm"></div>
                  <div class="w-3 bg-blue-500 h-8 rounded-sm"></div>
                </div>
              </div>

              <div class="text-sm text-blue-600">Results hidden until host reveals them.</div>
            </div>
          </div>

        </div>
      </header>

      <!-- FEATURES (clean blue-white cards) -->
      <section class="mb-20">
        <h2 class="text-2xl font-bold text-blue-800 mb-6">Core Features</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

          <div class="p-6 bg-white border border-blue-200 rounded-xl shadow-sm">
            <h3 class="font-semibold text-blue-800">Authentication</h3>
            <p class="mt-2 text-sm text-gray-700">User accounts, login, profiles, passwords, and secure sessions.</p>
          </div>

          <div class="p-6 bg-white border border-blue-200 rounded-xl shadow-sm">
            <h3 class="font-semibold text-blue-800">Host Dashboard</h3>
            <p class="mt-2 text-sm text-gray-700">Create rooms, manage candidates, schedules, and access tokens.</p>
          </div>

          <div class="p-6 bg-white border border-blue-200 rounded-xl shadow-sm">
            <h3 class="font-semibold text-blue-800">Voting Interface</h3>
            <p class="mt-2 text-sm text-gray-700">Simple ballot, candidate visuals, and backend double-vote prevention.</p>
          </div>

          <div class="p-6 bg-white border border-blue-200 rounded-xl shadow-sm">
            <h3 class="font-semibold text-blue-800">Results & Analytics</h3>
            <p class="mt-2 text-sm text-gray-700">Counts, percentages, and reveal controls — straightforward and clear.</p>
          </div>

        </div>
      </section>

      <!-- CTA -->
      <section class="border border-blue-200 rounded-xl p-6 bg-blue-50 flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
          <h3 class="text-lg font-bold text-blue-800">Ready to run your election?</h3>
          <p class="text-sm text-blue-700 mt-1">Create a room, share access tokens, and stay fully in control.</p>
        </div>

        <a href="{{ route('host-a-room') }}" class="px-6 py-3 rounded-lg bg-blue-700 text-white font-semibold hover:bg-blue-800 transition">
          Create Room
        </a>
      </section>

    </div>
  </div>

</x-app-layout>