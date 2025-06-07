<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = File::json(public_path('products.json'));

        return view('pages.products', ['products' => $products ?? []]);
    }

    public function store(ProductStoreRequest $request)
    {
        $products = File::json(public_path('products.json'));

        $id = isset($products) ? count($products) + 1 : 1;

        $data = $request->only('name', 'quantity', 'price');
        $data['id'] = $id;
        $data['created_at'] = now()->toDateTimeString();

        $products[] = $data;

        File::put(public_path('products.json'), json_encode($products));

        return response()->json([
            'message' => 'Product created successfully.',
            'product' => $data,
        ]);
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $products = File::json(public_path('products.json'));

        $product = collect($products)->firstWhere('id', $id);

        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        $data = $request->only('name', 'quantity', 'price');

        $index = array_search($product, $products);
        $products[$index] = array_merge($product, $data);

        if ($product['name'] == $data['name'] && $product['quantity'] == $data['quantity'] && $product['price'] == $data['price']) {
            return response()->json(['message' => 'No changes made.'], 422);
        }

        File::put(public_path('products.json'), json_encode($products));

        return response()->json([
            'message' => 'Product updated successfully.',
            'product' => $products[$index],
            'key' => $index
        ]);
    }
}
