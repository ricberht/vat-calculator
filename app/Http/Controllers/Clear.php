<?php

namespace App\Http\Controllers;

use App\Models\VatCalculator;

class Clear extends Controller
{
    /**
     * Truncate table
     */
    public function index()
    {
        VatCalculator::truncate();
    }
}
