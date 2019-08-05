<?php

namespace App\Http\Controllers\Api\V0;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Validation rules for category
     *
     * @var array $rules
     *
     */
    private $rules = [
        'name' => 'required|string'
    ];

    /**
     * Get all categories
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function index(Request $request)
    {
        try {
            $this->validate($request, ['hierarchy' => 'boolean']);
            $categories = Category::with('products')->get();
            if ($request->hierarchy) {
                $categories = array_values($categories->toHierarchy()->toArray());
            }
            return response()->json($categories, 200);
        } catch (\Exception $e) {
            return response(['message' => 'Get error', 'errors' => [$e->getMessage()]], 422);
        }
    }

    /**
     * Get one category with products
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function show(int $id)
    {
        try {
            $category = Category::with('products')->where('id', $id)->first();
            return response()->json($category, 200);
        } catch (\Exception $e) {
            return response(['message' => 'Show error', 'errors' => [$e->getMessage()]], 422);
        }
    }

    /**
     * Create category
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
        try {
            Category::create(
                [
                    'name' => $name
                ]
            );
            return response()->json(['ok'], 200);
        } catch (\Exception $e) {
            return response(['message' => 'Create error', 'errors' => [$e->getMessage()]], 422);
        }
    }

    /**
     * Update category
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
            $category = Category::findOrFail($id);
            $category->name = $request->name;
            $category->save();
            return response()->json(['ok'], 200);
        } catch (\Exception $e) {
            return response(['message' => 'Update error', 'errors' => [$e->getMessage()]], 422);
        }
    }

    /**
     * Delete category
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function destroy(int $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json(['ok'], 200);
        } catch (\Exception $e) {
            return response(['message' => 'Delete error', 'errors' => [$e->getMessage()]], 422);
        }
    }
}
