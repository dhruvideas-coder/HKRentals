@extends('layouts.app')

@section('title', 'Order Confirmed!')
@section('meta_description', 'Your SK Rentals order has been confirmed. Thank you for booking with us!')

@section('content')

<section class="py-20 bg-cream min-h-screen flex items-center" aria-label="Order success"
         x-data x-init="Alpine.store('cart').clear()">
<div class="container-sk max-w-2xl text-center">

    {{-- Success Icon --}}
    <div class="relative inline-flex items-center justify-center mb-8">
        <div class="w-28 h-28 rounded-full bg-green-100 flex items-center justify-center shadow-lg">
            <svg class="w-14 h-14 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        {{-- Confetti dots --}}
        <span class="absolute -top-3 -left-3 w-3 h-3 rounded-full bg-brand-400 opacity-70"></span>
        <span class="absolute -top-2 right-0 w-2 h-2 rounded-full bg-pink-400 opacity-70"></span>
        <span class="absolute bottom-0 -right-4 w-4 h-4 rounded-full bg-sky-400 opacity-60"></span>
        <span class="absolute -bottom-2 left-1 w-2 h-2 rounded-full bg-amber-400 opacity-80"></span>
    </div>

    {{-- Heading --}}
    <span class="badge badge-gold mb-4">Booking Confirmed 🎉</span>
    <h1 class="font-display text-4xl sm:text-5xl font-bold text-neutral-900 mb-4 leading-tight">
        Thank You for<br/>
        <span class="text-gradient-gold">Choosing SK Rentals!</span>
    </h1>
    <p class="text-neutral-500 text-lg mb-10 max-w-md mx-auto leading-relaxed">
        Your order has been received and is being processed. You'll receive a confirmation email shortly with all the details.
    </p>

    {{-- Order Summary Card --}}
    <div class="card p-7 mb-8 text-left">
        <h2 class="font-display text-xl font-semibold text-neutral-900 mb-5 text-center">Order Details</h2>

        <div class="grid sm:grid-cols-2 gap-4 mb-6">
            @foreach([['Order Number','#SKR-'.(rand(10000,99999))],['Date',now()->format('F j, Y')],['Status','Processing'],['Delivery','Free White-Glove']] as [$label,$val])
            <div class="bg-neutral-50 rounded-xl p-4 border border-neutral-100">
                <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-1">{{ $label }}</p>
                <p class="font-semibold text-neutral-800 @if($label==='Status') text-amber-600 @endif">{{ $val }}</p>
            </div>
            @endforeach
        </div>

        {{-- What happens next --}}
        <div class="space-y-3">
            <p class="text-sm font-semibold text-neutral-700 mb-2">What happens next?</p>
            @foreach([
                ['📧','Confirmation email','You\'ll receive an email within a few minutes with full order details.'],
                ['📞','We\'ll call you','Our team will reach out 48 hours before delivery to confirm the schedule.'],
                ['🚚','Delivery & Setup','We handle delivery and professional setup on your event day.'],
                ['✨','Pickup','After your event, we\'ll collect everything. You don\'t lift a finger!'],
            ] as [$icon, $title, $desc])
            <div class="flex items-start gap-3">
                <span class="text-xl flex-shrink-0 mt-0.5">{{ $icon }}</span>
                <div>
                    <p class="text-sm font-semibold text-neutral-700">{{ $title }}</p>
                    <p class="text-xs text-neutral-400 mt-0.5">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- CTA Buttons --}}
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <a href="{{ route('home') }}" class="btn btn-primary btn-lg shadow-glow w-full sm:w-auto">
            Return to Home
        </a>
        <a href="{{ route('products') }}" class="btn btn-outline btn-lg w-full sm:w-auto">
            Continue Browsing
        </a>
    </div>

    {{-- Social share nudge --}}
    <p class="text-sm text-neutral-400 mt-10">
        Share your special day with us!
        <a href="#" class="text-brand-600 hover:text-brand-700 font-medium ml-1">#SKRentals</a>
    </p>

</div>
</section>

@endsection
