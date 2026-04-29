import './bootstrap';
import Alpine from 'alpinejs';

// ── Cart Store ─────────────────────────────────────────────────
Alpine.store('cart', {
    items: [],
    
    init() {
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
                product_id: product.id || product.product_id,
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
        } catch (error) {
            console.error('Error clearing cart:', error);
        }
    },

    count() {
        return this.items.reduce((sum, i) => sum + parseInt(i.quantity), 0);
    },

    subtotal() {
        return this.items.reduce((sum, i) => sum + parseFloat(i.price) * parseInt(i.quantity), 0).toFixed(2);
    }
});

// ── Initialize Alpine.js globally ──────────────────────────────
window.Alpine = Alpine;
Alpine.start();

