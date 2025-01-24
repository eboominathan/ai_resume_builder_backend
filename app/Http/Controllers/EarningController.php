<?php

namespace App\Http\Controllers;

use App\Models\Earning;
use Illuminate\Http\Request;

class EarningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all earnings with category and subcategory relationships
        $earnings = Earning::with(['category', 'subCategory'])->get();

        return response()->json($earnings);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // If needed for web (not used in APIs)
        return view('earnings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and store the earning
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',            
            'description' => 'nullable|string',
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'nullable|string',
            'location' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'payment_status' => 'required|in:paid,pending,partially paid,Not Paid',
            'comments' => 'nullable|string',
        ]);

        $earning = Earning::create($validated);

        return response()->json($earning, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Earning $earning)
    {
        return response()->json($earning->load(['category', 'subCategory']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Earning $earning)
    {
        // If needed for web (not used in APIs)
        return view('earnings.edit', compact('earning'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Earning $earning)
    {
        // Validate and update the earning
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'service_id' => 'nullable|exists:services,id',
            'description' => 'nullable|string',
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'nullable|string',
            'location' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'payment_status' => 'required|in:paid,pending,partially paid,Not Paid',
            'comments' => 'nullable|string',
        ]);

        $earning->update($validated);

        return response()->json($earning);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Earning $earning)
    {
        $earning->delete();

        return response()->json(['message' => 'Earning deleted successfully.']);
    }
}

