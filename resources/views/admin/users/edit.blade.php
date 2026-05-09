<x-layout.admin-layout>
    <x-slot:title>Edit User</x-slot:title>
    <x-slot:pageTitle>Edit User</x-slot:pageTitle>

    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="p-2 bg-white rounded-xl border border-neutral-200 text-neutral-500 hover:text-brand-600 hover:border-brand-200 hover:bg-brand-50 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-neutral-800">Edit User</h2>
                <p class="text-sm text-neutral-500 mt-1">Update user details and access privileges.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
            <div class="p-6 md:p-8 border-b border-neutral-100 bg-neutral-50/50 flex flex-col md:flex-row items-center gap-5">
                @if($user->avatar)
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover ring-4 ring-white shadow-md" referrerpolicy="no-referrer">
                @else
                    <div class="w-20 h-20 rounded-full bg-brand-500 flex items-center justify-center text-white text-2xl font-bold ring-4 ring-white shadow-md">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div class="text-center md:text-left">
                    <h3 class="text-lg font-bold text-neutral-800">{{ $user->name }}</h3>
                    <p class="text-neutral-500 text-sm">{{ $user->email }}</p>
                    <div class="mt-2">
                        @if($user->role === 'super_admin')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">Super Admin</span>
                        @elseif($user->role === 'admin')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">Admin</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-neutral-100 text-neutral-600">Member</span>
                        @endif
                        <span class="text-xs text-neutral-400 ml-2">Joined {{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 md:p-8 space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-neutral-700 mb-1.5">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-4 py-2.5 bg-neutral-50 border border-neutral-200 text-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all @error('name') border-red-300 bg-red-50 focus:ring-red-500/20 focus:border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-neutral-700 mb-1.5">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-4 py-2.5 bg-neutral-50 border border-neutral-200 text-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all @error('email') border-red-300 bg-red-50 focus:ring-red-500/20 focus:border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div>
                        <label for="role" class="block text-sm font-semibold text-neutral-700 mb-1.5">System Role</label>
                        <div class="relative">
                            <select id="role" name="role" required
                                    class="w-full px-4 py-2.5 bg-neutral-50 border border-neutral-200 text-neutral-800 rounded-xl appearance-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all @error('role') border-red-300 bg-red-50 focus:ring-red-500/20 focus:border-red-500 @enderror">
                                <option value="super_admin" @selected(old('role', $user->role) === 'super_admin')>Super Admin (Full Access)</option>
                                <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin (Limited Access)</option>
                                <option value="member" @selected(old('role', $user->role) === 'member')>Member (Customer / Frontend User)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-neutral-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        @error('role')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 flex flex-col-reverse sm:flex-row items-center justify-between gap-4 border-t border-neutral-100 mt-6">
                    <button type="button" 
                            onclick="if(confirm('Are you sure you want to delete this user? This action cannot be undone.')) { document.getElementById('delete-form').submit(); }"
                            class="w-full sm:w-auto px-4 py-2.5 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Delete User
                    </button>

                    <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                        <a href="{{ route('admin.users.index') }}" class="w-full sm:w-auto px-5 py-2.5 text-sm font-semibold text-neutral-600 bg-neutral-100 hover:bg-neutral-200 rounded-xl transition-colors text-center">
                            Cancel
                        </a>
                        <button type="submit" class="w-full sm:w-auto px-5 py-2.5 text-sm font-semibold text-white bg-brand-500 hover:bg-brand-600 rounded-xl shadow-lg shadow-brand-500/30 transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
            
            {{-- Hidden Delete Form --}}
            <form id="delete-form" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</x-layout.admin-layout>
