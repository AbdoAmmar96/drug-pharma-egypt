<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * GET /api/products
     * Optional query: ?category=child-neonates&search=vitamin&featured=1&per_page=20
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::query()
            ->active()
            ->with(['category:id,slug,name,icon', 'categories:id,slug,name,icon'])
            ->ordered();

        if ($category = $request->string('category')->toString()) {
            $query->where(function ($q) use ($category) {
                $q->whereHas('category', fn ($c) => $c->where('slug', $category))
                  ->orWhereHas('categories', fn ($c) => $c->where('categories.slug', $category));
            });
        }

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('composition', 'like', "%{$search}%");
            });
        }

        if ($request->boolean('featured')) {
            $query->featured();
        }

        $perPage = (int) $request->input('per_page', 50);
        $perPage = min(max($perPage, 1), 100);

        $products = $query->paginate($perPage);

        return response()->json($products);
    }

    /**
     * GET /api/products/featured
     * Quick endpoint for the home page featured strip.
     */
    public function featured(): JsonResponse
    {
        $products = Product::query()
            ->active()
            ->featured()
            ->with(['category:id,slug,name,icon', 'categories:id,slug,name,icon'])
            ->ordered()
            ->limit(8)
            ->get();

        return response()->json([
            'data' => $products,
        ]);
    }

    /**
     * GET /api/products/{slug}
     * Single product detail.
     */
    public function show(Product $product): JsonResponse
    {
        if (!$product->is_active) {
            abort(404);
        }

        $product->load(['category:id,slug,name,icon', 'categories:id,slug,name,icon']);

        // Related products in the same primary category OR sharing any category
        $categoryIds = $product->categories->pluck('id')->push($product->category_id)->unique()->all();
        $related = Product::query()
            ->active()
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($product, $categoryIds) {
                $q->whereIn('category_id', $categoryIds)
                  ->orWhereHas('categories', fn ($c) => $c->whereIn('categories.id', $categoryIds));
            })
            ->with(['category:id,slug,name,icon', 'categories:id,slug,name,icon'])
            ->ordered()
            ->limit(4)
            ->get();

        return response()->json([
            'data' => $product,
            'related' => $related,
        ]);
    }
}
