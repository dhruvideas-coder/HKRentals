<div class="card p-5">
    <h3 class="font-semibold text-neutral-900 mb-4">Your Order</h3>
    <div class="space-y-3">
        <template x-for="item in $store.cart.items" :key="item.product_id || item.id">
            <x-cart.item />
        </template>
    </div>
    <div class="border-t border-neutral-100 mt-4 pt-4 flex justify-between">
        <span class="text-sm text-neutral-500">Subtotal</span>
        <span class="font-bold text-neutral-900" x-text="'$'+$store.cart.subtotal()"></span>
    </div>
</div>
<div class="card p-5 space-y-3 mt-4">
    @foreach([['🔒','Secure Checkout','SSL encrypted'],['🚚','Free Delivery','Orders over $200'],['🔄','Free Changes','Up to 48 hrs before']] as [$icon,$t,$s])
    <div class="flex items-center gap-3">
        <span class="text-xl">{{ $icon }}</span>
        <div><p class="text-sm font-semibold text-neutral-700">{{ $t }}</p><p class="text-xs text-neutral-400">{{ $s }}</p></div>
    </div>
    @endforeach
</div>
