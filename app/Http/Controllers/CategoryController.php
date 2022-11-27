<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        if ($request->includeProducts == 1) {
            foreach ($categories as $category) {
                $category['products'] = $category->products;
            }
        }
        return $categories;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);
        $cat = new Category;
        $cat->name = $request->name;
        $cat->parent_id = $request->parent_id;
        $cat->save();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $category = Category::find($id);
        abort_unless($category, 404, 'Category not found');
        if ($request->includeProducts == 1) {
            $category['products'] = $category->products;
        }
        return $category;
    }

    public function showProducts(Request $request, $id)
    {
        $category = Category::find($id);
        abort_unless($category, 404, 'Category not found');
        $products = $category->products;
        if ($request->includeChildren == 1) {
            $subCategoriesProducts =  $category->subCategoriesProducts;
            $result = $products->merge($subCategoriesProducts);
        } else {
            $result = $products;
        }
        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);
        $cat = Category::find($id);
        abort_unless($cat, 404, 'Category not found');

        $cat->name = $request->name;
        $cat->parent_id = $request->parent_id;
        $cat->save();
    }

}
