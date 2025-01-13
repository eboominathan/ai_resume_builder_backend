<?php

namespace App\Http\Controllers;

use App\Models\CustomerDetails;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        return CustomerDetails::all();
    }

    public function store(Request $request)
{
    // Validate the incoming request
    $validated = $request->validate([
        'customerId' => 'required',
        'title' => 'required|string|max:255',
        'userName' => 'required|string|max:255',
        'userEmail' => 'required|email|max:255',
    ]);

    // Split the userName into first and last names
    $name = explode(' ', $validated['userName'], 2);

    // Prepare the data for insertion
    $data = [
        'customer_id' => $validated['customerId'], // Assuming 'customer_id' matches the DB column
        'title' => $validated['title'],
        'email' => $validated['userEmail'],
        'first_name' => $name[0], // Use first part as 'first_name'
        'last_name' => $name[1] ?? '', // Handle cases where last_name is missing
    ];

    // Create the customer record
    $customer = CustomerDetails::create($data);

    // Return a JSON response with the created customer, and a 201 status
    return response()->json($customer, 201);
}


    public function show($id)
    {
        return CustomerDetails::with(['family'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
      
        $customers = CustomerDetails::findOrFail($id);
        $customers->update($request->all());        
        return response()->json($customers->load([]), 200);
    }

    public function destroy($id)
    {
        $customers = CustomerDetails::findOrFail($id);
        $customers->delete();
        return response()->json(null, 204);
    }
}
