<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Storage;

// Redirect ke login page
Route::get('/', function () {
    return view('auth.login'); 
});

// Middleware khusus admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kelola Buku
    Route::resource('/books', AdminBookController::class);
    Route::put('/admin/books/{book}', [BookController::class, 'update'])->name('admin.books.update');

    // Route untuk Upload Cover Buku
    Route::post('/books/upload', function (Illuminate\Http\Request $request) {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/images', $filename);

            return response()->json([
                'status' => 'success',
                'path' => asset('storage/images/' . $filename),
                'filename' => $filename,
            ]);
        }

        return response()->json(['status' => 'error'], 400);
    })->name('books.upload');

    // Kelola Pesanan
    Route::resource('/orders', OrderController::class);

    // Kelola Pengguna
    Route::resource('/users', UserController::class);
});

// Middleware untuk user yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => redirect()->route('books.index'))->name('dashboard');

    // Rute Buku
    Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');

    // Rute Keranjang
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::get('/cart/view', [CartController::class, 'view'])->name('cart.view');
        Route::post('/add/{book}', [CartController::class, 'add'])->name('add');
        Route::post('/update/{cartItem}', [CartController::class, 'update'])->name('update')->where('cartItem', '[0-9]+'); // Pastikan parameter adalah angka
        Route::delete('/remove/{cartItem}', [CartController::class, 'remove'])->name('remove')->where('cartItem', '[0-9]+');
    });    

    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

    // Rute Profil
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::patch('/upload-photo', [ProfileController::class, 'updateProfilePicture'])->name('upload_photo');
    });
});

require __DIR__.'/auth.php';
