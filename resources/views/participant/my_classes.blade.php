<x-app-layout>
    <x-slot name="header">
         <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kelas yang Anda Ikuti
            </h2>

            <a href="{{ route('classes.index') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                Ikut Kelas
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

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="table table-bordered">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Nama Kelas</th>
                            <th class="px-4 py-2 text-left">Instruktur</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enrollments as $enrollment)
                            <tr class="border-t">
                                <td class="px-4 py-2">
                                    {{ $enrollment->skillClass->name }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $enrollment->skillClass->instructor_name }}
                                </td>
                                <td class="px-4 py-2">
                                    @if($enrollment->status === 'pending')
                                        <span class="inline-flex px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif($enrollment->status === 'active')
                                        <span class="inline-flex px-2 py-1 rounded text-xs bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 rounded text-xs bg-red-100 text-red-800">
                                            Denied
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-right">
                                    <form action="{{ route('participant.enrollments.destroy', $enrollment) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin batalkan pendaftaran?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                            Batalkan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                    Anda belum terdaftar di kelas mana pun.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
