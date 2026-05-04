<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Evaluation;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_courses' => Course::count(),
            'active_users' => User::where('status', 'active')->count(),
            'avg_rating' => Evaluation::avg('rating') ?? 0,
        ];
        
        return view('admin.dashboard', compact('stats'));
    }

    public function users(Request $request)
    {
        $query = User::query();
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        $users = $query->paginate(15);
        
        return view('admin.users', compact('users'));
    }

    public function updateUserStatus(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot suspend an admin.');
        }
        $user->status = $user->status === 'active' ? 'suspended' : 'active';
        $user->save();
        
        return back()->with('success', 'User status updated.');
    }

    public function deleteUser(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete an admin.');
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }

    public function courses()
    {
        $courses = Course::withCount('enrollments')->withAvg('evaluations', 'rating')->paginate(15);
        return view('admin.courses', compact('courses'));
    }

    public function deleteCourse(Course $course)
    {
        $course->delete();
        return back()->with('success', 'Course deleted.');
    }

    public function evaluations()
    {
        $evaluations = Evaluation::with(['course', 'user'])->paginate(15);
        return view('admin.evaluations', compact('evaluations'));
    }
}
