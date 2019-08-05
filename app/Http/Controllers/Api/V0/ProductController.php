<?php

namespace App\Http\Controllers\Api\V0;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Validation rules for product
     *
     * @var array $rules
     *
     */
    private $rules = [
        'name' => 'required|string|min:4',
        'description' => 'string',
        'categories' => 'array',
        'categories.*' => 'integer|exists:categories,id',
    ];

    /**
     * Get all products
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function index()
    {
        try {
            $products = Product::with('categories')->get();
            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response(['message' => 'Get error', 'errors' => [$e->getMessage()]], 422);
        }
    }

    /**
     * Get one product with categories
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function show(int $id)
    {
        try {
            $product = Product::with('categories')->findOrFail($id);
            return response()->json($product, 200);
        } catch (\Exception $e) {
            return response(['message' => 'Show error', 'errors' => [$e->getMessage()]], 422);
        }
    }

    /**
     * Create product
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $name = $request->name;
        $description = $request->description;
        $categories = $request->categories;
        try {
            $product = Product::create(
                [
                    'name' => $name,
                    'description' => $description,
                ]
            );
            if ($categories) {
                $product->categories()->attach($categories);
            }
            return response()->json(['ok'], 200);
        } catch (\Exception $e) {
            return response(['message' => 'Create error', 'errors' => [$e->getMessage()]], 422);
        }
    }

    /**
     * Update product
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function update(Request $request, int $id)
    {
        $this->validate($request, $this->rules);
        try {
            $product = Product::findOrFail($id);
            $categories = $request->categories;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->categories()->detach();
            if ($categories) {
                $product->categories()->attach($categories);
            }
            $product->save();
            return response()->json(['ok'], 200);
        } catch (\Exception $e) {
            return response(['message' => 'Update error', 'errors' => [$e->getMessage()]], 422);
        }
    }

    /**
     * Delete product
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function destroy(int $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return response()->json(['ok'], 200);
        } catch (\Exception $e) {
            return response(['message' => 'Delete error', 'errors' => [$e->getMessage()]], 422);
        }
    }
}