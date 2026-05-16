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

    public function index()
    {
        try {
            return view('pages.cart', [
                'cart'  => $this->cartService->getCart(),
                'total' => $this->cartService->getTotal(),
                'count' => $this->cartService->getCount(),
            ]);
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return view('pages.cart', ['cart' => [], 'total' => 0, 'count' => 0, 'error' => 'Could not load cart.']);
        }
    }

    public function data()
    {
        try {
            return $this->jsonResponse('Cart data retrieved');
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return response()->json(['success' => false, 'message' => 'Could not retrieve cart data.'], 500);
        }
    }

    public function add(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required',
                'name'       => 'required|string',
                'price'      => 'required|numeric',
                'quantity'   => 'nullable|integer|min:1',
                'image'      => 'nullable|string',
                'category'   => 'nullable|string',
                'dateRange'  => 'nullable|string',
            ]);

            $product = \App\Models\Product::find($validated['product_id']);
            if ($product) {
                $currentQty = $this->cartService->getCart()[$validated['product_id']]['quantity'] ?? 0;
                $addQty = $validated['quantity'] ?? 1;
                if ($currentQty + $addQty > $product->total_quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => "Only {$product->total_quantity} in stock for \"{$product->name}\". You already have {$currentQty} in your cart.",
                    ], 422);
                }
            }

            $this->cartService->addItem($validated, $validated['quantity'] ?? 1);

            return $this->jsonResponse('Item added to cart');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return response()->json(['success' => false, 'message' => 'Could not add item to cart.'], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required',
                'quantity'   => 'required|integer|min:0',
            ]);

            if ($request->quantity > 0) {
                $product = \App\Models\Product::find($request->product_id);
                if ($product && $request->quantity > $product->total_quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => "Only {$product->total_quantity} in stock for \"{$product->name}\".",
                    ], 422);
                }
            }

            $this->cartService->updateItem($request->product_id, $request->quantity);

            return $this->jsonResponse('Cart updated');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return response()->json(['success' => false, 'message' => 'Could not update cart.'], 500);
        }
    }

    public function remove(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required',
            ]);

            $this->cartService->removeItem($request->product_id);

            return $this->jsonResponse('Item removed from cart');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return response()->json(['success' => false, 'message' => 'Could not remove item from cart.'], 500);
        }
    }

    public function clear(Request $request)
    {
        try {
            $this->cartService->clearCart();
            return $this->jsonResponse('Cart cleared');
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return response()->json(['success' => false, 'message' => 'Could not clear cart.'], 500);
        }
    }

    private function jsonResponse(string $message)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'cart'    => array_values($this->cartService->getCart()),
            'total'   => $this->cartService->getTotal(),
            'count'   => $this->cartService->getCount(),
        ]);
    }
}
