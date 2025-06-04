@extends('layouts.app') {{-- Ganti dengan layout utama aplikasi Anda untuk sisi pengguna --}}

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 md:p-8">
        {{-- Bagian Header Pesanan --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white">
                    Detail Pesanan <span class="text-indigo-600 dark:text-indigo-400">#{{ $order->id }}</span>
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Tanggal Pesan: {{ $order->created_at->format('d M Y, H:i') }}
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full
                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100
                    @elseif($order->status == 'completed') bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100
                    @elseif($order->status == 'paid') bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100
                    @elseif($order->status == 'shipped') bg-purple-100 text-purple-800 dark:bg-purple-700 dark:text-purple-100
                    @elseif($order->status == 'delivered') bg-teal-100 text-teal-800 dark:bg-teal-700 dark:text-teal-100
                    @elseif($order->status == 'cancelled') bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100
                    @else bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100
                    @endif">
                    Status Pesanan: {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        {{-- Notifikasi Sukses (jika ada dari redirect checkout) --}}
        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Detail Alamat dan Status Pengiriman --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-3">Alamat Pengiriman</h2>
                <div class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    <p class="font-medium">{{ $order->user->nama ?? 'Nama Pengguna' }}</p>
                    <p>{{ $order->alamat_pengiriman }}</p>
                    {{-- Tambahkan detail alamat lain jika ada, seperti nomor telepon, kota, dll. --}}
                </div>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-3">Status Pengiriman</h2>
                @if($order->shippingStatus) {{-- Cek apakah ada data status pengiriman --}}
                    <div class="text-gray-600 dark:text-gray-400">
                        <p class="mb-1">
                            <span class="font-semibold">Status:</span>
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($order->shippingStatus->status == 'processing') bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100
                                @elseif($order->shippingStatus->status == 'shipped') bg-purple-100 text-purple-800 dark:bg-purple-700 dark:text-purple-100
                                @elseif($order->shippingStatus->status == 'delivered') bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100
                                @elseif($order->shippingStatus->status == 'returned') bg-orange-100 text-orange-800 dark:bg-orange-700 dark:text-orange-100
                                @elseif($order->shippingStatus->status == 'cancelled') bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100
                                @else bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $order->shippingStatus->status)) }}
                            </span>
                        </p>
                        @if($order->shippingStatus->tracking_number)
                            <p class="mt-1"><span class="font-semibold">No. Resi:</span> {{ $order->shippingStatus->tracking_number }}</p>
                        @endif
                        @if($order->shippingStatus->keterangan)
                             <p class="mt-1 text-sm italic">Keterangan: {{ $order->shippingStatus->keterangan }}</p>
                        @endif
                        <p class="mt-1 text-xs">Update Terakhir: {{ $order->shippingStatus->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">Status pengiriman belum tersedia atau sedang diproses.</p>
                @endif
            </div>
        </div>

        {{-- Daftar Item Pesanan --}}
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-3">Item Pesanan</h2>
        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produk</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga Satuan</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-gray-700 dark:text-gray-200">
                    @forelse($order->orderItems as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($item->book && $item->book->cover_image)
                                    <div class="flex-shrink-0 h-12 w-12">
                                        {{-- Pastikan path ke gambar benar dan storage sudah di-link --}}
                                        <img class="h-12 w-12 rounded-md object-cover" src="{{ asset('storage/images/' . $item->book->cover_image) }}" alt="{{ $item->book->judul ?? 'Gambar Buku' }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="flex-shrink-0 h-12 w-12 bg-gray-200 dark:bg-gray-600 rounded-md items-center justify-center text-gray-400 dark:text-gray-500" style="display:none;">?</div>
                                    </div>
                                @else
                                     <div class="flex-shrink-0 h-12 w-12 bg-gray-200 dark:bg-gray-600 rounded-md flex items-center justify-center">
                                        <svg class="h-6 w-6 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-medium">{{ $item->book->judul ?? 'Produk Telah Dihapus' }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $item->book->penulis ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $item->jumlah }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right">Rp{{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">
                            Tidak ada item dalam pesanan ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Rincian Total Pembayaran --}}
        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex justify-end">
                <div class="w-full md:w-1/3 space-y-1">
                    @php
                        $totalSebelumDiskon = 0;
                        if ($order->orderItems->isNotEmpty()) {
                            $totalSebelumDiskon = $order->orderItems->sum(function($item) { return $item->harga * $item->jumlah; });
                        }
                    @endphp
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300">
                        <span>Subtotal Item:</span>
                        <span>Rp{{ number_format($totalSebelumDiskon, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between text-lg font-semibold text-gray-800 dark:text-white pt-2 border-t border-gray-200 dark:border-gray-600 mt-2">
                        <span>Total Pembayaran:</span>
                        <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-8 text-center md:text-left">
            <a href="{{ route('orders.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200 font-medium inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Pesanan
            </a>
            {{-- Anda bisa menambahkan tombol lain di sini, misalnya "Bayar Sekarang" jika statusnya pending dan ada integrasi pembayaran --}}
        </div>
    </div>
</div>
@endsection