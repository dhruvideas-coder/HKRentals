@extends('layouts.app')

@section('title', '404 — Page Not Found')
@section('meta_description', 'The page you are looking for could not be found.')

@section('content')

<section class="min-h-[85vh] flex items-center justify-center py-20 bg-cream" aria-label="404 not found">
<div class="container-sk max-w-2xl text-center">

    {{-- Large 404 --}}
    <div class="relative mb-8 select-none">
        <p class="font-display text-[9rem] sm:text-[12rem] font-bold leading-none"
           style="background:linear-gradient(135deg, var(--color-neutral-100) 0%, var(--color-neutral-200) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
            404
        </p>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="w-24 h-24 rounded-full bg-brand-50 border-4 border-brand-100 flex items-center justify-center shadow-lg">
                <span class="text-4xl">🔍</span>
            </div>
        </div>
    </div>

    <span class="badge badge-gold mb-4">Page Not Found</span>
    <h1 class="font-display text-3xl sm:text-4xl font-bold text-neutral-900 mb-4">
        Oops! This page has<br/>
        <span class="text-gradient-gold">wandered off…</span>
    </h1>
    <p class="text-neutral-500 text-lg mb-10 max-w-md mx-auto leading-relaxed">
        The page you're looking for doesn't exist or has been moved.
        Let's get you back to exploring our beautiful rental collection.
    </p>

    {{-- Quick links --}}
    <div class="grid sm:grid-cols-3 gap-4 mb-10">
        @foreach([
            [route('home'),    '🏠', 'Home',     'Start from the beginning'],
            [route('products'),'💐', 'Browse',   'Explore our collection'],
            [route('contact'), '💬', 'Contact',  'Get help from our team'],
        ] as [$href, $icon, $title, $desc])
        <a href="{{ $href }}" class="card p-5 hover-lift text-left hover:border-brand-200 transition-all duration-200">
            <span class="text-2xl mb-2 block">{{ $icon }}</span>
            <p class="font-semibold text-neutral-800 text-sm">{{ $title }}</p>
            <p class="text-xs text-neutral-400 mt-0.5">{{ $desc }}</p>
        </a>
        @endforeach
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <a href="{{ route('home') }}" class="btn btn-primary btn-lg shadow-glow w-full sm:w-auto">
            ← Back to Home
        </a>
        <a href="{{ route('products') }}" class="btn btn-outline btn-lg w-full sm:w-auto">
            Browse Collection
        </a>
    </div>

</div>
</section>

@endsection
