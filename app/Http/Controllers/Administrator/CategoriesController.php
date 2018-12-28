<?php

namespace App\Http\Controllers\Administrator;

use App\Category;
use App\Slug;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function categoryList($id =null){
        if($id){
            $all_category = Category::where('parent_id',$id)->get();
            $category = Category::find($id);
            return view('administrator.categories.category-list',compact('all_category','category'));
        }else{
            $all_category = Category::where('parent_id',0)->get();
            return view('administrator.categories.category-list',compact('all_category'));
        }

    }

    public function categoryAdd(){
        return view('administrator.categories.categories-add');
    }

    public function categorySave(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'string|required|unique:categories,name|regex:/^[a-zA-Z0-9 _-]+$/',
            'slug' => 'string|required|unique:categories|regex:/[a-z0-9-]+/'
        ]);
        if($validator->fails()){
            return redirect(route('administrator.category.add.get'))
                ->withErrors($validator)
                ->withInput();
        }

        $category = new Category();
        $category->name = $request->get('name');
        $category->slug = $request->get('slug');
        $category->parent_id = 0;
        $category->save();
        return redirect(route('administrator.category.add.get'))->with('success_messge',"Category Added successfully...");
    }

    public function categoryEdit($id,Request $request){
        $category = Category::where('id',$id)->where('parent_id',0)->first();
        if(!$category){
            return redirect(route('administrator.category.list'));
        }
        return view('administrator.categories.category-edit',compact('category'));
    }

    public function categoryUpdate($id,Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'string|required|unique:categories,name|regex:/^[a-zA-Z0-9]+$/',
            'slug' => 'string|required|unique:categories|regex:/[a-z0-9-]+/'
        ]);
        if($validator->fails()){
            return redirect(route('administrator.category.edit.post',[$id]))
                ->withErrors($validator)
                ->withInput();
        }
        $category = Category::find($id);
        $category->name = $request->get('name');
        $category->slug = $request->get('slug');
        $category->save();

        return redirect(route('administrator.category.edit.get',[$id]))->with('success_messge',"Category updated successfully...");
    }


    public function checkSlug(Request $request){
        $name = $request->get('name');
        $slug = $request->get('slug');
        return Slug::checkSlug($name,$slug);
    }

    /**
     * sub categories
     */

    public function subCategoryList($id = null){
        if($id){
            $sub_category_main = Category::where('id',$id)->first();
            if($sub_category_main){
                $all_sub_category = Category::where('parent_id','=',$sub_category_main->id)->orderBy('parent_id','DESC')->get();
                return view('administrator.categories.sub-categories-list',compact('all_sub_category','sub_category_main'));
            }
        }
        $all_sub_category = Category::where('parent_id','!=',0)->orderBy('parent_id','DESC')->get();
        return view('administrator.categories.sub-categories-list',compact('all_sub_category'));
    }

    public function subCategoryAdd($id=null){
        $all_category = Category::where('parent_id','!=',null)->get();
        if($id){
            $sub_category_main = Category::where('id',$id)->first();
            if($sub_category_main){
                return view('administrator.categories.sub-categories-add',compact('all_category','sub_category_main','id'));
            }
        }

        return view('administrator.categories.sub-categories-add',compact('all_category','id'));
    }
    
    public function subCategorySave(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'string|required|unique:categories,name|regex:/^[a-zA-Z0-9 _-]+$/',
            'slug' => 'string|required|unique:categories|regex:/[a-z0-9-]+/',
            'parent_category' => 'numeric|required|min:1'
        ]);
        $parent_id = $request->get('parent_id');
        if($validator->fails()){
            if($parent_id){
                return redirect(route('administrator.sub-sub-category.add.get',[$parent_id]))
                    ->withErrors($validator)
                    ->withInput();
            }
            return redirect(route('administrator.sub-category.add.get'))
                ->withErrors($validator)
                ->withInput();
        }

        $sub_category = new Category();
        $sub_category->name = $request->get('name');
        $sub_category->slug = $request->get('slug');
        $sub_category->parent_id = $request->get('parent_category');
        $sub_category->save();
        $slug = new Slug();
        $slug->slug = $request->get('slug');
        $slug->save();

        if($parent_id){
            return redirect(route('administrator.sub-sub-category.add.get',[$parent_id]))->with('success_messge',"Sub Location Added successfully...");
        }
        return redirect(route('administrator.sub-category.add.get'))->with('success_messge',"Sub Location Added successfully...");
    }

    public function subCategoryEdit($id,Request $request){
        $sub_category = Category::where('id',$id)->first();
        if(!$sub_category){
            return redirect(route('administrator.sub-category.list'));
        }
        $all_category = Category::where('parent_id','!=',null)->get();
        return view('administrator.categories.sub-categories-edit',compact('sub_category',"all_category"));
    }

    public function subCategoryUpdate($id,Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'string|required|unique:categories,name',
            'slug' => 'string|required|unique:categories|regex:/[a-z0-9-]+/',
            'parent_category' => 'numeric|required|min:1'
        ]);
        if($validator->fails()){
            return redirect(route('administrator.sub-category.edit.post',[$id]))
                ->withErrors($validator)
                ->withInput();
        }
        $sub_category = Category::find($id);
        $sub_category->name = $request->get('name');
        $sub_category->slug = $request->get('slug');
        $sub_category->save();
        return redirect(route('administrator.sub-category.edit.get',[$id]))->with('success_messge',"Sub Category updated successfully...");
    }
}
