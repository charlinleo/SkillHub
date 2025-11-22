<x-app-layout>
    @php
        $activeEnrollments = $class->enrollments->where('status', 'active');
        $rows = auth()->check() && auth()->user()->isAdmin() ? $class->enrollments : $activeEnrollments;
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Kelas: {{ $class->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-">
                <div>
                    <h3 class="text-lg font-semibold mb-2">{{ $class->name }}</h3>
                    <p class="text-sm text-gray-600">
                        Instruktur: <span class="font-medium">{{ $class->instructor_name }}</span>
                    </p>
                </div>

                @if ($class->description)
                    <div>
                        <h4 class="text-sm font-semibold mb-2">Deskripsi</h4>
                        <p class="text-sm text-gray-700">
                            {{ $class->description }}
                        </p>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-semibold">Tanggal Mulai:</span>
                        <div>{{ $class->start_date ?? '-' }}</div>
                    </div>
                    <div>
                        <span class="font-semibold">Tanggal Selesai:</span>
                        <div>{{ $class->end_date ?? '-' }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-semibold">Waktu Mulai:</span>
                        <div>{{ $class->start_time ?? '-' }}</div>
                    </div>
                    <div>
                        <span class="font-semibold"> Waktu berakhir:</span>
                        <div>{{ $class->end_time ?? '-' }}</div>
                    </div>
                </div>

                @if ($rows->count() > 0)
                    <div class="mt-6">
                        <h4 class="text-sm font-semibold mb-2">
                            Peserta Terdaftar ({{ $rows->count() }})
                        </h4>

                        <table class="min-w-full text-sm border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-3 py-2 text-left">Nama</th>
                                    <th class="px-3 py-2 text-left">Email</th>
                                    <th class="px-3 py-2 text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $enrollment)
                                    <tr class="border-t">
                                        <td class="px-3 py-2">
                                            {{ $enrollment->peserta->name ?? '-' }}
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ $enrollment->peserta->email ?? '-' }}
                                        </td>
                                        <td class="px-3 py-2">
                                            @auth
                                                @if (auth()->user()->isAdmin())
                                                    {{-- ADMIN bisa ubah status apa saja --}}
                                                    <form
                                                        action="{{ route('admin.enrollments.updateStatus', $enrollment) }}"
                                                        method="POST" class="inline-flex items-center space-x-2">
                                                        @csrf
                                                        @method('PATCH')

                                                        <select name="status" class="border-gray-300 rounded text-xs">
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
                                                @else
                                                    <span
                                                        class="inline-flex px-2 py-1 rounded text-xs bg-green-100 text-green-800">
                                                        {{ ucfirst($enrollment->status) }}
                                                    </span>
                                                @endif
                                            @endauth
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="mt-4 text-sm text-gray-500">
                        Belum ada peserta yang terdaftar di kelas ini.
                    </p>
                @endif

                @auth
                    @if (auth()->user()->isPeserta())
                        @if (!empty($userEnrollment))
                            {{-- User sudah daftar ke kelas ini --}}
                            <div class="mt-4 text-sm">
                                <span
                                    class="inline-flex px-3 py-1 rounded text-xs
                        @if ($userEnrollment->status === 'active') bg-green-100 text-green-800
                        @elseif($userEnrollment->status === 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                                    Sudah mendaftar (Status: {{ ucfirst($userEnrollment->status) }})
                                </span>
                            </div>
                        @else
                            {{-- User belum daftar: tampilkan tombol daftar --}}
                            <form action="{{ route('classes.enroll', $class) }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary">
                                    Daftar Kelas Ini
                                </button>
                            </form>
                        @endif
                    @endif
                @endauth

                @auth
                    @if (auth()->user()->isAdmin())
                        <div class="mt-6 border-t pt-4">
                            <h4 class="text-sm font-semibold mb-2">
                                Tambah Peserta ke Kelas Ini
                            </h4>

                            @if ($availableParticipants->count() === 0)
                                <p class="text-sm text-gray-500">
                                    Semua peserta sudah terdaftar di kelas ini.
                                </p>
                            @else
                                <form action="{{ route('admin.classes.enrollments.store', $class) }}" method="POST"
                                    class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                                    @csrf

                                    <select name="user_id" class="border-gray-300 rounded-md shadow-sm text-sm" required>
                                        <option value="">-- Pilih Peserta --</option>
                                        @foreach ($availableParticipants as $peserta)
                                            <option value="{{ $peserta->id }}">
                                                {{ $peserta->name }} ({{ $peserta->email }})
                                            </option>
                                        @endforeach
                                    </select>

                                    <x-primary-button>
                                        Tambahkan ke Kelas
                                    </x-primary-button>
                                </form>
                            @endif
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>
