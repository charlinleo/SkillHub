<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Peserta
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.participants.update', $peserta) }}" method="POST" class="space-y-4">
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
                            value="{{ old('name', $peserta->name) }}"
                            required
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email Peserta" />
                        <x-text-input
                            id="email"
                            name="email"
                            type="email"
                            class="mt-1 block w-full"
                            value="{{ old('email', $peserta->email) }}"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="phone" value="Nomor Telepon" />
                        <x-text-input
                            id="phone"
                            name="phone"
                            type="number"
                            min="1"
                            class="mt-1 block w-full"
                            value="{{ old('phone', $peserta->phone) }}"
                        />
                        <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="address" value="Alamat" />
                        <x-text-input
                            id="address"
                            name="address"
                            type="text"
                            class="mt-1 block w-full"
                            value="{{ old('address', $peserta->address) }}"
                            required
                        />
                        <x-input-error :messages="$errors->get('address')" class="mt-1" />
                    </div>

                    <div class="flex justify-end space-x-4 mt-4">
                        <a href="{{ route('admin.participants.index') }}" class="px-4 py-2 bg-gray-100 rounded text-sm">
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
