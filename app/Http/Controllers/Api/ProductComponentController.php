<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductComponent\StoreProductComponentRequest;
use App\Http\Requests\Api\ProductComponent\UpdateProductComponentRequest;
use App\Models\Inventory\Product;
use App\Models\Inventory\ProductComponent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @tags Product Components
 */
class ProductComponentController extends Controller
{
    /**
     * List components for a product.
     *
     * @param  Request  $request  The incoming HTTP request
     * @param  Product  $product  The parent product (kit or assembly)
     */
    public function index(Request $request, Product $product): JsonResponse
    {
        if ($product->organization_id !== $request->user()->organization_id) {
            return response()->json([
                'message' => 'Product not found',
                'error' => 'not_found',
            ], 404);
        }

        if (! in_array($product->type, ['kit', 'assembly'])) {
            return response()->json([
                'message' => 'Only kit and assembly products can have components.',
                'error' => 'invalid_product_type',
            ], 422);
        }

        $components = $product->components()
            ->with('componentProduct:id,name,sku,stock,price,thumbnail')
            ->ordered()
            ->get();

        return response()->json([
            'data' => $components,
        ]);
    }

    /**
     * Add a component to a product.
     *
     * @param  Request  $request  The incoming HTTP request
     * @param  Product  $product  The parent product (kit or assembly)
     */
    public function store(StoreProductComponentRequest $request, Product $product): JsonResponse
    {
        if ($product->organization_id !== $request->user()->organization_id) {
            return response()->json([
                'message' => 'Product not found',
                'error' => 'not_found',
            ], 404);
        }

        if (! in_array($product->type, ['kit', 'assembly'])) {
            return response()->json([
                'message' => 'Only kit and assembly products can have components.',
                'error' => 'invalid_product_type',
            ], 422);
        }

        $validated = $request->validated();

        // Check for circular reference
        if ($this->wouldCreateCircularReference($product->id, (int) $validated['component_product_id'])) {
            return response()->json([
                'message' => 'Adding this component would create a circular reference.',
                'error' => 'circular_reference',
            ], 422);
        }

        $maxSortOrder = $product->components()->max('sort_order') ?? -1;

        $component = ProductComponent::create([
            'parent_product_id' => $product->id,
            'component_product_id' => $validated['component_product_id'],
            'quantity' => $validated['quantity'],
            'sort_order' => $maxSortOrder + 1,
            'notes' => $validated['notes'] ?? null,
        ]);

        $component->load('componentProduct:id,name,sku,stock,price,thumbnail');

        return response()->json([
            'message' => 'Component added successfully',
            'data' => $component,
        ], 201);
    }

    /**
     * Update a component's quantity or notes.
     *
     * @param  Request  $request  The incoming HTTP request
     * @param  Product  $product  The parent product (kit or assembly)
     * @param  ProductComponent  $component  The component to update
     */
    public function update(UpdateProductComponentRequest $request, Product $product, ProductComponent $component): JsonResponse
    {
        if ($product->organization_id !== $request->user()->organization_id) {
            return response()->json([
                'message' => 'Product not found',
                'error' => 'not_found',
            ], 404);
        }

        if ($component->parent_product_id !== $product->id) {
            return response()->json([
                'message' => 'Component not found for this product',
                'error' => 'not_found',
            ], 404);
        }

        $validated = $request->validated();

        $component->update($validated);
        $component->load('componentProduct:id,name,sku,stock,price,thumbnail');

        return response()->json([
            'message' => 'Component updated successfully',
            'data' => $component,
        ]);
    }

    /**
     * Remove a component from a product.
     *
     * @param  Request  $request  The incoming HTTP request
     * @param  Product  $product  The parent product (kit or assembly)
     * @param  ProductComponent  $component  The component to remove
     */
    public function destroy(Request $request, Product $product, ProductComponent $component): JsonResponse
    {
        if ($product->organization_id !== $request->user()->organization_id) {
            return response()->json([
                'message' => 'Product not found',
                'error' => 'not_found',
            ], 404);
        }

        if ($component->parent_product_id !== $product->id) {
            return response()->json([
                'message' => 'Component not found for this product',
                'error' => 'not_found',
            ], 404);
        }

        $component->delete();

        return response()->json([
            'message' => 'Component removed successfully',
        ]);
    }

    /**
     * Check if adding a component would create a circular reference.
     *
     * @param  int  $parentId  The parent product ID
     * @param  int  $componentId  The component product ID to add
     * @param  array  $visited  Previously visited product IDs (for recursion)
     */
    private function wouldCreateCircularReference(int $parentId, int $componentId): bool
    {
        $componentProduct = Product::find($componentId);

        if (! $componentProduct || ! in_array($componentProduct->type, ['kit', 'assembly'])) {
            return false;
        }

        $visited = [$parentId];
        $queue = [$componentId];

        while (! empty($queue)) {
            $subComponents = ProductComponent::whereIn('parent_product_id', $queue)
                ->pluck('component_product_id')
                ->toArray();

            if (empty($subComponents)) {
                break;
            }

            if (in_array($parentId, $subComponents)) {
                return true;
            }

            $queue = [];
            foreach ($subComponents as $subId) {
                if (in_array($subId, $visited)) {
                    return true;
                }
                $visited[] = $subId;
                $queue[] = $subId;
            }
        }

        return false;
    }
}
