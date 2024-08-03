<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResumeController extends Controller
{
    public function index()
    {
        return Resume::with(['experiences', 'educations', 'skills'])->get();
    }

    public function store(Request $request)
    {
        $name = explode(' ',$request->userName);
            $data = [
            'resumeId' => $request->resumeId, 
            'title' => $request->title,
            'email' => $request->userEmail,
            'first_name' =>  $name[0],
            'last_name' =>  $name[1],
            ]; 

        $resume = Resume::create($data);
        if(!empty($request->experiences)){
            $resume->experiences()->createMany($request->experiences);
        }
        if(!empty($request->educations)){
            $resume->educations()->createMany($request->educations);
        }
        if(!empty($request->skills)){
            $resume->skills()->createMany($request->skills);
        }     
        return response()->json($resume->load(['experiences', 'educations', 'skills']), 201);
    }

    public function show($id)
    {
        return Resume::with(['experiences', 'educations', 'skills'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
      
        $resume = Resume::findOrFail($id);
        $resume->update($request->all());
       
        // Update or create experiences, educations, skills
        if(!empty($request->experiences)){
        $resume->experiences()->delete();
        $resume->experiences()->createMany($request->experiences);
        }
        if(!empty($request->educations)){
            $resume->educations()->delete();
            $resume->educations()->createMany($request->educations);
        }
        if(!empty($request->skills)){
            $resume->skills()->delete();
            $resume->skills()->createMany($request->skills);
        }
        
        
        return response()->json($resume->load(['experiences', 'educations', 'skills']), 200);
    }

    public function destroy($id)
    {
        $resume = Resume::findOrFail($id);
        $resume->delete();
        return response()->json(null, 204);
    }
}
