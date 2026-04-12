<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index($course_id)
    {
        $course = Course::findOrFail($course_id);
        $materials = $course->materials()->latest()->get();
        $role = auth()->user()->role;

        return view("{$role}.materials.index", compact('course', 'materials'));
    }

    public function create($course_id)
    {
        $course = Course::findOrFail($course_id);
        if (auth()->user()->role !== 'teacher') {
            abort(403);
        }
        return view('teacher.materials.create', compact('course'));
    }

    public function store(Request $request, $course_id)
    {
        if (auth()->user()->role !== 'teacher') {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $course = Course::findOrFail($course_id);

        $path = $request->file('file')->store('materials', 'public');

        $course->materials()->create([
            'title' => $request->title,
            'file_path' => $path,
        ]);

        return redirect()->route('materials.index', $course_id)->with('success', 'Material uploaded successfully!');
    }

    public function download($id)
    {
        $material = Material::findOrFail($id);
        return Storage::disk('public')->download($material->file_path);
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'teacher') {
            abort(403);
        }

        $material = Material::findOrFail($id);
        if (Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();

        return redirect()->back()->with('success', 'Material deleted successfully!');
    }
}
