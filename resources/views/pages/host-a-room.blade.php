<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                {{ __('Host a New Room') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-blue-600 transition">
                &larr; {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded-r-md" role="alert">
                    <p class="font-bold">{{ __('Error') }}</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded-r-md">
                    <p class="font-bold">{{ __('Something went wrong') }}</p>
                    <ul class="list-disc list-inside text-sm mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-6 border border-gray-100">
                    <div class="p-6 sm:p-8">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-4 mb-6 flex items-center gap-2">
                            <span class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center text-sm">1</span>
                            {{ __('Room Details') }}
                        </h3>

                        <div class="mb-5">
                            <label for="title" class="block font-medium text-sm text-gray-700 mb-1">{{ __('Room Title') }}</label>
                            <input id="title" class="rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm transition duration-150"
                                   type="text" name="title" value="{{ old('title') }}" placeholder="{{ __('e.g. Student Council Election 2025') }}" required autofocus />
                        </div>

                        <div class="mb-5">
                            <label for="description" class="block font-medium text-sm text-gray-700 mb-1">{{ __('Description') }}</label>
                            <textarea id="description" rows="4"
                                      class="rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm transition duration-150"
                                      name="description" placeholder="{{ __('Explain what this voting is about...') }}" required>{{ old('description') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="start_date" class="block font-medium text-sm text-gray-700 mb-1">{{ __('Start Date & Time') }}</label>
                                <input id="start_date" class="rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm"
                                       type="datetime-local" name="start_date" value="{{ old('start_date') }}" required />
                            </div>

                            <div>
                                <label for="end_date" class="block font-medium text-sm text-gray-700 mb-1">{{ __('End Date & Time') }}</label>
                                <input id="end_date" class="rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm"
                                       type="datetime-local" name="end_date" value="{{ old('end_date')}}" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                    <div class="p-6 sm:p-8">
                        <div class="flex justify-between items-center border-b pb-4 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <span class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center text-sm">2</span>
                                {{ __('Candidates') }}
                            </h3>
                            <button type="button" id="add-candidate" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 border border-blue-200 rounded-lg font-semibold text-xs uppercase tracking-widest hover:bg-blue-100 active:bg-blue-200 focus:outline-none focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                {{ __('Add Candidate') }}
                            </button>
                        </div>

                        <div id="candidates-container" class="space-y-4">
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex items-center justify-end border-t border-gray-100">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium mr-6">{{ __('Cancel') }}</a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition shadow-md">
                            {{ __('Create Room & Generate Token') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <template id="candidate-template">
        <div class="candidate-item border border-gray-200 rounded-xl overflow-hidden shadow-sm transition-shadow hover:shadow-md bg-white">
            <div class="accordion-header cursor-pointer p-4 bg-gray-50 hover:bg-gray-100 transition flex justify-between items-center select-none">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 font-bold text-sm candidate-number">
                        #
                    </div>
                    <h4 class="font-semibold text-gray-800 candidate-title">{{ __('Candidate Name') }}</h4>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" class="remove-candidate text-red-500 hover:text-red-700 text-sm font-medium hover:underline px-2" style="display: none;">
                        {{ __('Remove') }}
                    </button>
                    <svg class="accordion-arrow w-5 h-5 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            <div class="accordion-body p-5 border-t border-gray-200" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="col-span-1">
                        <label class="block font-medium text-sm text-gray-700 mb-2">{{ __('Candidate Photo') }}</label>

                        <div class="relative mt-1 flex flex-col justify-center items-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:bg-gray-50 transition upload-box min-h-[160px]">

                            <div class="space-y-1 text-center placeholder-content w-full">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="text-sm text-gray-600">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>{{ __('Upload a file') }}</span>
                                        <input type="file" name="candidates[__INDEX__][photo_url]" class="sr-only file-input" accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">{{ __('PNG, JPG, GIF up to 2MB') }}</p>
                            </div>

                            <div class="hidden preview-content flex items-center justify-center">
                                <div class="relative group">
                                    <img src="" alt="Preview"
                                        class="w-32 h-32 object-cover rounded-xl border border-gray-200 shadow-md preview-image">

                                    <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1.5 shadow-md hover:bg-red-600 border-2 border-white remove-photo-btn transition-transform transform hover:scale-110" title="{{ __('Remove Photo') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-1 md:col-span-2 space-y-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">{{ __('Full Name') }}</label>
                            <input type="text" name="candidates[__INDEX__][name]" class="rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm" placeholder="{{ __('e.g. John Doe') }}" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-1">{{ __('Vision') }}</label>
                                <textarea name="candidates[__INDEX__][vision]" rows="3" class="rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm text-sm" placeholder="{{ __('Short vision statement...') }}" required></textarea>
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-1">{{ __('Mission') }}</label>
                                <textarea name="candidates[__INDEX__][mission]" rows="3" class="rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm text-sm" placeholder="{{ __('Detailed mission points...') }}" required></textarea>
                            </div>
                        </div>
                    </div>
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

                const numberBadge = item.querySelector('.candidate-number');
                numberBadge.textContent = candidateIndex + 1;
                const titleText = item.querySelector('.candidate-title');
                titleText.textContent = `{{ __('Candidate') }} ${candidateIndex + 1}`;

                item.querySelectorAll('[name]').forEach(el => {
                    el.name = el.name.replace('__INDEX__', candidateIndex);
                });

                const body = item.querySelector('.accordion-body');
                const arrow = item.querySelector('.accordion-arrow');
                body.style.display = 'block';
                arrow.classList.add('rotate-180');

                container.appendChild(item);
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
                const removeBtn = e.target.closest('.remove-candidate');

                if (header && !removeBtn && !e.target.closest('.preview-content')) {
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

                if (removeBtn) {
                    if(confirm("{{ __('Are you sure you want to remove this candidate?') }}")) {
                        e.target.closest('.candidate-item').remove();
                        reindexCandidates();
                    }
                }

                const removePhotoBtn = e.target.closest('.remove-photo-btn');
                if (removePhotoBtn) {
                    const uploadBox = removePhotoBtn.closest('.upload-box');
                    const fileInput = uploadBox.querySelector('.file-input');
                    const previewContent = uploadBox.querySelector('.preview-content');
                    const placeholderContent = uploadBox.querySelector('.placeholder-content');

                    fileInput.value = '';
                    previewContent.classList.add('hidden');
                    placeholderContent.classList.remove('hidden');
                }
            });

            container.addEventListener('change', function(e) {
                if (e.target.classList.contains('file-input')) {
                    const file = e.target.files[0];
                    const uploadBox = e.target.closest('.upload-box');
                    const previewContent = uploadBox.querySelector('.preview-content');
                    const placeholderContent = uploadBox.querySelector('.placeholder-content');
                    const previewImage = uploadBox.querySelector('.preview-image');

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            placeholderContent.classList.add('hidden');
                            previewContent.classList.remove('hidden');
                        }
                        reader.readAsDataURL(file);
                    }
                }
            });

            function reindexCandidates() {
                const items = container.querySelectorAll('.candidate-item');
                candidateIndex = 0;

                items.forEach(item => {
                    item.querySelector('.candidate-number').textContent = candidateIndex + 1;
                    item.querySelector('.candidate-title').textContent = `{{ __('Candidate') }} ${candidateIndex + 1}`;
                    item.querySelectorAll('[name]').forEach(el => {
                        el.name = el.name.replace(/candidates\[\d+\]/, `candidates[${candidateIndex}]`);
                    });
                    candidateIndex++;
                });
                updateRemoveButtons();
            }

            document.getElementById('add-candidate').addEventListener('click', addCandidate);

            addCandidate();
            addCandidate();
        });
    </script>
</x-app-layout>
