<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $category = new Category;
        $category->category = $request->category;
        $category->parent = $request->parent;
        $category->user_id = Auth::id();
        $category->save();
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // return $request->all();
        $category = Category::find($request->id);
        $category->category = $request->category;
        $category->save();
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Category::where('id', $category->id)->delete();
    }

    public function getCategories()
    {
        return Category::with(['subcats'])->get();
        // $answers = Answer::with(['user'])->get();
        /* $category = DB::table('categories')
            ->leftJoin('subcats', 'categories.id', '=', 'subcats.category_id')
            ->get();
        return $category;*/
    }
    public function getsubcat()
    {
        return Category::where('parent', '!=', 0)->get();
    }
}
