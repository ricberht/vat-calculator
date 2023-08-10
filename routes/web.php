<?php

use App\Http\Controllers\Clear;
use App\Http\Controllers\Vat;
use App\Models\VatCalculator;
use Illuminate\Support\Facades\Route;

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
