<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Kelas
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.classes.store') }}" method="POST" class="space-y-4">
                    @csrf

                    {{--
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date', --}}

                    <div>
                        <x-input-label for="name" value="Nama Kelas" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            value="{{ old('name') }}" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Deskripsi Kelas" />
                        <x-text-input id="description" name="description" type="text" class="mt-1 block w-full"
                            value="{{ old('description') }}" required />
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="instructor_name" value="Nama Pengajar" />
                        <x-text-input id="instructor_name" name="instructor_name" type="text"
                            class="mt-1 block w-full" value="{{ old('instructor_name') }}" />
                    </div>

                    <div>
                        <x-input-label for="start_date" value="Mulai Tanggal" />
                        <input type="date" id="start_date" name="start_date"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ old('start_date') }}">
                        <x-input-error :messages="$errors->get('start_date')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="end_date" value="Sampai Tanggal" />
                        <input type="date" id="end_date" name="end_date"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ old('end_date') }}">
                        <x-input-error :messages="$errors->get('end_date')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="start_time" value="Mulai Jam" />
                        <input type="time" id="start_time" name="start_time"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ old('start_time') }}">
                        <x-input-error :messages="$errors->get('start_time')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="end_time" value="Jam Berakhir" />
                        <input type="time" id="end_time" name="end_time"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ old('end_time') }}">
                        <x-input-error :messages="$errors->get('end_time')" class="mt-1" />
                        </div>

                    <div class="flex justify-end space-x-4 mt-4">
                        <a href="{{ route('classes.index') }}" class="px-4 py-2 bg-gray-100 rounded text-sm">
                            Batal
                        </a>
                        <x-primary-button>
                            Simpan
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
