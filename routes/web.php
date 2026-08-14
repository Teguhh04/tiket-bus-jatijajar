<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Routes
Route::get('/', [TicketController::class, 'index'])->name('home');
Route::get('/tiket', [TicketController::class, 'search'])->name('ticket.search');
Route::get('/tiket/{id}/kursi', [TicketController::class, 'selectSeat'])->name('ticket.select_seat');
Route::get('/tiket/{id}/detail', [TicketController::class, 'show'])->name('ticket.detail');
Route::get('/bantuan', [TicketController::class, 'bantuan'])->name('page.bantuan');
Route::get('/cek-tiket', [TicketController::class, 'showCheckStatusForm'])->name('ticket.check_status_form');
Route::post('/cek-tiket', [TicketController::class, 'checkStatus'])->name('ticket.check_status');

// Booking Flow (Now Public for Guest Checkout)
Route::get('/tiket/{id}/pesan', [TicketController::class, 'book'])->name('ticket.book');
Route::post('/tiket/{id}/pesan', [TicketController::class, 'storeBooking'])->name('ticket.store');
Route::get('/pembayaran/{booking_id}', [TicketController::class, 'payment'])->name('ticket.payment');
Route::post('/pembayaran/{booking_id}/konfirmasi', [TicketController::class, 'confirmPayment'])->name('ticket.confirm_payment');
Route::get('/pembayaran/{booking_id}/instruksi', [TicketController::class, 'instructions'])->name('ticket.instructions');
Route::post('/pembayaran/{booking_id}/proses', [TicketController::class, 'processPayment'])->name('ticket.process_payment');
Route::get('/e-ticket/{ticket_code}', [TicketController::class, 'success'])->name('ticket.success');
Route::get('/e-ticket/{ticket_code}/print', [TicketController::class, 'printTicket'])->name('ticket.print');

// Protected Routes (Login Required)
Route::middleware('auth')->group(function () {
    Route::get('/akun', [TicketController::class, 'akun'])->name('page.akun');
});

// Admin Panel Routes
use App\Http\Controllers\AdminController;
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/pesanan', [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/laporan', [AdminController::class, 'reports'])->name('reports');
    Route::get('/laporan/export', [AdminController::class, 'exportReports'])->name('reports.export');
    Route::get('/pendapatan-po', [AdminController::class, 'poRevenue'])->name('po_revenue');
    Route::get('/pesanan/edit/{id}', [AdminController::class, 'editBooking'])->name('bookings.edit');
    Route::post('/pesanan/update/{id}', [AdminController::class, 'updateBooking'])->name('bookings.update');
    Route::post('/pesanan/hapus/{id}', [AdminController::class, 'destroyBooking'])->name('bookings.destroy');

    Route::get('/jadwal', [AdminController::class, 'trips'])->name('trips');
    Route::get('/jadwal/tambah', [AdminController::class, 'createTrip'])->name('trips.create');
    Route::post('/jadwal/generate', [AdminController::class, 'generateTrips'])->name('trips.generate');
    Route::post('/jadwal', [AdminController::class, 'storeTrip'])->name('trips.store');
    Route::get('/jadwal/edit/{id}', [AdminController::class, 'editTrip'])->name('trips.edit');
    Route::post('/jadwal/update/{id}', [AdminController::class, 'updateTrip'])->name('trips.update');
    Route::post('/jadwal/hapus/{id}', [AdminController::class, 'destroyTrip'])->name('trips.destroy');
    Route::get('/operator', [AdminController::class, 'operators'])->name('operators');
    Route::get('/operator/tambah', [AdminController::class, 'createOperator'])->name('operators.create');
    Route::post('/operator', [AdminController::class, 'storeOperator'])->name('operators.store');
    Route::get('/operator/edit/{id}', [AdminController::class, 'editOperator'])->name('operators.edit');
    Route::post('/operator/update/{id}', [AdminController::class, 'updateOperator'])->name('operators.update');
    Route::post('/operator/hapus/{id}', [AdminController::class, 'destroyOperator'])->name('operators.destroy');

    Route::get('/terminal', [AdminController::class, 'terminals'])->name('terminals');
    Route::get('/terminal/tambah', [AdminController::class, 'createTerminal'])->name('terminals.create');
    Route::post('/terminal', [AdminController::class, 'storeTerminal'])->name('terminals.store');
    Route::get('/terminal/edit/{id}', [AdminController::class, 'editTerminal'])->name('terminals.edit');
    Route::post('/terminal/update/{id}', [AdminController::class, 'updateTerminal'])->name('terminals.update');
    Route::post('/terminal/hapus/{id}', [AdminController::class, 'destroyTerminal'])->name('terminals.destroy');
});
