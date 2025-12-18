@section('title', 'EVotes — Reliable Digital Voting')

<x-app-layout>
    <div class="min-h-screen bg-slate-50 text-slate-900 font-sans">

        <header class="relative overflow-hidden bg-white border-b border-slate-200">
            <div class="max-w-6xl mx-auto px-6 py-20 lg:py-32">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <span
                            class="inline-block px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-wider mb-4">
                            {{ __('Secure & Transparent') }}
                        </span>
                        <h1 class="text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight tracking-tight">
                            Voting made <span class="text-blue-600">effortless.</span>
                        </h1>
                        <p class="mt-6 text-lg text-slate-600 leading-relaxed max-w-lg">
                            {{ __('EVotes provides a stable, tamper-proof environment for organizations to conduct elections with absolute integrity and zero technical overhead.') }}
                        </p>

                        <div class="mt-10 flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('host-a-room') }}"
                                class="px-8 py-4 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all text-center">
                                {{ __('Host a Room') }}
                            </a>
                            <a href="{{ route('join-a-room') }}"
                                class="px-8 py-4 rounded-xl border border-slate-300 text-slate-700 bg-white font-bold hover:bg-slate-50 transition-all text-center">
                                {{ __('Join with Code') }}
                            </a>
                        </div>
                    </div>

                    <div class="relative">
                        <div
                            class="absolute -inset-4 bg-gradient-to-tr from-blue-100 to-indigo-100 rounded-3xl blur-2xl opacity-50">
                        </div>
                        <div class="relative border border-slate-200 rounded-2xl p-8 bg-white shadow-xl">
                            <div class="flex items-center justify-between mb-8">
                                <div>
                                    <h4 class="font-bold text-slate-800 text-xl">{{ __('Annual Board Election') }}</h4>
                                    <p class="text-sm text-slate-500">{{ __('Room ID: #VOTE-2025') }}</p>
                                </div>
                                <span
                                    class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-medium">
                                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                    {{ __('Live') }}
                                </span>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="font-medium text-slate-700">Sarah Jenkins</span>
                                        <span class="text-slate-500">42%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                        <div class="bg-blue-600 h-full rounded-full" style="width: 42%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="font-medium text-slate-700">Marcus Thorne</span>
                                        <span class="text-slate-500">38%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                        <div class="bg-blue-400 h-full rounded-full" style="width: 38%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 pt-6 border-t border-slate-100 flex justify-between items-center">
                                <div class="text-2xl font-bold text-slate-900">1,240 <span
                                        class="text-sm font-normal text-slate-500 uppercase tracking-wide ml-1">Votes</span>
                                </div>
                                <div class="text-xs text-slate-400 font-medium italic">{{ __('End-to-end encrypted') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section class="py-20 bg-white">
            <div class="max-w-6xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-slate-900 mb-12">{{ __('Built for every community') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="group p-4">
                        <div
                            class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800">{{ __('Schools') }}</h3>
                        <p class="mt-2 text-sm text-slate-600">
                            {{ __('Engage students in democracy through council and club elections.') }}</p>
                    </div>
                    <div class="group p-4">
                        <div
                            class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800">{{ __('Organizations') }}</h3>
                        <p class="mt-2 text-sm text-slate-600">
                            {{ __('Formal board decisions and leadership transitions made simple.') }}</p>
                    </div>
                    <div class="group p-4">
                        <div
                            class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800">{{ __('Communities') }}</h3>
                        <p class="mt-2 text-sm text-slate-600">
                            {{ __('Run hobbyist polls or local neighborhood association votes.') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-slate-50">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-slate-900">{{ __('Engineered for Reliability') }}</h2>
                    <p class="text-slate-600 mt-4">{{ __('The tools you need to manage a fair and modern election.') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div
                        class="flex gap-6 p-8 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                        <div
                            class="shrink-0 w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center font-bold">
                            1</div>
                        <div>
                            <h3 class="font-bold text-slate-800 mb-2">{{ __('Secure Authentication') }}</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                {{ __('Identity verification ensures only authorized voters participate. Sessions are encrypted and protected against unauthorized access.') }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex gap-6 p-8 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                        <div
                            class="shrink-0 w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center font-bold">
                            2</div>
                        <div>
                            <h3 class="font-bold text-slate-800 mb-2">{{ __('Advanced Host Control') }}</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                {{ __('Generate unique access tokens, set strict schedules, and manage candidate profiles from a centralized command center.') }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex gap-6 p-8 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                        <div
                            class="shrink-0 w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center font-bold">
                            3</div>
                        <div>
                            <h3 class="font-bold text-slate-800 mb-2">{{ __('Intuitive Ballot') }}</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                {{ __('A clean, distraction-free voting interface designed for clarity. Prevents double-voting automatically at the database level.') }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex gap-6 p-8 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                        <div
                            class="shrink-0 w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center font-bold">
                            4</div>
                        <div>
                            <h3 class="font-bold text-slate-800 mb-2">{{ __('Real-time Analytics') }}</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                {{ __('Monitor turnout live. Results can be kept hidden until the election concludes to maintain suspense and prevent bias.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <div class="bg-blue-600 rounded-3xl p-12 shadow-2xl shadow-blue-200">
                    <h2 class="text-3xl font-bold text-white mb-4">{{ __('Ready to modernize your next election?') }}
                    </h2>
                    <p class="text-blue-100 mb-10 text-lg">
                        {{ __('Join thousands of organizations using EVotes for transparent decision-making.') }}</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('register') }}"
                            class="px-10 py-4 bg-white text-blue-700 font-bold rounded-xl hover:bg-slate-100 transition-colors">
                            {{ __('Get Started for Free') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </div>
</x-app-layout>
