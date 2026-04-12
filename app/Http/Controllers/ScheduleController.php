<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Course;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index($course_id)
    {
        $course = Course::findOrFail($course_id);
        $schedules = $course->schedules()->orderBy('session_date', 'asc')->get();
        $role = auth()->user()->role;

        return view("{$role}.schedules.index", compact('course', 'schedules'));
    }

    public function create($course_id)
    {
        $course = Course::findOrFail($course_id);
        if (auth()->user()->role !== 'teacher') {
            abort(403);
        }
        return view('teacher.schedules.create', compact('course'));
    }

    public function store(Request $request, $course_id)
    {
        if (auth()->user()->role !== 'teacher') {
            abort(403);
        }

        $request->validate([
            'session_date' => 'required|date',
            'topic' => 'required|string|max:255',
            'type' => 'required|in:class,exam,assignment',
        ]);

        $course = Course::findOrFail($course_id);
        $course->schedules()->create($request->only('session_date', 'topic', 'type'));

        return redirect()->route('schedules.index', $course->id)->with('success', 'Schedule added successfully!');
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'teacher') {
            abort(403);
        }

        $schedule = Schedule::findOrFail($id);
        $course = $schedule->course;
        return view('teacher.schedules.edit', compact('course', 'schedule'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'teacher') {
            abort(403);
        }

        $request->validate([
            'session_date' => 'required|date',
            'topic' => 'required|string|max:255',
            'type' => 'required|in:class,exam,assignment',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->only('session_date', 'topic', 'type'));

        return redirect()->route('schedules.index', $schedule->course_id)->with('success', 'Schedule updated successfully!');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'teacher') {
            abort(403);
        }

        $schedule = Schedule::findOrFail($id);
        $course_id = $schedule->course_id;
        $schedule->delete();

        return redirect()->route('schedules.index', $course_id)->with('success', 'Schedule deleted successfully!');
    }
}
