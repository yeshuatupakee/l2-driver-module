<?php

use Illuminate\Support\Facades\Route;

// Main Pages
Route::view('/', 'login')->name('login');
Route::view('/dashboard', 'dashboard')->name('dashboard');

// Live Tracking
Route::view('/live-tracking', 'live-tracking')->name('live-tracking');

// Trip Assignment
Route::view('/trip-assignment', 'trip-assignment')->name('trip-assignment');

// Reports and Checklist
Route::view('/reports-and-checklist', 'reports-and-checklist')->name('reports-and-checklist');