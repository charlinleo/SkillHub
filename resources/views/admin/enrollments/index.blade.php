<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Pendaftaran Kelas
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="table table-bordered">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Peserta</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Kelas</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enrollments as $enrollment)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $enrollment->peserta->name }}</td>
                                <td class="px-4 py-2">{{ $enrollment->peserta->email }}</td>
                                <td class="px-4 py-2">{{ $enrollment->skillClass->name }}</td>
                                <td class="px-4 py-2">
                                    <form action="{{ route('admin.enrollments.updateStatus', $enrollment) }}"
                                          method="POST" class="inline-flex items-center space-x-2">
                                        @csrf
                                        @method('PATCH')

                                        <select name="status"
                                                class="border-gray-300 rounded text-xs">
                                            <option value="pending" @selected($enrollment->status === 'pending')>Pending</option>
                                            <option value="active" @selected($enrollment->status === 'active')>Active</option>
                                            <option value="denied" @selected($enrollment->status === 'denied')>Denied</option>
                                        </select>

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-primary">
                                            Simpan
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-2 text-right">
                                    <form action="{{ route('admin.enrollments.destroy', $enrollment) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin hapus pendaftaran ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                    Belum ada pendaftaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $enrollments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
