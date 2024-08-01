<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function index()
    {
        return Resume::with(['experiences', 'educations', 'skills'])->get();
    }

    public function store(Request $request)
    {
        $resume = Resume::create($request->all());
        $resume->experiences()->createMany($request->experiences);
        $resume->educations()->createMany($request->educations);
        $resume->skills()->createMany($request->skills);
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
        $resume->experiences()->delete();
        $resume->educations()->delete();
        $resume->skills()->delete();
        
        $resume->experiences()->createMany($request->experiences);
        $resume->educations()->createMany($request->educations);
        $resume->skills()->createMany($request->skills);
        
        return response()->json($resume->load(['experiences', 'educations', 'skills']), 200);
    }

    public function destroy($id)
    {
        $resume = Resume::findOrFail($id);
        $resume->delete();
        return response()->json(null, 204);
    }
}
