<?php

namespace App\Http\Controllers\Administrator;

use App\Brand;
use App\Category;
use App\Slug;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class BrandsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function brandsList($id =null){
        if($id){
            $all_brands = Brand::all();
            $brand = Brand::find($id);
            return view('administrator.brands.brand-list',compact('all_brands','brand'));
        }else{
            $all_brands = Brand::all();
            return view('administrator.brands.brands-list',compact('all_brands'));
        }
    }

    public function brandAdd($id=null){
        $all_categories = Category::where('parent_id','!=',null)->where('parent_id', '!=', 0)->get();
        return view('administrator.brands.brands-add',compact('all_categories','id'));
    }

    public function brandSave(Request $request){
        $category_id = $request->get('category');
        $validator = Validator::make($request->all(),[
            'name' => 'string|required|regex:/^[a-zA-Z0-9 _-]+$/|unique:brands,name,NULL,id,category_id,'.$category_id,
            'category' => 'numeric|required|min:1'
        ]);       
        if($validator->fails()){
            return redirect(route('administrator.brands.add.get'))
                ->withErrors($validator)
                ->withInput();
        }

        $brand = new Brand();
        $brand->name = $request->get('name');
        $brand->category_id = $request->get('category');
        $brand->save();

        if($category_id){
            return redirect(route('administrator.brands.add.get',[$category_id]))->with('success_messge',"Brand Added successfully...");
        }
        return redirect(route('administrator.brands.add.get'))->with('success_messge',"Brand Added successfully...");
    }

    public function brandEdit($id,Request $request){
        $brand = Brand::where('id',$id)->first();
        if(!$brand){
            return redirect(route('administrator.brands.list'));
        }
        $all_categories = Category::where('parent_id','!=',null)->where('parent_id', '!=', 0)->get();
        return view('administrator.brands.brands-edit',compact('brand',"all_categories"));
    }

    public function brandUpdate($id,Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'string|required',
            'category' => 'numeric|required|min:1'
        ]);
        if($validator->fails()){
            return redirect(route('administrator.brands.edit.post',[$id]))
                ->withErrors($validator)
                ->withInput();
        }
        $brand = Brand::find($id);
        $brand->name = $request->get('name');
        $brand->category_id = $request->get('category');
        $brand->save();
        return redirect(route('administrator.brands.edit.get',[$id]))->with('success_messge',"Brand updated successfully...");
    }

    public function brandDelete($id)
    {
        $brand = Brand::find($id);
        $brand->delete();
        return redirect(route('administrator.brands.list'))->with('success_messge',"Brand deleted successfully...");
    }

}
