<?php

namespace App\Http\Controllers;

use App\Models\StockEntry;
use Illuminate\Http\Request;

class StockEntryController extends Controller
{
    public function index()
    {
        $entries = StockEntry::with('product', 'user')->paginate(10);
        return response()->json($entries, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'purchase_price' => 'nullable|numeric|min:0',
            'receipt_image_path' => 'nullable|string',
        ]);

        $entry = StockEntry::create([
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'purchase_price' => $validated['purchase_price'],
            'user_id' => auth()->id(),
            'receipt_image_path' => $validated['receipt_image_path'],
        ]);

        return response()->json(['message' => 'Entrada de stock registrada', 'data' => $entry], 201);
    }
}


