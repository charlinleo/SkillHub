<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Peserta
            </h2>
            <a href="{{ route('admin.participants.create') }}" class="btn btn-outline-primary">
                Tambah Peserta
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white sm:rounded-lg overflow-hidden">
                <table class="table table-bordered">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Nama</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Telepon</th>
                            <th class="px-4 py-2 text-left">Alamat</th>
                            <th class="px-4 py-2 text-left">Kelas & Status</th>
                            <th class="px-4 py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peserta as $p)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $p->name }}</td>
                                <td class="px-4 py-2">{{ $p->email }}</td>
                                <td class="px-4 py-2">{{ $p->phone ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $p->address ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    @if ($p->enrollments->count() > 0)
                                        <ul class="list-unstyled mb-0 space-y-1">
                                            @foreach ($p->enrollments as $enrollment)
                                                <li class="mb-1">
                                                    <div class="text-sm font-semibold">
                                                        {{ $enrollment->skillClass->name ?? '-' }}
                                                    </div>

                                                    <form
                                                        action="{{ route('admin.enrollments.updateStatus', $enrollment) }}"
                                                        method="POST"
                                                        class="d-inline-flex align-items-center gap-2 mt-1">
                                                        @csrf
                                                        @method('PATCH')

                                                        <select name="status"
                                                            class="form-select form-select-sm w-auto">
                                                            <option value="pending" @selected($enrollment->status === 'pending')>Pending
                                                            </option>
                                                            <option value="active" @selected($enrollment->status === 'active')>Active
                                                            </option>
                                                            <option value="denied" @selected($enrollment->status === 'denied')>Denied
                                                            </option>
                                                        </select>

                                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                                            Simpan
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-sm text-gray-500">Belum ikut kelas apa pun.</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-right space-x-2">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.participants.edit', $p) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.participants.destroy', $p) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kelas ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                    Tidak ada peserta.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $peserta->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
