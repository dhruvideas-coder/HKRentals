<x-layout.admin-layout>
    <x-slot:title>User Management</x-slot:title>
    <x-slot:pageTitle>User Management</x-slot:pageTitle>

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-neutral-800">System Users</h2>
            <p class="text-sm text-neutral-500 mt-1">Manage super admins, admins, and members across the platform.</p>
        </div>
        @if(auth()->user()->isSuperAdmin())
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-500 text-white font-semibold text-sm rounded-xl hover:bg-brand-600 transition-all shadow-lg shadow-brand-500/30">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Add New User
        </a>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
        <div class="admin-table-container">
            <table class="admin-table text-left whitespace-nowrap">
                <thead class="bg-neutral-50/50 border-b border-neutral-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-xs font-bold text-neutral-500 uppercase tracking-wider">User</th>
                        <th scope="col" class="px-6 py-4 text-xs font-bold text-neutral-500 uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-4 text-xs font-bold text-neutral-500 uppercase tracking-wider">Joined Date</th>
                        <th scope="col" class="px-6 py-4 text-xs font-bold text-neutral-500 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-neutral-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($user->avatar)
                                        <img class="h-10 w-10 rounded-full object-cover ring-2 ring-white shadow-sm" src="{{ $user->avatar }}" alt="{{ $user->name }}" referrerpolicy="no-referrer">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 font-bold ring-2 ring-white shadow-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-neutral-800">{{ $user->name }}</div>
                                        <div class="text-sm text-neutral-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->role === 'super_admin')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">
                                        Super Admin
                                    </span>
                                @elseif($user->role === 'admin')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                        Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-neutral-100 text-neutral-600">
                                        Member
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-600">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if(auth()->user()->isSuperAdmin())
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-neutral-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit User">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-neutral-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete User">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    @else
                                        <span class="p-2 text-neutral-300 cursor-not-allowed" title="Cannot delete yourself">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </span>
                                    @endif
                                </div>
                                @else
                                <span class="text-xs text-neutral-400 italic">No access</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-neutral-500">
                                <svg class="w-12 h-12 mx-auto text-neutral-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                <p class="text-lg font-medium text-neutral-600">No users found</p>
                                <p class="text-sm mt-1">There are currently no users matching your criteria.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-neutral-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-layout.admin-layout>
