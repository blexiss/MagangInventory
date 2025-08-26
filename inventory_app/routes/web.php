<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuditLogsController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
Route::get('/audit-logs', [AuditLogsController::class, 'index'])->name('audit-logs');

Route::put('/inventory/{id}/update', [InventoryController::class, 'update'])->name('inventory.update');
Route::delete('/inventory/{id}/delete', [InventoryController::class, 'destroy'])->name('inventory.destroy');


