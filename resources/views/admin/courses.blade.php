@extends('layouts.admin')

@section('header', 'Manage Courses')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Courses List</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Course Title</th>
                    <th class="py-3 px-6 text-left">Description</th>
                    <th class="py-3 px-6 text-center">Enrollments</th>
                    <th class="py-3 px-6 text-center">Avg Rating</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($courses as $course)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <span class="font-medium">{{ $course->title }}</span>
                    </td>
                    <td class="py-3 px-6 text-left max-w-xs truncate">
                        {{ $course->description }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="bg-blue-100 text-blue-600 py-1 px-3 rounded-full text-xs font-semibold">{{ $course->enrollments_count }} Students</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="text-yellow-500"><i class="fas fa-star mr-1"></i>{{ number_format($course->evaluations_avg_rating ?? 0, 1) }}</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center space-x-2">
                            <a href="{{ route('courses.show', $course->id) }}" target="_blank" class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-500 hover:bg-indigo-200 flex items-center justify-center" title="View Course">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.courses.destroy', $course->id) }}" onsubmit="return confirm('Are you sure you want to delete this course? All related data will be lost.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-full bg-red-100 text-red-500 hover:bg-red-200 flex items-center justify-center" title="Delete Course">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-6 px-6 text-center text-gray-500">No courses found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $courses->links() }}
    </div>
</div>
@endsection
