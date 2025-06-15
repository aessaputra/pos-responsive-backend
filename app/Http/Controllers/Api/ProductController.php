<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return ProductResource::collection($products)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
