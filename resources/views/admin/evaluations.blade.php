@extends('layouts.admin')

@section('header', 'Monitor Evaluations')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Evaluations List</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Course</th>
                    <th class="py-3 px-6 text-left">User</th>
                    <th class="py-3 px-6 text-center">Rating</th>
                    <th class="py-3 px-6 text-left">Feedback</th>
                    <th class="py-3 px-6 text-center">Spam Check</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($evaluations as $evaluation)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <span class="font-medium">{{ $evaluation->course->title ?? 'N/A' }}</span>
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $evaluation->user->name ?? 'N/A' }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="text-yellow-500"><i class="fas fa-star mr-1"></i>{{ $evaluation->rating }}</span>
                    </td>
                    <td class="py-3 px-6 text-left max-w-md truncate" title="{{ $evaluation->feedback }}">
                        {{ Str::limit($evaluation->feedback, 50) }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        @php
                            $isSpam = strlen($evaluation->feedback) < 5 || preg_match('/(spam|fake|test|asdf)/i', $evaluation->feedback);
                        @endphp
                        @if($isSpam)
                            <span class="bg-red-100 text-red-600 py-1 px-3 rounded-full text-xs font-semibold"><i class="fas fa-exclamation-triangle mr-1"></i> Flagged</span>
                        @else
                            <span class="bg-green-100 text-green-600 py-1 px-3 rounded-full text-xs font-semibold"><i class="fas fa-check-circle mr-1"></i> Normal</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-6 px-6 text-center text-gray-500">No evaluations found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $evaluations->links() }}
    </div>
</div>
@endsection
