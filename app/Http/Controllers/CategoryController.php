<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu= Category::with([
            'items','subCategories' ,
            'subCategories.items' ,'subCategories.subCategories',
            'subCategories.subCategories.items','subCategories.subCategories.subCategories',
            'subCategories.subCategories.subCategories.items'
            ])->whereNull('parentId')->get();
        return response()->json(['menu'=>$menu]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        if ($this->MakingSubCategoryPossible($request->parentId)) {
            $category = new Category();
            $category->title       = $request->title;
            $category->type       = $request->type;
            $category->discountPercent       = $request->discountPercent;
            $category->parentId = $request->parentId ;
            $category->save();
            return response()->json(['message'=>"category inserted successfully" ]);
        }
        else
        return response()->json(["errors"=>['category'=>"Can't create sub category at this level"]],422);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->title       = $request->title;
        $category->discountPercent       = $request->discountPercent;
        $category->save();
        return response()->json(['message'=>"category updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message'=>"category deleted successfully"]);
    }

    public function setDisAcountForAllMenu(Request $request)
    {
        Validator::make($request->only('discountPercent'), ['discountPercent'  => 'required|numeric|min:0|max:100|nullable'])->validate();
        try {
            DB::beginTransaction();

            DB::table('items')->update([
                'discountPercent' =>$request->discountPercent
            ]);

            DB::table('categories')->update([
                'discountPercent' =>$request->discountPercent
            ]);

            DB::commit();
        } catch (\Exception $e) {
            report($e);

            DB::rollBack();
        }

        return response()->json(['message'=>"discount has been added for all menu"]);

    }


    private function calculatSubCategoryLevel($parentId)
    {
        if (is_null($parentId))
            return 0 ;
        else
        return 1 + $this->calculatSubCategoryLevel(Category::find($parentId)->parentId) ;
    }
    private function MakingSubCategoryPossible($parintId)
    {
        $maxLevel =4 ;
        $level = $this->calculatSubCategoryLevel($parintId);
        if($maxLevel>$level) return true;
        else return false;
    }



}






