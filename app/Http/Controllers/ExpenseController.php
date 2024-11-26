<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Product;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('products')->paginate(10);
        return response()->json($expenses, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'products' => 'nullable|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'extra_charges' => 'nullable|array',
            'extra_charges.*.description' => 'required|string|max:255',
            'extra_charges.*.amount' => 'required|numeric|min:0',
            'receipt_image_path' => 'nullable|string',
        ]);

        // Crear el gasto principal
        $expense = Expense::create([
            'description' => $validated['description'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'user_id' => auth()->id(),
            'receipt_image_path' => $validated['receipt_image_path'],
        ]);

        // Procesar productos (traspasos internos)
        if (!empty($validated['products'])) {
            foreach ($validated['products'] as $product) {
                $productModel = Product::find($product['product_id']);
                $expense->products()->attach($productModel, [
                    'quantity' => $product['quantity'],
                    'purchase_price' => $productModel->purchase_price,
                    'subtotal' => $product['quantity'] * $productModel->purchase_price,
                ]);
            }
        }

        // Procesar cargos adicionales (gastos generales no registrados como productos)
        if (!empty($validated['extra_charges'])) {
            foreach ($validated['extra_charges'] as $charge) {
                $expense->extraCharges()->create([
                    'description' => $charge['description'],
                    'amount' => $charge['amount'],
                ]);
            }
        }

        return response()->json(['message' => 'Gasto registrado con éxito', 'data' => $expense->load('products', 'extraCharges')], 201);
    }

    public function searchProducts(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|string|max:255',
        ]);

        $products = Product::select('id', 'name', 'purchase_price') // Selecciona solo los campos necesarios
            ->where('name', 'like', '%' . $validated['query'] . '%')
            ->get();

        return response()->json($products, 200);
    }
}

