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
            ->with('category:id,slug,name,icon')
            ->ordered();

        if ($category = $request->string('category')->toString()) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
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
            ->with('category:id,slug,name,icon')
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

        $product->load('category:id,slug,name,icon');

        // Related products in the same category
        $related = Product::query()
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('category:id,slug,name,icon')
            ->ordered()
            ->limit(4)
            ->get();

        return response()->json([
            'data' => $product,
            'related' => $related,
        ]);
    }
}
