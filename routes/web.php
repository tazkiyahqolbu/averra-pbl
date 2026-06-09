<?php

use Illuminate\Support\Facades\Route;
// Arahkan ke Controller utama Anda
use App\Http\Controllers\Controller;

// Jalankan method index yang ada di Controller
Route::get('/', [Controller::class, 'index'])->name('home');