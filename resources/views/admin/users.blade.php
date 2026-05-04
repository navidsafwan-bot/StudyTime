@extends('layouts.admin')

@section('header', 'Manage Users')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Users List</h2>
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..." class="border border-gray-300 rounded-l px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r hover:bg-indigo-700">Search</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-center">Role</th>
                    <th class="py-3 px-6 text-center">Status</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($users as $user)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $user->email }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="bg-{{ $user->role === 'admin' ? 'purple' : ($user->role === 'teacher' ? 'blue' : 'green') }}-200 text-{{ $user->role === 'admin' ? 'purple' : ($user->role === 'teacher' ? 'blue' : 'green') }}-600 py-1 px-3 rounded-full text-xs uppercase font-semibold">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        @if($user->status === 'active')
                            <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs uppercase font-semibold">Active</span>
                        @else
                            <span class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs uppercase font-semibold">Suspended</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center space-x-2">
                            @if($user->role !== 'admin')
                            <form method="POST" action="{{ route('admin.users.updateStatus', $user->id) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="w-8 h-8 rounded-full bg-{{ $user->status === 'active' ? 'yellow' : 'green' }}-100 text-{{ $user->status === 'active' ? 'yellow' : 'green' }}-500 hover:bg-{{ $user->status === 'active' ? 'yellow' : 'green' }}-200 flex items-center justify-center" title="{{ $user->status === 'active' ? 'Suspend User' : 'Activate User' }}">
                                    <i class="fas fa-{{ $user->status === 'active' ? 'ban' : 'check' }}"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-full bg-red-100 text-red-500 hover:bg-red-200 flex items-center justify-center" title="Delete User">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            @else
                                <span class="text-gray-400 text-xs">N/A</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-6 px-6 text-center text-gray-500">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
