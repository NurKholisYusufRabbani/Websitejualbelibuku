@extends('admin.layout')

@section('title', 'Kelola Pengguna')

@section('content')
    <div class="bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-white mb-4">👥 Daftar Pengguna</h1>

        <!-- Tabel User -->
        <div class="overflow-x-auto mt-4">
            <table class="w-full border-collapse border border-gray-700">
                <thead class="bg-gray-700">
                    <tr class="text-left text-gray-300 uppercase text-sm">
                        <th class="p-3 border border-gray-600">ID</th>
                        <th class="p-3 border border-gray-600">Nama</th>
                        <th class="p-3 border border-gray-600">Email</th>
                        <th class="p-3 border border-gray-600">Saldo</th>
                        <th class="p-3 border border-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-t border-gray-700 hover:bg-gray-700/50">
                            <td class="p-3 border border-gray-600 text-gray-300">{{ $user->id }}</td>
                            <td class="p-3 border border-gray-600 text-gray-300">{{ $user->nama }}</td>
                            <td class="p-3 border border-gray-600 text-gray-300">{{ $user->email }}</td>
                            <td class="p-3 border border-gray-600 text-green-400 font-semibold">Rp{{ number_format($user->saldo, 0, ',', '.') }}</td>
                            <td class="p-3 border border-gray-600 text-center">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Yakin ingin menghapus pengguna ini?')" 
                                            class="px-3 py-1 bg-red-600 text-gray-200 rounded hover:bg-red-700 transition">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
