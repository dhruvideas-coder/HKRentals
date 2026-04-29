<x-layout.admin-layout>
    <x-slot:title>Products</x-slot>
    <x-slot:pageTitle>Products</x-slot>

{{-- Header + Add Button --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="font-display text-2xl font-semibold text-neutral-900">Rental Products</h2>
        <p class="text-sm text-neutral-500 mt-0.5">Manage your rental catalogue</p>
    </div>
    <button onclick="document.getElementById('add-product-modal').classList.remove('hidden')"
            class="btn btn-primary">
        + Add Product
    </button>
</div>

{{-- Filters bar --}}
<div class="card mb-6 p-4 flex flex-col sm:flex-row gap-3">
    <div class="flex-1">
        <input type="text" class="form-input text-sm" placeholder="Search products..." />
    </div>
    <select class="form-input text-sm w-full sm:w-44">
        <option>All Categories</option>
        <option>Seating</option>
        <option>Lighting</option>
        <option>Tableware</option>
        <option>Ceremony</option>
        <option>Furniture</option>
        <option>Decor</option>
    </select>
    <select class="form-input text-sm w-full sm:w-40">
        <option>All Status</option>
        <option>Available</option>
        <option>Unavailable</option>
    </select>
</div>

{{-- Products Table --}}
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th class="hidden sm:table-cell">Category</th>
                    <th>Price/Day</th>
                    <th>Status</th>
                    <th>Stock</th>
                    <th class="text-right pr-5">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                $products = [
                    ['image'=>'product-chairs.png',   'name'=>'Gold Chiavari Chairs', 'cat'=>'Seating',   'price'=>4,   'available'=>true, 'stock'=>50],
                    ['image'=>'product-arch.png',      'name'=>'Floral Wedding Arch',  'cat'=>'Ceremony',  'price'=>120, 'available'=>true, 'stock'=>3],
                    ['image'=>'product-tableware.png', 'name'=>'Luxury Table Setting', 'cat'=>'Tableware', 'price'=>18,  'available'=>true, 'stock'=>120],
                    ['image'=>'product-lighting.png',  'name'=>'String Light Canopy',  'cat'=>'Lighting',  'price'=>85,  'available'=>false,'stock'=>2],
                    ['image'=>'product-lounge.png',    'name'=>'White Lounge Suite',   'cat'=>'Furniture', 'price'=>200, 'available'=>true, 'stock'=>4],
                    ['image'=>'product-backdrop.png',  'name'=>'Floral Hex Backdrop',  'cat'=>'Decor',     'price'=>95,  'available'=>true, 'stock'=>8],
                ];
                @endphp

                @foreach($products as $p)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/'.$p['image']) }}" alt="{{ $p['name'] }}" class="w-10 h-10 rounded-lg object-cover flex-shrink-0" />
                            <span class="font-medium text-neutral-900 text-sm">{{ $p['name'] }}</span>
                        </div>
                    </td>
                    <td class="hidden sm:table-cell">
                        <span class="badge badge-gold text-xs">{{ $p['cat'] }}</span>
                    </td>
                    <td class="font-semibold text-neutral-800">${{ $p['price'] }}<span class="text-xs font-normal text-neutral-400">/day</span></td>
                    <td>
                        <span class="badge {{ $p['available'] ? 'badge-available' : 'badge-unavailable' }} text-xs">
                            {{ $p['available'] ? 'Available' : 'Unavailable' }}
                        </span>
                    </td>
                    <td>
                        <span class="text-sm font-medium {{ $p['stock'] <= 3 ? 'text-amber-600' : 'text-neutral-700' }}">
                            {{ $p['stock'] }} units
                        </span>
                    </td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2 pr-1">
                            <button class="p-1.5 rounded-lg hover:bg-brand-50 text-neutral-400 hover:text-brand-600 transition-base" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button class="p-1.5 rounded-lg hover:bg-red-50 text-neutral-400 hover:text-red-500 transition-base" title="Delete">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-neutral-100 flex items-center justify-between">
        <p class="text-sm text-neutral-400">Showing 6 of 6 products</p>
        <nav class="flex items-center gap-1">
            <button class="w-8 h-8 rounded-lg border border-neutral-200 text-sm text-neutral-500 hover:bg-neutral-50 transition-base flex items-center justify-center">‹</button>
            <button class="w-8 h-8 rounded-lg bg-brand-500 text-white text-sm font-semibold">1</button>
            <button class="w-8 h-8 rounded-lg border border-neutral-200 text-sm text-neutral-500 hover:bg-neutral-50 transition-base flex items-center justify-center">›</button>
        </nav>
    </div>
</div>

{{-- Add Product Modal --}}
<div id="add-product-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(0,0,0,0.5)">
    <div class="bg-white rounded-2xl shadow-elevated w-full max-w-lg p-7">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-display text-xl font-semibold text-neutral-900">Add New Product</h3>
            <button onclick="document.getElementById('add-product-modal').classList.add('hidden')" class="w-8 h-8 rounded-lg hover:bg-neutral-100 flex items-center justify-center text-neutral-500">✕</button>
        </div>
        <div class="space-y-4">
            <div><label class="form-label">Product Name</label><input type="text" class="form-input" placeholder="Gold Chiavari Chairs" /></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="form-label">Category</label>
                    <select class="form-input"><option>Seating</option><option>Lighting</option><option>Tableware</option><option>Ceremony</option><option>Furniture</option><option>Decor</option></select>
                </div>
                <div><label class="form-label">Price / Day ($)</label><input type="number" class="form-input" placeholder="0.00" /></div>
            </div>
            <div><label class="form-label">Description</label><textarea class="form-input resize-none" rows="3" placeholder="Product description..."></textarea></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="form-label">Stock Units</label><input type="number" class="form-input" placeholder="10" /></div>
                <div><label class="form-label">Status</label><select class="form-input"><option>Available</option><option>Unavailable</option></select></div>
            </div>
            <div><label class="form-label">Product Image</label><input type="file" class="form-input text-sm" accept="image/*" /></div>
        </div>
        <div class="flex gap-3 mt-7">
            <button onclick="document.getElementById('add-product-modal').classList.add('hidden')" class="btn btn-ghost flex-1">Cancel</button>
            <button class="btn btn-primary flex-1">Save Product</button>
        </div>
    </div>
</div>

</x-layout.admin-layout>
