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
        $customers = CustomerDetails::all();
    
        if ($customers->isNotEmpty()) { // Check if the collection is not empty
            foreach ($customers as $customer) {
                $customer->photo = asset('storage/profile.svg');
                if (!empty($customer->family)) { // Check if family exists
                    foreach ($customer->family as $familyMember) {
                        if ($familyMember->relationship === 'Family Head') { // Check relationship
                            $customer->photo = $familyMember->photo; // Set photo for Family Head
                            break; // Exit loop as we found the Family Head
                        }
                    }
                }
            }
        }
    
        return $customers; // Return the modified result
    }

    public function store(Request $request)
{
    // Validate the incoming request
    $validated = $request->validate([
        'customerId' => 'required',
        'title' => 'required|string|max:255'  
    ]);

    // Split the userName into first and last names
    $name = explode(' ', $validated['title'], 2);

    // Prepare the data for insertion
    $data = [
        'customer_id' => $validated['customerId'], // Assuming 'customer_id' matches the DB column
        'title' => $validated['title'],        
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

    public function getStreetNames(Request $request)
    {
        $query = $request->input('query'); // Get the search query from request
        $field = $request->input('field'); // Get the search query from request

        if (!$query) {
            return response()->json([], 200); // Return empty array if no query is provided
        }

        // Fetch matching street names from the database (case-insensitive)
        $streets = CustomerDetails::where($field , 'LIKE', '%' . $query . '%')
            ->limit(10) // Limit to 10 results
            ->pluck($field ); // Get only the 'name' column

        return response()->json($streets, 200); // Return the suggestions as JSON
    }
    public function getCustomer(Request $request)
{
    $query = trim($request->input('query')); // Trim whitespace from the query

    // If no query is provided, return an empty array with a 200 response
    if (empty($query)) {
        return response()->json([], 200);
    }

    // Search customers using various fields with case-insensitive matching
    $customers = CustomerDetails::where('first_name', 'LIKE', '%' . $query . '%')
        ->orWhere('last_name', 'LIKE', '%' . $query . '%')
        ->orWhere('email', 'LIKE', '%' . $query . '%')
        ->orWhere('phone', 'LIKE', '%' . $query . '%')
        ->orWhere('street', 'LIKE', '%' . $query . '%')
        ->orWhere('village', 'LIKE', '%' . $query . '%')
        ->orWhere('district', 'LIKE', '%' . $query . '%')
        ->orWhere('state', 'LIKE', '%' . $query . '%')
        ->limit(10) // Limit results to 10
        ->get();

    // If no customers are found, return an empty array
    if ($customers->isEmpty()) {
        return response()->json([], 200);
    }

    if ($customers->isNotEmpty()) { // Check if the collection is not empty
        foreach ($customers as $customer) {
            $customer->photo = asset('storage/profile.svg');
            if (!empty($customer->family)) { // Check if family exists
                foreach ($customer->family as $familyMember) {
                    if ($familyMember->relationship === 'Family Head') { // Check relationship
                        $customer->photo = $familyMember->photo; // Set photo for Family Head
                        break; // Exit loop as we found the Family Head
                    }
                }
            }
        }
    }

    // Return the matching customers
    return response()->json($customers, 200);
}

}
