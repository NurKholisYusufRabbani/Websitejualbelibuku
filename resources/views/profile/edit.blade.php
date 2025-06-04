@extends('layouts.app')

@section('content')

    <!-- Foto Profil (Tengah di Atas) -->
    <div class="flex flex-col items-center mb-6 mt-10 px-4">
        <div class="relative">
            <img src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : asset('storage/profile_pictures/default-profile.png') }}"
                 alt="Foto Profil {{ auth()->user()->nama }}"
                 class="w-40 h-40 sm:w-48 sm:h-48 rounded-full border-4 border-gray-200 dark:border-gray-600 shadow-lg object-cover">

            <!-- Tombol Upload Foto -->
            <form method="POST" action="{{ route('profile.upload_photo') }}" enctype="multipart/form-data" class="absolute bottom-2 right-2">
                @csrf
                @method('PATCH')
                <label class="cursor-pointer bg-indigo-600 text-white p-2 rounded-full text-xs sm:text-sm hover:bg-indigo-700 shadow-md transition duration-150 ease-in-out" title="Ubah Foto Profil">
                    <i class="fas fa-camera"></i>
                    <input type="file" name="profile_photo" class="hidden" onchange="this.form.submit()" accept="image/png, image/jpeg, image/jpg">
                </label>
            </form>
        </div>

        <!-- Tombol Keranjang, Pesanan-->
        {{-- Penyesuaian grid untuk 2 tombol --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 justify-center mt-8 gap-4 w-full max-w-lg">
            <!-- Keranjang -->
            <a href="{{ route('cart.index') }}" class="flex items-center justify-center w-full px-4 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition">
                <i class="fas fa-shopping-cart mr-2"></i> Keranjang
            </a>

            <!-- Pesanan Saya -->
            <a href="{{ route('orders.index') }}" class="flex items-center justify-center w-full px-4 py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition">
                <i class="fas fa-box mr-2"></i> Pesanan Saya
            </a>
        </div>
    </div>

    <!-- Profil Header (Jika Anda menggunakan komponen layout dengan slot 'header') -->
    {{-- <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                Profil Pengguna
            </h2>
        </div>
    </x-slot> --}}

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Informasi Akun -->
            <div class="bg-white dark:bg-gray-800 p-6 shadow-md rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4 border-b pb-3 dark:border-gray-700">Informasi Akun</h3>
                {{-- Form di sini tidak melakukan submit, hanya untuk tampilan data --}}
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                        <p class="mt-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            {{ auth()->user()->nama ?? 'Tidak tersedia' }}
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <p class="mt-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            {{ auth()->user()->email ?? 'Tidak tersedia' }}
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Saldo</label>
                        <p class="mt-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            Rp {{ number_format(auth()->user()->saldo ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Ubah Password -->
            <div class="bg-white dark:bg-gray-800 p-6 shadow-md rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4 border-b pb-3 dark:border-gray-700">Ubah Password</h3>
                @if(View::exists('profile.partials.update-password-form'))
                    @include('profile.partials.update-password-form')
                @else
                    <p class="text-red-500 dark:text-red-400">⚠️ Form untuk mengubah password tidak ditemukan. Pastikan file `profile.partials.update-password-form` ada.</p>
                @endif
            </div>

            <!-- Hapus Akun -->
            <div class="bg-white dark:bg-gray-800 p-6 shadow-md rounded-lg">
                <h3 class="text-lg font-semibold text-red-600 dark:text-red-400 mb-4 border-b pb-3 dark:border-gray-700">Hapus Akun</h3>
                @if(View::exists('profile.partials.delete-user-form'))
                    @include('profile.partials.delete-user-form')
                @else
                    <p class="text-red-500 dark:text-red-400">⚠️ Form untuk menghapus akun tidak ditemukan. Pastikan file `profile.partials.delete-user-form` ada.</p>
                @endif
            </div>

        </div>
    </div>

@endsection
