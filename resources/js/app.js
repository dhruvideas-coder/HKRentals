import './bootstrap';
import Alpine from 'alpinejs';

// ── US phone formatter: formats to (XXX) XXX-XXXX, max 10 digits ──────────────
window.formatUSPhone = function (input) {
    let digits = (typeof input === 'string' ? input : input.value).replace(/\D/g, '');
    if (digits.startsWith('1')) digits = digits.slice(1);
    digits = digits.slice(0, 10);
    let formatted = '';
    if (digits.length === 0)       formatted = '';
    else if (digits.length <= 3)   formatted = '(' + digits;
    else if (digits.length <= 6)   formatted = '(' + digits.slice(0, 3) + ') ' + digits.slice(3);
    else                           formatted = '(' + digits.slice(0, 3) + ') ' + digits.slice(3, 6) + '-' + digits.slice(6);
    if (typeof input !== 'string') input.value = formatted;
    return formatted;
};

// ── Shared rental day helper (mirrors App\Helpers\RentalHelper::calculateDays) ─
// 24 hours = 1 day. Minimum 2 days. Any period < 48 h still charges 2 days.
window.calcRentalDays = function (start, end) {
    if (!start || !end) return 2;
    const s = new Date(start);
    const e = new Date(end);
    if (isNaN(s) || isNaN(e)) return 2;
    const diffSeconds = Math.max(0, (e - s) / 1000);
    return Math.max(2, Math.round(diffSeconds / 86400));
};

// ── Cart Store ─────────────────────────────────────────────────
const PICKUP_KEY = 'skr_cart_is_pickup';

Alpine.store('cart', {
    items: [],
    isPickup: false,

    init() {
        // Restore pickup preference across page reloads
        const saved = localStorage.getItem(PICKUP_KEY);
        if (saved !== null) {
            this.isPickup = saved === 'true';
        }

        // Persist any future changes to localStorage
        Alpine.effect(() => {
            localStorage.setItem(PICKUP_KEY, this.isPickup);
        });

        this.fetchCart();
    },

    async fetchCart() {
        try {
            const response = await axios.get('/cart/data', {
                headers: { 'Accept': 'application/json' }
            });
            if (response.data && response.data.cart) {
                this.items = response.data.cart;
            }
        } catch (error) {
            console.error('Error fetching cart:', error);
        }
    },

    async add(product) {
        try {
            // product must have product_id, name, price, quantity, etc.
            const payload = {
                product_id: product.id !== undefined ? product.id : product.product_id,
                name: product.name,
                price: product.price,
                quantity: product.quantity || product.qty || 1,
                image: product.image,
                category: product.category,
                dateRange: product.dateRange
            };
            const response = await axios.post('/cart/add', payload);
            this.items = response.data.cart;
            // dispatch event to open drawer
            window.dispatchEvent(new CustomEvent('open-cart'));
        } catch (error) {
            console.error('Error adding to cart:', error);
        }
    },

    async updateQuantity(productId, quantity) {
        try {
            const response = await axios.post('/cart/update', {
                product_id: productId,
                quantity: quantity
            });
            this.items = response.data.cart;
        } catch (error) {
            console.error('Error updating cart:', error);
        }
    },

    async remove(productId) {
        try {
            const response = await axios.post('/cart/remove', {
                product_id: productId
            });
            this.items = response.data.cart;
        } catch (error) {
            console.error('Error removing from cart:', error);
        }
    },

    inc(productId) {
        const item = this.items.find(i => i.product_id == productId);
        if (item) {
            this.updateQuantity(productId, item.quantity + 1);
        }
    },

    dec(productId) {
        const item = this.items.find(i => i.product_id == productId);
        if (item && item.quantity > 1) {
            this.updateQuantity(productId, item.quantity - 1);
        } else {
            this.remove(productId);
        }
    },

    async clear() {
        try {
            const response = await axios.post('/cart/clear');
            this.items = [];
            this.isPickup = false;
        } catch (error) {
            console.error('Error clearing cart:', error);
        }
    },

    count() {
        return this.items.reduce((sum, i) => sum + parseInt(i.quantity), 0);
    },

    subtotal() {
        return this.items.reduce((sum, i) => {
            const days = this.calculateDays(i.dateRange);
            const multiplier = Math.max(1, days / 2);
            return sum + (parseFloat(i.price) * parseInt(i.quantity) * multiplier);
        }, 0).toFixed(2);
    },

    calculateDays(dateRange) {
        if (!dateRange) return 2;
        const parts = dateRange.split(' → ');
        if (parts.length !== 2) return 2;
        return window.calcRentalDays(parts[0], parts[1]);
    }
});

// ── Initialize Alpine.js globally ──────────────────────────────
window.Alpine = Alpine;
Alpine.start();
