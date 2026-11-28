<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/safaris', [SiteController::class, 'safaris'])->name('safaris');
Route::get('/safaris/{slug}', [SiteController::class, 'safari'])->name('safari');
Route::get('/diary', [SiteController::class, 'diary'])->name('diary');
Route::get('/plan', [SiteController::class, 'plan'])->name('plan');
Route::post('/plan', [SiteController::class, 'storePlan'])->name('plan.store');
Route::get('/plan/confirmation/{ref}', [SiteController::class, 'planConfirmation'])->name('plan.confirmation');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::post('/contact', [SiteController::class, 'storeMessage'])->name('contact.store');
Route::get('/book', [SiteController::class, 'book'])->name('book');
Route::post('/book', [SiteController::class, 'storeBooking'])->name('book.store');
Route::get('/book/confirmation/{ref}', [SiteController::class, 'confirmation'])->name('confirmation');
Route::get('/admin', [SiteController::class, 'admin'])->name('admin');
Route::post('/admin/login', [SiteController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [SiteController::class, 'logout'])->name('admin.logout');

Route::redirect('/tours', '/safaris');
Route::get('/tours/{slug}', fn (string $slug) => redirect('/safaris/'.$slug));
Route::redirect('/about', '/');
