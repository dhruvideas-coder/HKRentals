<div class="flex items-center gap-3">
    <div class="relative">
        <img :src="item.image" :alt="item.name" class="w-11 h-11 rounded-lg object-cover" />
        <span class="absolute -top-1 -right-1 w-4 h-4 bg-brand-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center" x-text="item.qty"></span>
    </div>
    <p class="flex-1 text-sm font-medium text-neutral-700 truncate" x-text="item.name"></p>
    <span class="text-sm font-semibold" x-text="'$'+(item.price*item.qty).toFixed(2)"></span>
</div>
