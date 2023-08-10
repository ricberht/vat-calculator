<?php

namespace App\Http\Controllers;

use App\Models\VatCalculator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class Vat extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $vatCalculator = VatCalculator::all();
        return view('welcome')
            ->with(compact('vatCalculator'));
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function store(Request $request): string
    {
        $data = $request->validate([
            'value' => 'required|numeric|min:0',
            'percentage' => 'required|numeric|min:0',
            'included' => 'required|numeric'
        ]);
        $vatCalculator = VatCalculator::create($data);
        return response()->json($vatCalculator);
    }
}
