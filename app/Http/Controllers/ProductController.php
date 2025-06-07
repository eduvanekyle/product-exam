<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = File::json(public_path('products.json'));

        return view('pages.products', ['products' => $products]);
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
}
