<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all services with category and subcategory relationships
        $services = Service::with(['category', 'subCategory'])->get();

        return response()->json($services);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // If needed for web (not used in APIs)
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and store the service
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'payment_status' => 'required|in:paid,pending,partially paid,Not Paid',
            'comments' => 'nullable|string',
        ]);

        $service = Service::create($validated);

        return response()->json($service, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return response()->json($service->load(['category', 'subCategory']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        // If needed for web (not used in APIs)
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        // Validate and update the service
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'payment_status' => 'required|in:paid,pending,partially paid,Not Paid',
            'comments' => 'nullable|string',
        ]);

        $service->update($validated);

        return response()->json($service);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json(['message' => 'Service deleted successfully.']);
    }
}

