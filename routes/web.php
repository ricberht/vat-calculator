<?php

use App\Http\Controllers\Clear;
use App\Http\Controllers\Vat;
use App\Models\VatCalculator;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [Vat::class, 'index']);
Route::resource('vat', Vat::class);
Route::resource('clear', Clear::class);
Route::get('download', function () {
    $list = VatCalculator::all()->toArray();
    $csvHeaders = ["Entity ID", "Value", "Percentage", "VAT Included", "Created At Date", "Updated At Date"];
    array_unshift($list, $csvHeaders);

    return response()->stream(function () use ($list) {
        $writer = fopen('php://output', 'w');
        foreach ($list as $row) {
            fputcsv($writer, $row);
        }
        fclose($writer);
    }, 200, ['Content-Type' => 'text/csv']);
});
