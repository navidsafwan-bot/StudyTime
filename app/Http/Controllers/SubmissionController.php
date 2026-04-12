<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Assignment;
use App\Models\Submission;

class SubmissionController extends Controller
{
    public function store(Request $request, $assignment_id)
    {
        $assignment = Assignment::findOrFail($assignment_id);
        $user = Auth::user();

        // Check if user is a student in the course
        if ($user->role !== 'student' || !$assignment->course->students->contains($user->id)) {
            abort(403, 'Only enrolled students can submit assignments.');
        }

        if (now()->greaterThan($assignment->deadline)) {
            return back()->with('error', 'Deadline has passed. Late submissions are not allowed.');
        }

        $request->validate([
            'file' => 'required|file|max:10240', // 10MB limit
        ]);

        $filePath = $request->file('file')->store('submissions', 'public');

        // Check if previously submitted and replace
        $submission = Submission::where('assignment_id', $assignment->id)
                                ->where('student_id', $user->id)
                                ->first();

        if ($submission) {
            // Delete old file
            if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
                Storage::disk('public')->delete($submission->file_path);
            }

            $submission->update([
                'file_path' => $filePath,
                'submitted_at' => now(),
            ]);
        } else {
            Submission::create([
                'assignment_id' => $assignment->id,
                'student_id' => $user->id,
                'file_path' => $filePath,
                'submitted_at' => now(),
            ]);
        }

        return back()->with('success', 'Assignment submitted successfully.');
    }

    public function download($id)
    {
        $submission = Submission::findOrFail($id);
        $user = Auth::user();
        
        // Only teacher or owner can download
        if ($user->role === 'student' && $submission->student_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        if (!$submission->file_path || !Storage::disk('public')->exists($submission->file_path)) {
            return back()->with('error', 'File not found.');
        }

        return Storage::disk('public')->download($submission->file_path);
    }
}
