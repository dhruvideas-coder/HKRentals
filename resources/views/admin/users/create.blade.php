<x-layout.admin-layout>
    <x-slot:title>Create User</x-slot:title>
    <x-slot:pageTitle>Create User</x-slot:pageTitle>

    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="p-2 bg-white rounded-xl border border-neutral-200 text-neutral-500 hover:text-brand-600 hover:border-brand-200 hover:bg-brand-50 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-neutral-800">Add New User</h2>
                <p class="text-sm text-neutral-500 mt-1">Create a new system user and assign their role.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
            <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 md:p-8 space-y-6">
                @csrf

                <div class="space-y-4">
                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-neutral-700 mb-1.5">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-2.5 bg-neutral-50 border border-neutral-200 text-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all @error('name') border-red-300 bg-red-50 focus:ring-red-500/20 focus:border-red-500 @enderror" 
                               placeholder="e.g. John Doe">
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-neutral-700 mb-1.5">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-2.5 bg-neutral-50 border border-neutral-200 text-neutral-800 rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all @error('email') border-red-300 bg-red-50 focus:ring-red-500/20 focus:border-red-500 @enderror" 
                               placeholder="e.g. john@example.com">
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
                                <option value="" disabled selected>Select a role...</option>
                                <option value="super_admin" @selected(old('role') === 'super_admin')>Super Admin (Full Access)</option>
                                <option value="admin" @selected(old('role') === 'admin')>Admin (Limited Access)</option>
                                <option value="member" @selected(old('role') === 'member')>Member (Customer / Frontend User)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-neutral-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        @error('role')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <div class="mt-3 p-4 bg-blue-50/50 border border-blue-100 rounded-xl">
                            <h4 class="text-xs font-bold text-blue-800 uppercase tracking-wider mb-2">Role Permissions</h4>
                            <ul class="text-xs text-blue-700 space-y-1.5">
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span><strong>Super Admin:</strong> Full access to all modules, including User Management.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span><strong>Admin:</strong> Can manage products, orders, and settings, but cannot manage users.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span><strong>Member:</strong> Restricted to the frontend website. Cannot access admin portal.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-neutral-100 mt-6">
                    <a href="{{ route('admin.users.index') }}" class="w-full sm:w-auto px-5 py-2.5 text-sm font-semibold text-neutral-600 bg-neutral-100 hover:bg-neutral-200 rounded-xl transition-colors text-center">
                        Cancel
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-5 py-2.5 text-sm font-semibold text-white bg-brand-500 hover:bg-brand-600 rounded-xl shadow-lg shadow-brand-500/30 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout.admin-layout>
