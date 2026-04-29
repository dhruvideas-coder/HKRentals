<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Show the cart page.
     */
    public function index()
    {
        return view('pages.cart', [
            'cart' => $this->cartService->getCart(),
            'total' => $this->cartService->getTotal(),
            'count' => $this->cartService->getCount()
        ]);
    }

    /**
     * Get the cart data as JSON.
     */
    public function data()
    {
        return $this->jsonResponse('Cart data retrieved');
    }

    /**
     * Add item to the cart (AJAX).
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|string',
            'name'       => 'required|string',
            'price'      => 'required|numeric',
            'quantity'   => 'nullable|integer|min:1',
            'image'      => 'nullable|string',
            'category'   => 'nullable|string',
            'dateRange'  => 'nullable|string',
        ]);

        $quantity = $validated['quantity'] ?? 1;

        $this->cartService->addItem($validated, $quantity);

        return $this->jsonResponse('Item added to cart');
    }

    /**
     * Update item quantity in the cart (AJAX).
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|string',
            'quantity'   => 'required|integer|min:0',
        ]);

        $this->cartService->updateItem($request->product_id, $request->quantity);

        return $this->jsonResponse('Cart updated');
    }

    /**
     * Remove item from the cart (AJAX).
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|string',
        ]);

        $this->cartService->removeItem($request->product_id);

        return $this->jsonResponse('Item removed from cart');
    }

    /**
     * Clear the cart (AJAX).
     */
    public function clear(Request $request)
    {
        $this->cartService->clearCart();

        return $this->jsonResponse('Cart cleared');
    }

    /**
     * Helper to return consistent JSON state.
     */
    private function jsonResponse(string $message)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'cart'    => array_values($this->cartService->getCart()), // Re-index array for JSON
            'total'   => $this->cartService->getTotal(),
            'count'   => $this->cartService->getCount(),
        ]);
    }
}
