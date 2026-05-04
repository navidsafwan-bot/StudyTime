<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the authenticated user's profile edit form.
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'age' => 'nullable|integer|min:1',
            'education' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        if ($user->role === 'teacher') {
            $rules['expertise'] = 'nullable|string|max:255';
            $rules['teaching_experience'] = 'nullable|string';
        } else {
            $rules['academic_info'] = 'nullable|string';
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $validated['profile_image'] = $imagePath;
        }

        $user->update($validated);

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }

    /**
     * Display the specified user's profile.
     */
    public function show($id)
    {
        $targetUser = User::findOrFail($id);
        $authUser = Auth::user();

        // If trying to view own profile, redirect to index
        if ($authUser->id === $targetUser->id) {
            return redirect()->route('profile.index');
        }

        // Cross-Profile Viewing Authorization logic
        $hasAccess = false;

        // Fetch courses for the target user to check intersections
        $targetEnrolledCourseIds = $targetUser->role === 'student' ? $targetUser->enrolledCourses()->pluck('courses.id')->toArray() : [];
        $targetTaughtCourseIds = $targetUser->role === 'teacher' ? $targetUser->taughtCourses()->pluck('id')->toArray() : [];

        $authEnrolledCourseIds = $authUser->role === 'student' ? $authUser->enrolledCourses()->pluck('courses.id')->toArray() : [];
        $authTaughtCourseIds = $authUser->role === 'teacher' ? $authUser->taughtCourses()->pluck('id')->toArray() : [];

        if ($authUser->role === 'student' && $targetUser->role === 'teacher') {
            // Student can view Teacher if student is enrolled in a course taught by the teacher
            $hasAccess = count(array_intersect($authEnrolledCourseIds, $targetTaughtCourseIds)) > 0;
        } elseif ($authUser->role === 'teacher' && $targetUser->role === 'student') {
            // Teacher can view Student if student is enrolled in a course taught by the teacher
            $hasAccess = count(array_intersect($authTaughtCourseIds, $targetEnrolledCourseIds)) > 0;
        } elseif ($authUser->role === 'student' && $targetUser->role === 'student') {
            // Student can view Student if they share a course
            $hasAccess = count(array_intersect($authEnrolledCourseIds, $targetEnrolledCourseIds)) > 0;
        } elseif ($authUser->role === 'teacher' && $targetUser->role === 'teacher') {
            // Optional: Define behavior for teacher viewing teacher. (Deny or allow based on some logic)
            // For now, we'll restrict unless they somehow share a context or we just allow it. Let's deny to be strict.
            $hasAccess = false; 
        }

        if (!$hasAccess) {
            abort(403, 'You do not have permission to view this profile. Must share a course.');
        }

        return view('profile.show', compact('targetUser'));
    }
}
