<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class CartService
{
    private string $sessionKey = 'cart';

    /**
     * Add item to the cart.
     */
    public function addItem($product, $quantity = 1): void
    {
        $cart = $this->getCart();

        if (isset($cart[$product['product_id']])) {
            $cart[$product['product_id']]['quantity'] += $quantity;
        } else {
            $cart[$product['product_id']] = [
                'product_id' => $product['product_id'],
                'name'       => $product['name'],
                'price'      => $product['price'],
                'quantity'   => $quantity,
                'image'      => $product['image'],
                'category'   => $product['category'] ?? '',
                'dateRange'  => $product['dateRange'] ?? '',
            ];
        }

        Session::put($this->sessionKey, $cart);
    }

    /**
     * Update item quantity in the cart.
     */
    public function updateItem($productId, $quantity): void
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            if ($quantity > 0) {
                $cart[$productId]['quantity'] = $quantity;
            } else {
                unset($cart[$productId]);
            }
            Session::put($this->sessionKey, $cart);
        }
    }

    /**
     * Remove item from the cart.
     */
    public function removeItem($productId): void
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put($this->sessionKey, $cart);
        }
    }

    /**
     * Clear the cart.
     */
    public function clearCart(): void
    {
        Session::forget($this->sessionKey);
    }

    /**
     * Get all items in the cart.
     */
    public function getCart(): array
    {
        return Session::get($this->sessionKey, []);
    }

    /**
     * Get the total price of the cart.
     */
    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getCart() as $item) {
            $days = $this->calculateDays($item['dateRange'] ?? null);
            $total += $item['price'] * $item['quantity'] * $days;
        }
        return (float) $total;
    }

    /**
     * Calculate days from dateRange.
     */
    private function calculateDays(?string $dateRange): int
    {
        if (!$dateRange) return 1;
        
        $parts = explode(' → ', $dateRange);
        if (count($parts) !== 2) return 1;

        $start = strtotime($parts[0]);
        $end = strtotime($parts[1]);

        if (!$start || !$end) return 1;

        $diff = $end - $start;
        $days = (int) ceil($diff / (60 * 60 * 24));
        
        return $days > 0 ? $days : 1;
    }

    /**
     * Get total quantity of items in the cart.
     */
    public function getCount(): int
    {
        $count = 0;
        foreach ($this->getCart() as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
}
