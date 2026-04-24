import './bootstrap';
import Alpine from 'alpinejs';

// ── Cart Store ─────────────────────────────────────────────────
Alpine.store('cart', {
    items: JSON.parse(localStorage.getItem('sk_cart') || '[]'),

    _save() {
        localStorage.setItem('sk_cart', JSON.stringify(this.items));
    },

    add(product) {
        const existing = this.items.find(i => i.id === product.id);
        if (existing) {
            existing.qty += 1;
        } else {
            this.items.push({ ...product, qty: 1 });
        }
        this._save();
    },

    remove(index) {
        this.items.splice(index, 1);
        this._save();
    },

    inc(index) {
        this.items[index].qty += 1;
        this._save();
    },

    dec(index) {
        if (this.items[index].qty > 1) {
            this.items[index].qty -= 1;
        } else {
            this.items.splice(index, 1);
        }
        this._save();
    },

    clear() {
        this.items = [];
        this._save();
    },

    count() {
        return this.items.reduce((sum, i) => sum + i.qty, 0);
    },

    subtotal() {
        return this.items.reduce((sum, i) => sum + i.price * i.qty, 0).toFixed(2);
    },
});

// ── Initialize Alpine.js globally ──────────────────────────────
window.Alpine = Alpine;
Alpine.start();

