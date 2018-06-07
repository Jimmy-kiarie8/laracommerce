<?php

namespace App\Http\Controllers;

use App\Category_subcat;
use App\Subcat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubcatController extends Controller
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
        $subcat = new Subcat;
        $subcat->subcat_name = $request->sub_category;
        $subcat->category_id = $request->parent;
        $subcat->subcat_name = $request->subcat_name;
        $subcat->category_id = $request->id;
        $subcat->user_id = Auth::id();
        if ($subcat->save()) {
            $sub_cat = new Category_subcat;
            $sub_cat->category_id = $request->id;
            $sub_cat->subcat_id = $subcat->id;
            $sub_cat->save();
        }
        // var_dump($subcat);
        return $subcat;
        
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subcat  $subcat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcat $subcat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subcat  $subcat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcat $subcat)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getsubcategories()
    {
        return Subcat::all();
    }
}
