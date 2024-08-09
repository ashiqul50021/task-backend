<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->latest()->get();
        return response()->json($products);
    }




    public function search(Request $request)
    {
        $searchTerm = $request->query('q');

        if (!$searchTerm) {
            return response()->json(['error' => 'No search term provided'], 400);
        }
        $products = Product::search($searchTerm)->paginate(10);

        return response()->json($products);
    }
}
