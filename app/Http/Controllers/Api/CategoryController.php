<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $categories = Category::paginate(15);

        return CategoryResource::collection($categories)
            ->response()
            ->setStatusCode(200);
    }
}
