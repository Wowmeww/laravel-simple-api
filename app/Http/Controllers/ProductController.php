<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    // List all products
    public function index()
    {
        return response()->json([
            'products' => Product::all()
        ]);
    }

    // Create a new product
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'        => 'required|string|max:255',
                'description' => 'nullable|string',
                'price'       => 'required|numeric|min:0',
                'stock'       => 'required|integer|min:0',
                'category'    => 'nullable|string|max:255',
                'active'      => 'boolean',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);
        }

        $validated['id'] = Str::uuid();
        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    // Show a single product
    public function show(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json([
            'message' => 'Product retrieved successfully',
            'product' => $product
        ]);
    }

    // Update a product
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if (empty($request->all())) {
            return response()->json([
                'message' => 'No data provided in the request',
                'errors' => ['request' => ['You must provide at least one field to update.']]
            ], 400);
        }

        try {
            $validated = $request->validate([
                'name'        => 'sometimes|required|string|max:255',
                'description' => 'sometimes|nullable|string',
                'price'       => 'sometimes|required|numeric|min:0',
                'stock'       => 'sometimes|required|integer|min:0',
                'category'    => 'sometimes|nullable|string|max:255',
                'active'      => 'sometimes|boolean',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);
        }

        $product->update($validated);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

    // Delete a product
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
