<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'supplier')->paginate(10);
        return response()->json($products, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_min' => 'required|integer|min:0',
            'image_path' => 'nullable|string',
        ]);

        $product = Product::create($validated);

        return response()->json(['message' => 'Producto creado con éxito', 'data' => $product], 201);
    }

    public function show(Product $product)
    {
        return response()->json($product->load('category', 'supplier'), 200);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_min' => 'required|integer|min:0',
            'image_path' => 'nullable|string',
        ]);

        $product->update($validated);

        return response()->json(['message' => 'Producto actualizado con éxito', 'data' => $product], 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Producto eliminado con éxito'], 200);
    }
}

