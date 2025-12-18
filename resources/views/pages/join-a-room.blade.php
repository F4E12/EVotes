<x-app-layout>
     <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Join Vote') }}
            </h2>
        </div>
    </x-slot>

    <div class="relative z-10 flex flex-col items-center py-24 p-4">

       <div class="bg-white rounded-3xl shadow-2xl px-6 py-10 w-full max-w-sm">

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded mx-auto w-full">
                    <p class="text-red-700 text-sm font-semibold text-center">{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('join.process') }}" method="POST" class="space-y-8">
                @csrf

                <div class="flex flex-col items-center">
                    <label for="token" class="block text-gray-500 text-sm font-bold mb-3">
                        {{ __('Room Token') }}
                    </label>

                    <input
                        id="token"
                        name="token"
                        type="text"
                        required
                        autofocus
                        autocomplete="off"
                        class="w-full text-center text-4xl font-bold font-mono tracking-widest
                            bg-gray-50 border-2 border-gray-200 text-gray-800 rounded-xl py-5 px-4
                            placeholder-gray-300
                            focus:bg-white focus:border-purple-600 focus:ring-4 focus:ring-purple-200
                            transition-all outline-none"
                        placeholder="{{ __('Type it here!') }}"
                        maxlength="10"
                    />

                    @error('token')
                        <p class="text-red-500 text-sm font-semibold mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="h-4"></div>

                <div class="flex justify-center">
                    <button
                        type="submit"
                        class="w-full py-4 bg-gray-800 hover:bg-gray-900 text-white text-xl font-bold rounded-xl
                            shadow-lg transition-all transform active:scale-95">
                        {{ __('Enter') }}
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
