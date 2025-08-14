<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AuditLogsController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
Route::get('/audit-logs', [AuditLogsController::class, 'index'])->name('audit-logs');
