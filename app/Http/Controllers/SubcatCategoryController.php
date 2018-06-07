<?php

namespace App\Http\Controllers;

use App\Category_subcat;
use Illuminate\Http\Request;

class SubcatCategoryController extends Controller
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\category_subcat  $category_subcat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category_subcat $category_subcat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\category_subcat  $category_subcat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category_subcat $category_subcat)
    {
        //
    }
}
