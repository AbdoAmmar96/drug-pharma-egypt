<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
            ->withCount(['activeProducts as products_count'])
            ->get(['id', 'slug', 'name', 'description', 'icon', 'sort_order']);

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

        $category->load(['activeProducts' => fn ($q) => $q->ordered()]);

        return response()->json([
            'data' => $category,
        ]);
    }
}
