<x-layout.admin-layout>
    <x-slot:title>Edit Product - {{ $product->name }}</x-slot:title>
    <x-slot:pageTitle>Catalogue / Edit Product</x-slot:pageTitle>

    <div class="max-w-5xl mx-auto">
        {{-- Breadcrumbs & Back --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.products.index') }}" class="w-10 h-10 rounded-xl bg-white border border-neutral-100 shadow-sm flex items-center justify-center text-neutral-400 hover:text-brand-600 hover:border-brand-100 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="text-3xl font-display font-bold text-neutral-900 tracking-tight">Edit Product</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-sm text-neutral-400 font-medium">Catalogue</span>
                    <svg class="w-3 h-3 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-sm text-brand-600 font-bold">{{ $product->name }}</span>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-20">
            @csrf
            @method('PUT')

            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Basic Information Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden">
                    <div class="px-6 md:px-10 pt-6 md:pt-8 border-b border-neutral-50 bg-neutral-50/30">
                        <h3 class="text-lg font-bold text-neutral-800">Essential Information</h3>
                        <p class="text-sm text-neutral-400 mt-1">Update the core details of your rental item.</p>
                    </div>
                    <div class="p-6 md:p-10 space-y-6">
                        <div>
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Product Title</label>
                            <input type="text" name="name" required value="{{ old('name', $product->name) }}"
                                   class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-semibold placeholder-neutral-300 shadow-sm"
                                   placeholder="e.g. Victorian Gold Throne Chair" />
                            @error('name') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Detailed Description</label>
                            <textarea name="description" rows="6"
                                      class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium resize-none shadow-sm"
                                      placeholder="Describe the elegance, size, and unique features of this item...">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Primary Color</label>
                                <input type="text" name="color" value="{{ old('color', $product->color) }}"
                                       class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium shadow-sm"
                                       placeholder="e.g. Rose Gold" />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Material</label>
                                <input type="text" name="material" value="{{ old('material', $product->material) }}"
                                       class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium shadow-sm"
                                       placeholder="e.g. Velvet & Steel" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pricing & Inventory Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden">
                    <div class="px-6 md:px-10 pt-6 md:pt-8 border-b border-neutral-50 bg-neutral-50/30">
                        <h3 class="text-lg font-bold text-neutral-800">Pricing & Inventory</h3>
                        <p class="text-sm text-neutral-400 mt-1">Manage rental rates and stock levels.</p>
                    </div>
                    <div class="p-6 md:p-10 grid grid-cols-1 sm:grid-cols-2 gap-6 md:gap-8">
                        <div>
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Daily Rental Rate</label>
                            <div class="relative group">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-neutral-400 font-bold group-focus-within:text-brand-600 transition-colors">$</span>
                                <input type="number" step="0.01" name="price_per_day" inputmode="decimal" required value="{{ old('price_per_day', $product->price_per_day) }}"
                                       class="block w-full pl-12 pr-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-900 font-extrabold shadow-sm"
                                       placeholder="0.00" />
                                @error('price_per_day') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Total Units in Stock</label>
                            <input type="number" name="total_quantity" inputmode="numeric" required value="{{ old('total_quantity', $product->total_quantity) }}"
                                   class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-900 font-extrabold shadow-sm"
                                   placeholder="10" />
                            @error('total_quantity') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Specifications Card --}}
                @php
                    if (old('spec_keys')) {
                        $existingSpecs = [];
                        foreach (old('spec_keys', []) as $i => $key) {
                            $existingSpecs[] = ['key' => $key, 'val' => old('spec_values', [])[$i] ?? ''];
                        }
                    } else {
                        $existingSpecs = collect($product->product_specification ?? [])
                            ->map(fn($val, $key) => ['key' => $key, 'val' => $val])
                            ->values()
                            ->toArray();
                    }
                @endphp
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden"
                     x-data="{
                        specs: {{ json_encode($existingSpecs) }},
                        addSpec() { this.specs.push({ key: '', val: '' }); }
                     }">
                    <div class="px-6 md:px-10 pt-6 md:pt-8 border-b border-neutral-50 bg-neutral-50/30">
                        <h3 class="text-lg font-bold text-neutral-800">Specifications</h3>
                        <p class="text-sm text-neutral-400 mt-1">Add technical details like dimensions, weight, materials, etc.</p>
                    </div>
                    <div class="p-6 md:p-10">
                        <div class="grid grid-cols-[1fr_1fr_2rem] gap-3 mb-3 px-1">
                            <span class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider">Attribute</span>
                            <span class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider">Value</span>
                            <span></span>
                        </div>

                        <template x-for="(spec, i) in specs" :key="i">
                            <div class="grid grid-cols-[1fr_1fr_2rem] gap-3 mb-3 items-center">
                                <input type="text" name="spec_keys[]" x-model="specs[i].key"
                                       class="w-full px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium text-sm shadow-sm"
                                       placeholder="e.g. Height" />
                                <input type="text" name="spec_values[]" x-model="specs[i].val"
                                       class="w-full px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium text-sm shadow-sm"
                                       placeholder="e.g. 120 cm" />
                                <button type="button" @click="specs.splice(i, 1)"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-neutral-300 hover:text-red-500 hover:bg-red-50 transition-all text-lg font-bold">
                                    &times;
                                </button>
                            </div>
                        </template>

                        <div x-show="specs.length === 0" class="text-center py-6 text-neutral-400 text-sm">
                            No specifications added yet.
                        </div>

                        <button type="button" @click="addSpec()"
                                class="mt-4 w-full py-3 border-2 border-dashed border-neutral-200 rounded-2xl text-sm font-bold text-neutral-400 hover:border-brand-300 hover:text-brand-600 hover:bg-brand-50/30 transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            Add Specification
                        </button>
                    </div>
                </div>

                {{-- Gallery Images Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden"
                     x-data="{ previews: [], add(files) { Array.from(files).forEach(f => this.previews.push({ src: URL.createObjectURL(f) })); } }">
                    <div class="px-6 md:px-10 pt-6 md:pt-8 border-b border-neutral-50 bg-neutral-50/30">
                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div>
                                <h3 class="text-lg font-bold text-neutral-800">Gallery Images</h3>
                                <p class="text-sm text-neutral-400 mt-1">Extra product photos shown as thumbnails on the product page</p>
                            </div>
                            <span class="text-xs font-bold text-neutral-500 bg-neutral-100 px-3 py-1.5 rounded-full">
                                {{ $product->images->count() }} / 8 saved
                            </span>
                        </div>
                    </div>
                    <div class="p-6 md:p-10 space-y-6">

                        {{-- Existing saved images --}}
                        @if($product->images->isNotEmpty())
                            <div>
                                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider mb-4">Saved Images — hover to remove</p>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                    @foreach($product->images as $img)
                                        <div class="relative group" x-data="{ deleted: false }">
                                            {{-- Image --}}
                                            <div class="aspect-square rounded-2xl overflow-hidden shadow-sm transition-all duration-200"
                                                 :class="deleted ? 'opacity-25 scale-95 ring-2 ring-red-300' : 'hover:shadow-lg'">
                                                <img src="{{ asset($img->image) }}" alt="Gallery image {{ $loop->iteration }}"
                                                     class="w-full h-full object-cover">
                                            </div>
                                            {{-- Index badge --}}
                                            <span class="absolute bottom-2 left-2 bg-black/50 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-0.5 rounded-full pointer-events-none"
                                                  x-show="!deleted">#{{ $loop->iteration }}</span>
                                            {{-- Delete / Undo --}}
                                            <button type="button" @click="deleted = !deleted"
                                                    :class="deleted ? 'bg-green-500 opacity-100 scale-110' : 'bg-red-500 opacity-0 group-hover:opacity-100'"
                                                    class="absolute top-2 right-2 w-7 h-7 rounded-full text-white text-sm font-bold flex items-center justify-center transition-all duration-200 shadow-lg">
                                                <span x-text="deleted ? '↩' : '×'"></span>
                                            </button>
                                            {{-- Will be removed label --}}
                                            <div class="absolute inset-x-2 bottom-2 bg-red-500/90 backdrop-blur-sm text-white text-[10px] font-bold text-center py-1 rounded-xl pointer-events-none"
                                                 x-show="deleted">Will be removed</div>
                                            <template x-if="deleted">
                                                <input type="hidden" name="delete_image_ids[]" value="{{ $img->id }}">
                                            </template>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- New images preview --}}
                        <div x-show="previews.length > 0" x-cloak>
                            <p class="text-[10px] font-bold text-brand-600 uppercase tracking-wider mb-4">New Images — ready to upload</p>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                <template x-for="(img, i) in previews" :key="i">
                                    <div class="relative group">
                                        <div class="aspect-square rounded-2xl overflow-hidden ring-2 ring-brand-400 shadow-sm">
                                            <img :src="img.src" class="w-full h-full object-cover">
                                        </div>
                                        <span class="absolute top-2 left-2 bg-brand-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">NEW</span>
                                        <button type="button" @click="previews.splice(i, 1)"
                                                class="absolute top-2 right-2 w-7 h-7 bg-red-500 text-white rounded-full text-sm font-bold flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all shadow-lg">
                                            ×
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Drop zone --}}
                        <input type="file" name="gallery_images[]" multiple x-ref="galleryInput" class="hidden"
                               @change="add($event.target.files)" accept="image/jpeg,image/png,image/webp">
                        <div @click="$refs.galleryInput.click()"
                             @dragover.prevent
                             @drop.prevent="add($event.dataTransfer.files)"
                             class="group cursor-pointer border-2 border-dashed border-neutral-200 rounded-2xl p-8 text-center hover:border-brand-400 hover:bg-brand-50/30 transition-all duration-200">
                            <div class="w-14 h-14 bg-neutral-100 group-hover:bg-brand-100 rounded-2xl flex items-center justify-center mx-auto mb-4 transition-colors duration-200">
                                <svg class="w-7 h-7 text-neutral-400 group-hover:text-brand-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                </svg>
                            </div>
                            <p class="text-sm font-bold text-neutral-700 group-hover:text-brand-700 transition-colors">Click to upload or drag & drop</p>
                            <p class="text-xs text-neutral-400 mt-1">JPG, PNG, WebP • Max 4MB each • Up to 8 images</p>
                            <div class="mt-3 inline-flex items-center gap-1.5 bg-brand-50 text-brand-600 text-xs font-bold px-4 py-1.5 rounded-full"
                                 x-show="previews.length > 0" x-cloak>
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                <span x-text="previews.length + ' file(s) selected'"></span>
                            </div>
                        </div>
                        @error('gallery_images.*') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror

                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">

                {{-- Main Image Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden">
                    <div class="px-6 md:px-8 pt-6 border-b border-neutral-50 bg-neutral-50/30">
                        <h3 class="font-bold text-neutral-800">Main Image</h3>
                    </div>
                    <div class="p-6 md:p-8" x-data="{ preview: '{{ $product->image ? asset($product->image) : '' }}' }">
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
                                        <p class="text-[10px] text-neutral-400 mt-1 uppercase tracking-widest">JPG, PNG, WebP • 4MB</p>
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
                    <div class="px-6 md:px-8 pt-6 border-b border-neutral-50 bg-neutral-50/30">
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
                                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                                @error('category_id') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Product Status</label>
                            <div class="relative">
                                <select name="status" required
                                        class="block w-full px-5 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium appearance-none cursor-pointer shadow-sm">
                                    <option value="available" {{ old('status', $product->status) == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="unavailable" {{ old('status', $product->status) == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-neutral-900 to-neutral-800 rounded-[2.5rem] p-6 md:p-8 shadow-xl shadow-neutral-200">
                    <h4 class="text-white font-bold text-lg mb-2">Save Changes</h4>
                    <p class="text-neutral-400 text-sm mb-8 leading-relaxed">Update your product details and they will be instantly reflected in the customer-facing catalogue.</p>
                    <div class="flex flex-col gap-3">
                        <button type="submit" class="w-full px-6 py-4 bg-brand-600 text-white rounded-2xl font-bold shadow-lg shadow-brand-500/20 hover:bg-brand-700 hover:shadow-xl hover:-translate-y-0.5 transition-all tracking-wide">
                            Save Changes
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="w-full px-6 py-4 bg-white/5 text-white/60 text-center rounded-2xl font-bold hover:bg-white/10 hover:text-white transition-all">
                            Cancel Edit
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>
</x-layout.admin-layout>
