<?php

namespace App\Http\Controllers;
use App\Models\SavCase;
use Illuminate\Http\Request;

class SavCaseController extends Controller
{
    public function index()
    {
        return SavCase::with('vehicle','customer')->latest()->get();
    }

    public function store(Request $request)
    {
        return SavCase::create($request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'customer_id' => 'required|exists:customers,id',
            'type' => 'required',
            'description' => 'required',
            'requires_proforma' => 'boolean'
        ]));
    }

    public function approve(SavCase $savCase)
    {
        $savCase->update([
            'status' => 'approved',
            'approved_by' => auth()->id()
        ]);

        return $savCase;
    }

    public function reject(SavCase $savCase)
    {
        $savCase->update([
            'status' => 'rejected',
            'approved_by' => auth()->id()
        ]);

        return $savCase;
    }
}

