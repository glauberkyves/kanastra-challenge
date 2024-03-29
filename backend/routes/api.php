<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
use App\Http\Controllers\InvoiceController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/invoices/upload", [InvoiceController::class, "store"])->name("api.invoice.upload");
Route::post("/invoices/batch", [InvoiceController::class, "batch"])->name("api.invoice.batch");
Route::get("/invoices", [InvoiceController::class, "list"])->name("api.invoice.list");
