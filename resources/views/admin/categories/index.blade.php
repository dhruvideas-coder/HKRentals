<x-layout.admin-layout>
    <x-slot:title>Categories Management</x-slot>
    <x-slot:pageTitle>Categories</x-slot>

    <div x-data="{ deleteModalOpen: false, deleteId: '' }"
         x-init="$watch('deleteModalOpen', val => { const m = document.getElementById('admin-content'); m.style.overflow = val ? 'hidden' : ''; })"
         @keydown.escape.window="deleteModalOpen = false">

        {{-- Header + Add Button --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
            <div>
                <h2 class="font-display text-3xl font-bold text-neutral-900">Categories</h2>
                <p class="text-neutral-500 mt-1">Organize your rental inventory with distinct categories</p>
            </div>
            <a href="{{ route('admin.categories.create') }}"
                    class="group inline-flex items-center gap-2 px-6 py-3 bg-brand-600 text-white rounded-xl font-bold shadow-lg shadow-brand-200 hover:bg-brand-700 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Add Category</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Category List --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-neutral-50/50 border-b border-neutral-100">
                                <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em]">Category Info</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em]">Slug</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em]">Products</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100">
                            @forelse($categories as $c)
                            <tr class="group hover:bg-neutral-50/50 transition-all duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center text-2xl shadow-sm ring-1 ring-brand-100/50">
                                            {{ $c->icon ?: '📦' }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-neutral-800 text-sm mb-0.5 leading-tight">{{ $c->name }}</p>
                                            <p class="text-[11px] text-neutral-400 truncate max-w-[150px]">{{ Str::limit($c->description, 30) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <code class="text-[10px] font-bold bg-neutral-100 text-neutral-500 px-2 py-1 rounded-md uppercase tracking-wider">/{{ $c->slug }}</code>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-brand-50 text-brand-700 text-[10px] font-bold uppercase tracking-wider">
                                        {{ $c->products_count }} items
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.categories.edit', $c) }}" 
                                        class="p-2 rounded-lg bg-neutral-50 text-neutral-400 hover:bg-brand-50 hover:text-brand-600 transition-all duration-200" title="Edit">
                                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <button @click="deleteId = '{{ $c->id }}'; deleteModalOpen = true" 
                                                class="p-2 rounded-lg bg-neutral-50 text-neutral-400 hover:bg-red-50 hover:text-red-600 transition-all duration-200" title="Delete">
                                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-neutral-50 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-neutral-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-neutral-800">No categories found</h3>
                                        <p class="text-neutral-400 text-sm max-w-xs mt-1">Start organizing your rental items by adding your first category.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Info Card / Quick Stats --}}
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-brand-600 to-brand-700 rounded-3xl p-8 text-white shadow-xl shadow-brand-100">
                    <h4 class="text-xl font-bold mb-2">Category Management</h4>
                    <p class="text-brand-100 text-sm leading-relaxed mb-6">Efficiently organize your catalogue. Categories help customers find products faster and improve your dashboard reporting.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4">
                            <p class="text-[10px] font-bold text-brand-200 uppercase tracking-widest mb-1">Total</p>
                            <p class="text-2xl font-bold">{{ $categories->count() }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4">
                            <p class="text-[10px] font-bold text-brand-200 uppercase tracking-widest mb-1">Active</p>
                            <p class="text-2xl font-bold">{{ $categories->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-8 border border-neutral-100 shadow-sm">
                    <h4 class="font-bold text-neutral-800 mb-4">Quick Tip</h4>
                    <p class="text-sm text-neutral-500 leading-relaxed">Use descriptive icons and names. Avoid overlapping categories to ensure a smooth navigation experience for your users.</p>
                </div>
            </div>
        </div>

        {{-- Delete Confirmation Modal --}}
        {{-- Backdrop: own transition so backdrop-filter renders independently --}}
        <template x-teleport="body">
        <div x-show="deleteModalOpen"
             x-cloak
             x-transition:enter="transition-opacity ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[69] bg-neutral-900/60 backdrop-blur-md"
             @click="deleteModalOpen = false"></div>
        </template>

        {{-- Card: own scale + fade transition --}}
        <template x-teleport="body">
        <div x-show="deleteModalOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="fixed inset-0 z-[70] flex items-center justify-center p-4 pointer-events-none">

            <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md p-8 text-center pointer-events-auto">

                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6 rotate-12">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>

                <h3 class="text-2xl font-bold text-neutral-900 mb-2">Delete Category?</h3>
                <p class="text-neutral-500 mb-8 px-4">This category will be moved to trash. Products linked to this category may lose their reference.</p>

                <div class="flex flex-col gap-3">
                    <form :action="'{{ route('admin.categories.index') }}/' + deleteId" method="POST" id="deleteCatForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-6 py-4 bg-red-500 text-white rounded-2xl font-bold shadow-lg shadow-red-100 hover:bg-red-600 hover:shadow-xl transition-all">
                            Yes, Move to Trash
                        </button>
                    </form>
                    <button @click="deleteModalOpen = false" class="w-full px-6 py-4 bg-neutral-50 text-neutral-600 rounded-2xl font-bold hover:bg-neutral-100 transition-all">
                        No, Keep it
                    </button>
                </div>
            </div>
        </div>
        </template>

    </div>

</x-layout.admin-layout>
