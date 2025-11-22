<x-app-layout>
    @php
        $enrolledClassIds = $enrolledClassIds ?? [];
        $enrollmentStatuses = $enrollmentStatuses ?? [];
    @endphp
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Kelas SkillHub
            </h2>
            @auth
                <div class="flex items-center gap-3">
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.classes.create') }}" class="btn btn-outline-primary">
                            + Tambah Kelas
                        </a>
                    @endif
                </div>
            @endauth
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white sm:rounded-lg overflow-hidden">
                <table class="table table-bordered">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Nama Kelas</th>
                            <th class="px-4 py-2 text-left">Instruktur</th>
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-left">Waktu</th>
                            <th class="px-4 py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($classes as $class)
                            <tr class="border-t">
                                <td class="px-4 py-2">
                                    {{ $class->name }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $class->instructor_name }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $class->start_date }} s/d {{ $class->end_date }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $class->start_time }} s/d {{ $class->end_time }} per hari
                                </td>
                                <td class="px-4 py-2 text-right">
                                    @guest

                                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">
                                            Login untuk daftar
                                        </a>
                                    @else
                                        @if (auth()->user()->isAdmin())
                                            {{-- ADMIN: Detail, Edit, Hapus --}}
                                            <div class="d-inline-flex gap-2">
                                                <a href="{{ route('classes.show', $class) }}"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    Detail
                                                </a>

                                                <a href="{{ route('admin.classes.edit', $class) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    Edit
                                                </a>

                                                <form action="{{ route('admin.classes.destroy', $class) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus kelas ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif (auth()->user()->isPeserta())
                                            <a href="{{ route('classes.show', $class) }}"
                                                class="inline-flex items-center px-3 py-1 bg-gray-100 rounded text-gray-700 text-xs hover:bg-gray-200 mb-2">
                                                Detail
                                            </a>
                                            @php
                                                $status = $enrollmentStatuses[$class->id] ?? null;
                                            @endphp
                                            @if ($status)
                                                {{-- Sudah daftar: tampilkan teks status --}}
                                                <span
                                                    class="inline-flex items-center px-3 py-1 bg-gray-100 rounded text-gray-700 text-xs hover:bg-gray-200 mb-2">
                                                    Sudah mendaftar (Status: {{ ucfirst($status) }})
                                                </span>
                                            @else
                                                {{-- Belum daftar: tampilkan tombol --}}
                                                <form action="{{ route('classes.enroll', $class) }}" method="POST"
                                                    class="mt-4">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1 bg-gray-100 rounded text-gray-700 text-xs hover:bg-gray-200 mb-2">
                                                        Ikut Kelas
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    @endguest
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                    Belum ada kelas yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $classes->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
