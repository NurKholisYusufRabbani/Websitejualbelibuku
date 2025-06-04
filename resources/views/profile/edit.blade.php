@extends('layouts.app')

@section('content')

    <!-- Foto Profil (Tengah di Atas) -->
    <div class="flex flex-col items-center mb-6 mt-10">
        <div class="relative">
            <img src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : asset('storage/profile_pictures/default-profile.png') }}" 
                class="w-48 h-48 rounded-full border-4 border-gray-300 shadow-lg">

            <!-- Tombol Upload Foto -->
            <form method="POST" action="{{ route('profile.upload_photo') }}" enctype="multipart/form-data" class="absolute bottom-0 right-0">
                @csrf
                @method('PATCH')
                <label class="cursor-pointer bg-blue-600 text-white px-3 py-1 rounded-full text-sm hover:bg-blue-700">
                    <i class="fas fa-camera"></i>
                    <input type="file" name="profile_photo" class="hidden" onchange="this.form.submit()">
                </label>
            </form>
        </div>

        <!-- Tombol Keranjang, Pesanan, dan Top Up -->
        <div class="grid grid-cols-1 sm:grid-cols-3 justify-center mt-6 gap-4 w-full max-w-md">
            <!-- Keranjang -->
            <a href="{{ route('cart.index') }}" class="flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-shopping-cart mr-2"></i> Keranjang
            </a>

            <!-- Pesanan Saya -->
            <a href="{{ route('orders.index') }}" class="flex items-center justify-center w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-box mr-2"></i> Pesanan Saya
            </a>

            <!-- Top Up (Coming Soon) -->
            <span class="flex items-center justify-center w-full px-4 py-2 bg-gray-500 text-white rounded-lg cursor-not-allowed">
                <i class="fas fa-wallet mr-2"></i> Top Up (Coming Soon)
            </span>
        </div>
    </div>

    <!-- Profil Header -->
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                Profil Pengguna
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Informasi Akun -->
            <div class="bg-white dark:bg-gray-800 p-6 shadow rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white">Informasi Akun</h3>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="mt-4">
                        <label class="block text-gray-700 dark:text-white">Nama</label>
                        <p class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                            {{ auth()->user()->nama ?? '' }}
                        </p>
                    </div>
                    <div class="mt-4">
                        <label class="block text-gray-700 dark:text-white">Email</label>
                        <p class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                            {{ auth()->user()->email ?? '' }}
                        </p>
                    </div>
                    <div class="mt-4">
                        <label class="block text-gray-700 dark:text-white">Saldo</label>
                        <p class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                            Rp {{ number_format(auth()->user()->saldo ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </form>
            </div>

            <!-- Ubah Password -->
            <div class="bg-white dark:bg-gray-800 p-6 shadow rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white">Ubah Password</h3>
                @if(View::exists('profile.partials.update-password-form'))
                    @include('profile.partials.update-password-form')
                @else
                    <p class="text-red-600">⚠️ Form update password tidak ditemukan!</p>
                @endif
            </div>

            <!-- Hapus Akun -->
            <div class="bg-white dark:bg-gray-800 p-6 shadow rounded-lg">
                <h3 class="text-lg font-semibold text-red-600">Hapus Akun</h3>
                @if(View::exists('profile.partials.delete-user-form'))
                    @include('profile.partials.delete-user-form')
                @else
                    <p class="text-red-600">⚠️ Form hapus akun tidak ditemukan!</p>
                @endif
            </div>

        </div>
    </div>

@endsection
