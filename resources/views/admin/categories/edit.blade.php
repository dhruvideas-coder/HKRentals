<x-layout.admin-layout>
    <x-slot:title>Edit Category - {{ $category->name }}</x-slot:title>
    <x-slot:pageTitle>Catalogue / Edit Category</x-slot:pageTitle>

    <div class="max-w-4xl mx-auto">
        {{-- Breadcrumbs & Back --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.categories.index') }}" class="w-10 h-10 rounded-xl bg-white border border-neutral-100 shadow-sm flex items-center justify-center text-neutral-400 hover:text-brand-600 hover:border-brand-100 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="text-3xl font-display font-bold text-neutral-900 tracking-tight">Edit Category</h2>
                <p class="text-neutral-400 text-sm mt-1 font-medium">{{ $category->name }}</p>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="p-6 md:p-10 space-y-8 md:space-y-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10">
                        {{-- Name --}}
                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Category Name</label>
                            <input type="text" name="name" required value="{{ old('name', $category->name) }}"
                                   class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-semibold shadow-sm" 
                                   placeholder="e.g. Luxury Seating" />
                        </div>

                        {{-- Icon --}}
                        <div>
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Representative Icon / Emoji</label>
                            <div class="flex items-center gap-4" x-data="{ icon: '{{ $category->icon ?: '📦' }}' }">
                                <div class="w-16 h-16 bg-neutral-50 rounded-2xl flex items-center justify-center text-3xl border border-neutral-100 shadow-sm" x-text="icon"></div>
                                <input type="text" name="icon" x-model="icon" maxlength="10"
                                       class="flex-1 px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium shadow-sm" 
                                       placeholder="e.g. 🪑" />
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Brief Description</label>
                            <textarea name="description" rows="4"
                                      class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium resize-none shadow-sm" 
                                      placeholder="What kind of items belong here?">{{ old('description', $category->description) }}</textarea>
                        </div>

                        {{-- Media --}}
                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Cover Image (Optional)</label>
                            <div x-data="{ preview: '{{ $category->image ? asset($category->image) : '' }}' }">
                                <input type="file" name="image" id="cat_image_input" @change="preview = URL.createObjectURL($event.target.files[0])" class="hidden" />
                                <div class="relative w-full h-48 border-2 border-dashed border-neutral-200 rounded-3xl bg-neutral-50 hover:bg-white hover:border-brand-300 transition-all cursor-pointer flex flex-col items-center justify-center overflow-hidden group shadow-inner"
                                     @click="document.getElementById('cat_image_input').click()">
                                    <template x-if="preview">
                                        <img :src="preview" class="w-full h-full object-cover" />
                                    </template>
                                    <template x-if="!preview">
                                        <div class="text-center">
                                            <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center mx-auto mb-3">
                                                <svg class="w-6 h-6 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                            <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">Upload Category Banner</p>
                                        </div>
                                    </template>
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center" x-show="preview">
                                        <span class="text-white text-[10px] font-bold uppercase tracking-widest">Change Banner</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 md:px-10 py-6 md:py-8 bg-neutral-50/50 border-t border-neutral-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-xs text-neutral-400 font-medium italic text-center sm:text-left">Updating this category will affect all linked products.</p>
                    <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                        <a href="{{ route('admin.categories.index') }}" class="w-full sm:w-auto px-6 py-3 text-neutral-500 font-bold hover:text-neutral-700 transition-all text-center border border-neutral-200 sm:border-transparent rounded-xl sm:rounded-none bg-white sm:bg-transparent shadow-sm sm:shadow-none">Cancel</a>
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-brand-600 text-white rounded-xl font-bold shadow-lg shadow-brand-200 hover:bg-brand-700 hover:-translate-y-0.5 transition-all text-center">
                            Update Category
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout.admin-layout>
