<?php

use App\Http\Controllers\detailItemsCintroller;
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

Route::get('/inventory/detailitems/{id}', [detailItemsCintroller::class, 'show'])->name('inventory.detailitems');
Route::put('/inventory/{id}/quantity', [InventoryController::class, 'updateQuantity'])->name('inventory.updateQuantity');

// HANYA yang ini untuk Use Items
Route::post('items/{item}/use', [detailItemsCintroller::class, 'processUse'])->name('items.use.process');

// Update/Delete JSON
Route::put('items/{item}/update-json', [detailItemsCintroller::class, 'updateJson'])->name('items.updateJson');
