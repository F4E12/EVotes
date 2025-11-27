<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Host a Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Room Details --}}
                        <div>
                            <label for="title" class="block font-medium text-sm text-gray-700">{{ __('Title') }}</label>
                            <input id="title" class="block mt-1 w-full" type="text" name="title"
                                value="{{ old('title') }}" required autofocus />
                        </div>

                        <div class="mt-4">
                            <label for="description"
                                class="block font-medium text-sm text-gray-700">{{ __('Description') }}</label>
                            <textarea id="description" class="block mt-1 w-full" name="description"
                                required>{{ old('description') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label for="start_date"
                                class="block font-medium text-sm text-gray-700">{{ __('Start Date') }}</label>
                            <input id="start_date" class="block mt-1 w-full" type="datetime-local" name="start_date"
                                value="{{ old('start_date') }}" required />
                        </div>

                        <div class="mt-4">
                            <label for="end_date"
                                class="block font-medium text-sm text-gray-700">{{ __('End Date') }}</label>
                            <input id="end_date" class="block mt-1 w-full" type="datetime-local" name="end_date"
                                value="{{ old('end_date')}}" required />
                        </div>

                        {{-- Candidates --}}
                        <div class="mt-6">
                            <h3 class="text-xl font-bold">Candidates</h3>
                            <div id="candidates-container" class="mt-4">
                                {{-- Candidate accordion items will be injected here --}}
                            </div>
                            <div class="flex justify-end mt-4">
                                <button type="button" id="add-candidate"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-4 rounded-full">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Create Room') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <template id="candidate-template">
        <div class="candidate-item border rounded mt-2">
            <div
                class="accordion-header cursor-pointer p-4 bg-gray-100 hover:bg-gray-200 flex justify-between items-center">
                <h4 class="font-semibold">Candidate</h4>
                <div class="flex items-center">
                    <svg class="accordion-arrow w-6 h-6 transform transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    <button type="button"
                        class="remove-candidate bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded-full ml-4"
                        style="display: none;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="accordion-body p-4" style="display: none;">
                <div class="mt-2">
                    <label class="block font-medium text-sm text-gray-700">Name</label>
                    <input type="text" name="candidates[__INDEX__][name]" class="mt-1 block w-full" required>
                </div>
                <div class="mt-2">
                    <label class="block font-medium text-sm text-gray-700">Vision</label>
                    <textarea name="candidates[__INDEX__][vision]" class="mt-1 block w-full" required></textarea>
                </div>
                <div class="mt-2">
                    <label class="block font-medium text-sm text-gray-700">Mission</label>
                    <textarea name="candidates[__INDEX__][mission]" class="mt-1 block w-full" required></textarea>
                </div>
                <div class="mt-2">
                    <label class="block font-medium text-sm text-gray-700">Photo</label>
                    <input type="file" name="candidates[__INDEX__][photo_url]" class="mt-1 block w-full">
                </div>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('candidates-container');
            const template = document.getElementById('candidate-template');
            let candidateIndex = 0;

            function addCandidate() {
                const clone = template.content.cloneNode(true);
                const item = clone.querySelector('.candidate-item');

                const header = item.querySelector('.accordion-header h4');
                header.textContent = `Candidate ${candidateIndex + 1}`;

                item.querySelectorAll('[name]').forEach(el => {
                    el.name = el.name.replace('__INDEX__', candidateIndex);
                });

                // Open the first candidate by default, and any new ones
                if (candidateIndex === 0) {
                    const body = item.querySelector('.accordion-body');
                    const arrow = item.querySelector('.accordion-arrow');
                    body.style.display = 'block';
                    arrow.classList.add('rotate-180');
                }

                container.appendChild(clone);
                updateRemoveButtons();
                candidateIndex++;
            }

            function updateRemoveButtons() {
                const items = container.querySelectorAll('.candidate-item');
                items.forEach((item, index) => {
                    const button = item.querySelector('.remove-candidate');
                    if (button) {
                        button.style.display = items.length > 2 ? 'block' : 'none';
                    }
                });
            }

            container.addEventListener('click', function (e) {
                const header = e.target.closest('.accordion-header');
                if (header && !e.target.closest('.remove-candidate')) {
                    const item = header.closest('.candidate-item');
                    const body = item.querySelector('.accordion-body');
                    const arrow = item.querySelector('.accordion-arrow');

                    if (body.style.display === 'block') {
                        body.style.display = 'none';
                        arrow.classList.remove('rotate-180');
                    } else {
                        body.style.display = 'block';
                        arrow.classList.add('rotate-180');
                    }
                }

                if (e.target.closest('.remove-candidate')) {
                    e.target.closest('.candidate-item').remove();

                    const items = container.querySelectorAll('.candidate-item');
                    candidateIndex = 0;
                    items.forEach(item => {
                        item.querySelector('.accordion-header h4').textContent = `Candidate ${candidateIndex + 1}`;
                        item.querySelectorAll('[name]').forEach(el => {
                            const newName = el.name.replace(/candidates\[\d+\]/, `candidates[${candidateIndex}]`);
                            el.name = newName;
                        });
                        candidateIndex++;
                    });
                    updateRemoveButtons();
                }
            });

            document.getElementById('add-candidate').addEventListener('click', addCandidate);

            // Add initial 2 candidates
            addCandidate();
            addCandidate();
        });
    </script>
</x-app-layout>