<?php

namespace App\Http\Controllers;

use App\Models\CustomerDetails;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
   // Backend code update with pagination
public function index(Request $request)
{
    $perPage = $request->input('per_page', 10); // Default to 10 items per page
    $page = $request->input('page', 1);

    $customers = CustomerDetails::paginate($perPage, ['*'], 'page', $page);

    if ($customers->isNotEmpty()) {
        foreach ($customers as $customer) {
            $customer->photo = asset('storage/profile.svg');
            if (!empty($customer->family)) {
                foreach ($customer->family as $familyMember) {
                    if ($familyMember->relationship === 'Family Head') {
                        $customer->photo = $familyMember->photo;
                        break;
                    }
                }
            }
        }
    }

    return $customers; // Returns a paginated response
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
    $perPage = $request->input('per_page', 10); // Default to 10 items per page
    $page = $request->input('page', 1);
    $query = trim($request->input('query', '')); // Trim whitespace and set default to empty string

    // If no query is provided, return paginated empty data
    if (empty($query)) {
        return response()->json([
            'data' => [],
            'current_page' => $page,
            'last_page' => 0,
            'total' => 0
        ], 200);
    }

    // Perform the search with case-insensitive matching on multiple fields
    $customers = CustomerDetails::where('first_name', 'LIKE', '%' . $query . '%')
        ->orWhere('last_name', 'LIKE', '%' . $query . '%')
        ->orWhere('email', 'LIKE', '%' . $query . '%')
        ->orWhere('phone', 'LIKE', '%' . $query . '%')
        ->orWhere('street', 'LIKE', '%' . $query . '%')
        ->orWhere('village', 'LIKE', '%' . $query . '%')
        ->orWhere('district', 'LIKE', '%' . $query . '%')
        ->orWhere('state', 'LIKE', '%' . $query . '%')
        ->paginate($perPage, ['*'], 'page', $page);

    // Add photo for each customer
    $customers->getCollection()->transform(function ($customer) {
        $customer->photo = asset('storage/profile.svg'); // Default photo

        // Check if the customer has a family and find the "Family Head"
        if (!empty($customer->family)) {
            foreach ($customer->family as $familyMember) {
                if ($familyMember->relationship === 'Family Head') {
                    $customer->photo = $familyMember->photo; // Use Family Head's photo
                    break; // Exit loop as Family Head is found
                }
            }
        }

        return $customer;
    });

    // Return the paginated result
    return response()->json($customers, 200);
}


}
