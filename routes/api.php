<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockEntryController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CustomerController;

// Rutas públicas para autenticación
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);
Route::post('/reset-password', [NewPasswordController::class, 'store']);
Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store']);
Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1']);

// Rutas protegidas con autenticación
Route::middleware('auth:sanctum')->group(function () {
    // Categorías
    Route::apiResource('categories', CategoryController::class);

    // Proveedores
    Route::apiResource('suppliers', SupplierController::class);

    // Productos
    Route::apiResource('products', ProductController::class);

    // Entradas de stock
    Route::apiResource('stock-entries', StockEntryController::class);

    // Ventas
    Route::apiResource('sales', SaleController::class);

    // Gastos
    Route::get('/expenses/search-products', [ExpenseController::class, 'searchProducts']); // Búsqueda de productos para gastos
    Route::apiResource('expenses', ExpenseController::class);

    // Clientes
    Route::apiResource('customers', CustomerController::class);
});
