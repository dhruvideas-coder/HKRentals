@extends('layouts.admin')

@section('title', 'Categories')
@section('page_title', 'Categories')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="font-display text-2xl font-semibold text-neutral-900">Categories</h2>
        <p class="text-sm text-neutral-500 mt-0.5">Organize your rental items</p>
    </div>
    <button onclick="document.getElementById('add-cat-modal').classList.remove('hidden')" class="btn btn-primary">
        + Add Category
    </button>
</div>

<div class="grid lg:grid-cols-3 gap-6 items-start">

    {{-- Category List --}}
    <div class="lg:col-span-2 card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Slug</th>
                        <th>Products</th>
                        <th class="text-right pr-5">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $cats = [
                        ['name'=>'Seating',   'slug'=>'seating',   'count'=>1,  'icon'=>'🪑'],
                        ['name'=>'Ceremony',  'slug'=>'ceremony',  'count'=>1,  'icon'=>'💐'],
                        ['name'=>'Tableware', 'slug'=>'tableware', 'count'=>1,  'icon'=>'🍽️'],
                        ['name'=>'Lighting',  'slug'=>'lighting',  'count'=>1,  'icon'=>'💡'],
                        ['name'=>'Furniture', 'slug'=>'furniture', 'count'=>1,  'icon'=>'🛋️'],
                        ['name'=>'Decor',     'slug'=>'decor',     'count'=>1,  'icon'=>'🎨'],
                    ];
                    @endphp
                    @foreach($cats as $cat)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-brand-50 flex items-center justify-center text-lg flex-shrink-0">{{ $cat['icon'] }}</div>
                                <span class="font-semibold text-neutral-800">{{ $cat['name'] }}</span>
                            </div>
                        </td>
                        <td><code class="text-xs bg-neutral-100 text-neutral-600 px-2 py-0.5 rounded">/{{ $cat['slug'] }}</code></td>
                        <td>
                            <span class="badge badge-gold text-xs">{{ $cat['count'] }} items</span>
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
    </div>

    {{-- Quick Add Form --}}
    <div class="card p-6">
        <h3 class="font-semibold text-neutral-900 mb-5">Quick Add</h3>
        <div class="space-y-4">
            <div><label class="form-label">Category Name</label><input type="text" class="form-input" placeholder="e.g. Centrepieces" /></div>
            <div><label class="form-label">Icon / Emoji</label><input type="text" class="form-input" placeholder="🌸" maxlength="2" /></div>
            <div><label class="form-label">Description <span class="font-normal text-neutral-400">(optional)</span></label><textarea class="form-input resize-none text-sm" rows="3" placeholder="Short description..."></textarea></div>
            <button class="btn btn-primary w-full">Add Category</button>
        </div>
    </div>
</div>

{{-- Add Category Modal --}}
<div id="add-cat-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(0,0,0,0.5)">
    <div class="bg-white rounded-2xl shadow-elevated w-full max-w-md p-7">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-display text-xl font-semibold text-neutral-900">Add Category</h3>
            <button onclick="document.getElementById('add-cat-modal').classList.add('hidden')" class="w-8 h-8 rounded-lg hover:bg-neutral-100 flex items-center justify-center text-neutral-500">✕</button>
        </div>
        <div class="space-y-4">
            <div><label class="form-label">Category Name</label><input type="text" class="form-input" placeholder="Centrepieces" /></div>
            <div><label class="form-label">Icon / Emoji</label><input type="text" class="form-input" placeholder="🌸" maxlength="2" /></div>
            <div><label class="form-label">Description</label><textarea class="form-input resize-none" rows="3" placeholder="Category description..."></textarea></div>
        </div>
        <div class="flex gap-3 mt-6">
            <button onclick="document.getElementById('add-cat-modal').classList.add('hidden')" class="btn btn-ghost flex-1">Cancel</button>
            <button class="btn btn-primary flex-1">Save</button>
        </div>
    </div>
</div>

@endsection
