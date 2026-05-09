<x-layout.admin-layout :pageTitle="'My Profile'">

<div class="max-w-4xl mx-auto space-y-6">

    {{-- Profile Hero Card --}}
    <div class="relative rounded-2xl overflow-hidden shadow-sm border border-neutral-100">
        {{-- Cover gradient --}}
        <div class="h-36 bg-gradient-to-r from-[#5b4132] via-[#7a5a46] to-[#c8903a]">
            <div class="absolute inset-0 h-36 opacity-20"
                 style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>
        </div>

        {{-- White card body --}}
        <div class="bg-white p-6">
            {{-- Avatar overlapping cover --}}
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 -mt-12 mb-4">
                <div class="relative w-fit">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}"
                             alt="{{ $user->name }}"
                             class="w-24 h-24 rounded-2xl object-cover ring-4 ring-white shadow-xl"
                             referrerpolicy="no-referrer" />
                    @else
                        <div class="w-24 h-24 rounded-2xl bg-brand-500 flex items-center justify-center text-white text-3xl font-bold ring-4 ring-white shadow-xl">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-2 pb-1">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-brand-100 text-brand-700 border border-brand-200">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Super Admin
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        Active
                    </span>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-neutral-900">{{ $user->name }}</h2>
                <p class="text-sm text-neutral-500 mt-0.5 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ $user->email }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: Edit Form --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Edit Name Card --}}
            <div class="bg-white rounded-2xl border border-neutral-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-neutral-800">Edit Display Name</h3>
                        <p class="text-xs text-neutral-400">Update how your name appears in the admin panel</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.profile.update') }}" class="px-6 py-5">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-xs font-bold text-neutral-600 uppercase tracking-wider mb-1.5">Display Name</label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-neutral-200 bg-neutral-50 text-sm text-neutral-800 font-medium focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400 focus:bg-white transition-all @error('name') border-red-400 bg-red-50 @enderror"
                                   placeholder="Your name" />
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-neutral-600 uppercase tracking-wider mb-1.5">Email Address</label>
                            <div class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-neutral-200 bg-neutral-100 text-sm text-neutral-500">
                                <svg class="w-4 h-4 text-neutral-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                {{ $user->email }}
                                <span class="ml-auto text-[10px] font-bold bg-neutral-200 text-neutral-500 px-2 py-0.5 rounded-full">Google OAuth</span>
                            </div>
                            <p class="mt-1 text-xs text-neutral-400">Email is managed by Google and cannot be changed here.</p>
                        </div>
                    </div>

                    <div class="mt-5 flex items-center gap-3">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl transition-all shadow-sm hover:shadow-md active:scale-95">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Save Changes
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-neutral-500 hover:text-neutral-700 font-medium transition-colors">Cancel</a>
                    </div>
                </form>
            </div>

            {{-- Google Account Info --}}
            <div class="bg-white rounded-2xl border border-neutral-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-neutral-800">Google Account</h3>
                        <p class="text-xs text-neutral-400">Your admin access is linked to Google</p>
                    </div>
                </div>
                <div class="px-6 py-5">
                    <div class="flex items-center justify-between p-3.5 rounded-xl bg-neutral-50 border border-neutral-100">
                        <div class="flex items-center gap-3">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full" referrerpolicy="no-referrer" />
                            @else
                                <div class="w-10 h-10 rounded-full bg-brand-500 flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-semibold text-neutral-800">{{ $user->name }}</p>
                                <p class="text-xs text-neutral-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-green-50 text-green-700 border border-green-200">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Verified
                        </span>
                    </div>
                    <p class="mt-3 text-xs text-neutral-400 flex items-start gap-1.5">
                        <svg class="w-3.5 h-3.5 text-neutral-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Admin access is controlled via Google OAuth. Your email must be in the approved admin list to log in.
                    </p>
                </div>
            </div>

        </div>

        {{-- RIGHT: Account Details --}}
        <div class="space-y-6">

            {{-- Account Summary --}}
            <div class="bg-white rounded-2xl border border-neutral-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-neutral-100">
                    <h3 class="text-sm font-bold text-neutral-800">Account Details</h3>
                </div>
                <div class="px-5 py-4 space-y-4">
                    <div>
                        <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1">Member Since</p>
                        <p class="text-sm font-semibold text-neutral-700">
                            {{ $user->created_at ? $user->created_at->format('d M Y') : '—' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1">Last Updated</p>
                        <p class="text-sm font-semibold text-neutral-700">
                            {{ $user->updated_at ? $user->updated_at->diffForHumans() : '—' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1">Role</p>
                        <p class="text-sm font-semibold text-neutral-700 capitalize">{{ $user->role ?? 'admin' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1">Auth Method</p>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-neutral-500" viewBox="0 0 24 24" fill="none"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                            <p class="text-sm font-semibold text-neutral-700">Google OAuth</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="bg-white rounded-2xl border border-neutral-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-neutral-100">
                    <h3 class="text-sm font-bold text-neutral-800">Quick Links</h3>
                </div>
                <div class="px-3 py-3 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-neutral-50 transition-all group">
                        <div class="w-7 h-7 rounded-lg bg-neutral-100 text-neutral-500 flex items-center justify-center group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="text-sm font-medium text-neutral-700 group-hover:text-brand-600 transition-colors">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-neutral-50 transition-all group">
                        <div class="w-7 h-7 rounded-lg bg-neutral-100 text-neutral-500 flex items-center justify-center group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <span class="text-sm font-medium text-neutral-700 group-hover:text-brand-600 transition-colors">Orders</span>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-neutral-50 transition-all group">
                        <div class="w-7 h-7 rounded-lg bg-neutral-100 text-neutral-500 flex items-center justify-center group-hover:bg-amber-50 group-hover:text-amber-600 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="text-sm font-medium text-neutral-700 group-hover:text-amber-600 transition-colors">Settings</span>
                    </a>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="bg-white rounded-2xl border border-red-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-red-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <h3 class="text-sm font-bold text-red-700">Sign Out</h3>
                </div>
                <div class="px-5 py-4">
                    <p class="text-xs text-neutral-500 mb-3">End your current session and return to the login page.</p>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-red-200 text-red-600 text-sm font-bold rounded-xl hover:bg-red-50 hover:border-red-300 transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

</x-layout.admin-layout>
