<?php

namespace App\Http\Controllers;

use App\Models\FamilyDetails;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FamilyController extends Controller
{
    public function index()
    {
        return FamilyDetails::all();
    }

    public function store(Request $request)
{
    // Validate the incoming request
    $validated = $request->validate([
        'familyId' => 'required',
        'title' => 'required|string|max:255',
        'userName' => 'required|string|max:255',
        'userEmail' => 'required|email|max:255',
    ]);

    // Split the userName into first and last names
    $name = explode(' ', $validated['userName'], 2);

    // Prepare the data for insertion
    $data = [        
        'title' => $validated['title'],
        'email' => $validated['userEmail'],
        'first_name' => $name[0], // Use first part as 'first_name'
        'last_name' => $name[1] ?? '', // Handle cases where last_name is missing
    ];

    // Create the family record
    $family = FamilyDetails::create($data);

    // Return a JSON response with the created family, and a 201 status
    return response()->json($family, 201);
}


    public function show($id)
    {
        return FamilyDetails::with([])->findOrFail($id);
    }

    public function update(Request $request, $id)
{
    // Retrieve the family details from the request
    $familyData = $request->familyMembers; // Assuming the key in your JSON request is 'familyMembers'
    
    if (empty($familyData) || !is_array($familyData)) {
        return response()->json(['message' => 'Invalid family data'], 400);
    }

    // Fetch existing family members for the customer
    $existingFamilyMembers = FamilyDetails::where('customer_id', $id)->get();

    // Create a collection of family members from the request for comparison
    $incomingFamilyIds = collect($familyData)->pluck('id')->filter()->all(); // Collect existing IDs from incoming data

    // Delete family members that are not included in the request
    FamilyDetails::where('customer_id', $id)
        ->whereNotIn('id', $incomingFamilyIds)
        ->delete();

    // Loop through the family members in the request
    foreach ($familyData as $familyMember) {
        // Validate required fields for each family member
        $validator = Validator::make($familyMember, [
            'id' => 'nullable|integer', // If ID exists, it should be an integer
            'first_name' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'phone' => 'nullable|string',
            'relationship' => 'nullable|string',
            'photo' => 'nullable|string', // Base64 string validation
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 400);
        }

        // Handle Base64 photo upload
        if (isset($familyMember['photo']) && str_starts_with($familyMember['photo'], 'data:image')) {
            // Decode the Base64 image
            $photo = $familyMember['photo'];
            preg_match('/data:image\/(\w+);base64,/', $photo, $matches); // Extract the file extension
            $extension = $matches[1] ?? 'jpg'; // Default to jpg if extension not found
            $photo = str_replace("data:image/{$extension};base64,", '', $photo);
            $photo = str_replace(' ', '+', $photo);

            $decodedPhoto = base64_decode($photo);

            if ($decodedPhoto === false) {
                return response()->json(['message' => 'Invalid Base64 image data'], 400);
            }

            // Save the image to the family_photos folder
            $fileName = uniqid() . '.' . $extension;
            $filePath = "family_photos/{$fileName}";
            Storage::disk('public')->put($filePath, $decodedPhoto);

            $familyMember['photo'] = $filePath; // Save the file path
        }

        if (isset($familyMember['id'])) {
            // Check if the family member already exists and update
            $existingFamily = FamilyDetails::where('id', $familyMember['id'])->where('customer_id', $id)->first();

            if ($existingFamily) {
                $existingFamily->update(array_merge($familyMember, ['customer_id' => $id]));
            }
        } else {
            // Create a new family member record
            FamilyDetails::create(array_merge($familyMember, ['customer_id' => $id]));
        }
    }

    return response()->json(['message' => 'Family details updated successfully'], 200);
}



    public function destroy($id)
    {
        $familys = FamilyDetails::findOrFail($id);
        $familys->delete();
        return response()->json(null, 204);
    }
}
