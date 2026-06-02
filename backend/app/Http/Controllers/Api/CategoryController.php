<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * GET /api/categories
     * Returns all active categories with product counts.
     */
    public function index(): JsonResponse
    {
        $categories = Category::query()
            ->active()
            ->ordered()
            ->get(['id', 'slug', 'name', 'description', 'icon', 'sort_order']);

        $categories->each(function (Category $category) {
            $primaryIds = Product::query()
                ->where('category_id', $category->id)
                ->where('is_active', true)
                ->pluck('id');
            $pivotIds = $category->activeProducts()->pluck('products.id');
            $category->products_count = $primaryIds->merge($pivotIds)->unique()->count();
        });

        return response()->json([
            'data' => $categories,
        ]);
    }

    /**
     * GET /api/categories/{slug}
     * Single category with its products.
     */
    public function show(Category $category): JsonResponse
    {
        if (!$category->is_active) {
            abort(404);
        }

        // Combine primary (category_id) and pivot products, deduped
        $primary = Product::query()
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->with('category:id,slug,name,icon')
            ->ordered()
            ->get();
        $pivot = $category->activeProducts()
            ->with('category:id,slug,name,icon')
            ->get();

        $products = $primary->concat($pivot)->unique('id')->sortBy([
            ['sort_order', 'asc'],
            ['name', 'asc'],
        ])->values();

        $data = $category->toArray();
        $data['active_products'] = $products;

        return response()->json([
            'data' => $data,
        ]);
    }
}
