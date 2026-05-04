<div class="flex items-center gap-3">
    <div class="relative">
        <img :src="item.image" :alt="item.name" class="w-11 h-11 rounded-lg object-cover" />
        <span class="absolute -top-1 -right-1 w-4 h-4 bg-brand-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center" x-text="(item.quantity || item.qty)"></span>
    </div>
    <div class="flex-1 min-w-0">
        <p class="text-sm font-semibold text-neutral-800 truncate" x-text="item.name"></p>
        <p class="text-xs text-neutral-400" x-text="Alpine.store('cart').calculateDays(item.dateRange) + ' Days'"></p>
    </div>
    <span class="text-sm font-semibold" x-text="'$'+(item.price*(item.quantity || item.qty)*Alpine.store('cart').calculateDays(item.dateRange)).toFixed(2)"></span>
</div>
