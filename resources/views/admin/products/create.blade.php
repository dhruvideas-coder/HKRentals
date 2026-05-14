<x-layout.admin-layout>
    <x-slot:title>Add New Product</x-slot:title>
    <x-slot:pageTitle>Catalogue / Add Product</x-slot:pageTitle>

    <div class="max-w-5xl mx-auto">
        {{-- Breadcrumbs & Back --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.products.index') }}" class="w-10 h-10 rounded-xl bg-white border border-neutral-100 shadow-sm flex items-center justify-center text-neutral-400 hover:text-brand-600 hover:border-brand-100 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="text-3xl font-display font-bold text-neutral-900 tracking-tight">Add New Product</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-sm text-neutral-400 font-medium">Catalogue</span>
                    <svg class="w-3 h-3 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-sm text-brand-600 font-bold">New Item</span>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-20">
            @csrf

            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Basic Information Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden">
                    <div class="px-6 md:px-10 py-6 md:py-8 border-b border-neutral-50 bg-neutral-50/30">
                        <h3 class="text-lg font-bold text-neutral-800">Essential Information</h3>
                        <p class="text-sm text-neutral-400 mt-1">Provide the core details of your rental item.</p>
                    </div>
                    <div class="p-6 md:p-10 space-y-6">
                        <div>
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Product Title</label>
                            <input type="text" name="name" required value="{{ old('name') }}"
                                   class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-semibold placeholder-neutral-300 shadow-sm" 
                                   placeholder="e.g. Victorian Gold Throne Chair" />
                            @error('name') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Detailed Description</label>
                            <textarea name="description" rows="6"
                                      class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium resize-none shadow-sm" 
                                      placeholder="Describe the elegance, size, and unique features of this item...">{{ old('description') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Primary Color</label>
                                <input type="text" name="color" value="{{ old('color') }}"
                                       class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium shadow-sm" 
                                       placeholder="e.g. Rose Gold" />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Material</label>
                                <input type="text" name="material" value="{{ old('material') }}"
                                       class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium shadow-sm" 
                                       placeholder="e.g. Velvet & Steel" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pricing & Inventory Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden">
                    <div class="px-6 md:px-10 py-6 md:py-8 border-b border-neutral-50 bg-neutral-50/30">
                        <h3 class="text-lg font-bold text-neutral-800">Pricing & Inventory</h3>
                        <p class="text-sm text-neutral-400 mt-1">Manage rental rates and stock levels.</p>
                    </div>
                    <div class="p-6 md:p-10 grid grid-cols-1 sm:grid-cols-2 gap-6 md:gap-8">
                        <div>
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Daily Rental Rate</label>
                            <div class="relative group">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-neutral-400 font-bold group-focus-within:text-brand-600 transition-colors">$</span>
                                <input type="number" step="0.01" name="price_per_day" inputmode="decimal" required value="{{ old('price_per_day') }}"
                                       class="block w-full pl-12 pr-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-900 font-extrabold shadow-sm"
                                       placeholder="0.00" />
                                 @error('price_per_day') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Total Units in Stock</label>
                            <input type="number" name="total_quantity" inputmode="numeric" required value="{{ old('total_quantity') }}"
                                   class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-900 font-extrabold shadow-sm"
                                   placeholder="10" />
                            @error('total_quantity') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Content --}}
            <div class="space-y-8">
                {{-- Media Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden">
                    <div class="px-6 md:px-8 py-6 border-b border-neutral-50 bg-neutral-50/30">
                        <h3 class="font-bold text-neutral-800">Product Image</h3>
                    </div>
                    <div class="p-6 md:p-8" x-data="{ preview: null }">
                        <input type="file" name="image" id="image_upload" class="hidden" @change="preview = URL.createObjectURL($event.target.files[0])">
                        <div class="relative group cursor-pointer" @click="document.getElementById('image_upload').click()">
                            <div class="aspect-square rounded-3xl bg-neutral-50 border-2 border-dashed border-neutral-200 flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-brand-300 group-hover:bg-white shadow-inner">
                                <template x-if="preview">
                                    <img :src="preview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!preview">
                                    <div class="text-center p-6">
                                        <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                            <svg class="w-8 h-8 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <p class="text-sm font-bold text-neutral-700">Click to Upload</p>
                                        <p class="text-[10px] text-neutral-400 mt-1 uppercase tracking-widest">JPG, PNG, WebP • 2MB</p>
                                    </div>
                                </template>
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center" x-show="preview">
                                    <span class="text-white text-xs font-bold uppercase tracking-widest">Change Image</span>
                                </div>
                            </div>
                        </div>
                        @error('image') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Classification Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden">
                    <div class="px-6 md:px-8 py-6 border-b border-neutral-50 bg-neutral-50/30">
                        <h3 class="font-bold text-neutral-800">Classification</h3>
                    </div>
                    <div class="p-6 md:p-8 space-y-6">
                        <div>
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Category</label>
                            <div class="relative">
                                <select name="category_id" required
                                        class="block w-full px-5 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium appearance-none cursor-pointer shadow-sm">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                                @error('category_id') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Initial Status</label>
                            <div class="relative">
                                <select name="status" required
                                        class="block w-full px-5 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium appearance-none cursor-pointer shadow-sm">
                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-neutral-900 to-neutral-800 rounded-[2.5rem] p-6 md:p-8 shadow-xl shadow-neutral-200">
                    <h4 class="text-white font-bold text-lg mb-2">Publish Product</h4>
                    <p class="text-neutral-400 text-sm mb-8 leading-relaxed">Once you publish, this item will be available for customers to view in your digital collection.</p>
                    <div class="flex flex-col gap-3">
                        <button type="submit" class="w-full px-6 py-4 bg-brand-600 text-white rounded-2xl font-bold shadow-lg shadow-brand-500/20 hover:bg-brand-700 hover:shadow-xl hover:-translate-y-0.5 transition-all tracking-wide">
                            Publish Now
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="w-full px-6 py-4 bg-white/5 text-white/60 text-center rounded-2xl font-bold hover:bg-white/10 hover:text-white transition-all">
                            Save as Draft
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layout.admin-layout>
