<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Kelas
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.classes.update', $class) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    {{-- Nama kelas --}}
                    <div>
                        <x-input-label for="name" value="Nama Kelas" />
                        <x-text-input
                            id="name"
                            name="name"
                            type="text"
                            class="mt-1 block w-full"
                            value="{{ old('name', $class->name) }}"
                            required
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <x-input-label for="description" value="Deskripsi Kelas" />
                        <x-text-input
                            id="description"
                            name="description"
                            type="text"
                            class="mt-1 block w-full"
                            value="{{ old('description', $class->description) }}"
                        />
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>

                    {{-- Pengajar --}}
                    <div>
                        <x-input-label for="instructor_name" value="Nama Pengajar" />
                        <x-text-input
                            id="instructor_name"
                            name="instructor_name"
                            type="text"
                            class="mt-1 block w-full"
                            value="{{ old('instructor_name', $class->instructor_name) }}"
                        />
                        <x-input-error :messages="$errors->get('instructor_name')" class="mt-1" />
                    </div>

                    {{-- Tanggal mulai --}}
                    <div>
                        <x-input-label for="start_date" value="Sampai Tanggal" />
                        <input
                            type="date"
                            id="start_date"
                            name="start_date"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ old('start_date', $class->start_date) }}"
                        >
                        <x-input-error :messages="$errors->get('end_date')" class="mt-1" />
                    </div>

                    {{-- Tanggal selesai --}}
                    <div>
                        <x-input-label for="end_date" value="Sampai Tanggal" />
                        <input
                            type="date"
                            id="end_date"
                            name="end_date"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ old('end_date', $class->end_date) }}"
                        >
                        <x-input-error :messages="$errors->get('end_date')" class="mt-1" />
                    </div>

                    {{-- Jam mulai --}}
                    <div class="mb-3">
                        <label class="form-label">Jam Mulai</label>
                        <input
                            type="time"
                            name="start_time"
                            class="form-control"
                            value="{{ old('start_time', $class->start_time) }}"
                        >
                        @error('start_time')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jam berakhir --}}
                    <div class="mb-3">
                        <label class="form-label">Jam Berakhir</label>
                        <input
                            type="time"
                            name="end_time"
                            class="form-control"
                            value="{{ old('end_time', $class->end_time) }}"
                        >
                        @error('end_time')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
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
