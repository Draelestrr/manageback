<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('products', 'customer', 'user')->paginate(10);
        return response()->json($sales, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $sale = Sale::create([
            'user_id' => auth()->id(),
            'customer_id' => $validated['customer_id'],
            'total' => collect($validated['products'])->sum(fn($p) => $p['quantity'] * $p['unit_price']),
        ]);

        foreach ($validated['products'] as $product) {
            $sale->products()->attach($product['product_id'], [
                'quantity' => $product['quantity'],
                'unit_price' => $product['unit_price'],
                'subtotal' => $product['quantity'] * $product['unit_price'],
            ]);
        }

        return response()->json(['message' => 'Venta registrada con éxito', 'data' => $sale], 201);
    }
}

