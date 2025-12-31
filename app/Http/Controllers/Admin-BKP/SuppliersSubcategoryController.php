<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\suppliers_subcategory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class SuppliersSubcategoryController extends Controller
{
    //
    public function index($id){
       $suppliers=suppliers_subcategory::with('category')->where('category_id',$id)->orderBy('name','ASC')->get();
       $category_id=$id;
       return view('admin.supplier_management.sub-categories',compact('suppliers','category_id'));
    }

    public function changeStatus(Request $request)
    {
        // dd($request->all());
        $supplier = suppliers_subcategory::where('id', $request->id)->first();
        $supplier->status = $request->status;
        if ($supplier->save()) {
            return response()->json(['success' => 'Status Changed Successfully']);
        } else {
            return response()->json(['error' => 'Something went wrong']);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'category_id' => 'required|numeric|exists:supplier_categories,id',
                'name' => 'required|string|unique:suppliers_subcategories,slug',
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            $slug = Str::slug($request->name);
            //    check slug is exist or not
            $suppliers_subcategory = suppliers_subcategory::where('slug', $slug)->first();
            if (!empty($suppliers_subcategory)) {
                return back()->with(['alert-type' => 'error', 'message' => 'Slug is already taken!']);
            } else {
                $suppliers_subcategory = new suppliers_subcategory();
                $suppliers_subcategory->name = $request->name;
                $suppliers_subcategory->category_id = $request->category_id;
                $suppliers_subcategory->slug = Str::slug($request->name);
                $suppliers_subcategory->meta_keyword = $request->meta_keyword;
                $suppliers_subcategory->meta_description = $request->meta_description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('category_') . '.' . $ext;
                    $file->move(public_path('/uploads/supplier_category/'), $fileName);
                    $suppliers_subcategory->image = $fileName;
                }
                $suppliers_subcategory->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Supplier Category added successfully']);
            }
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|string|exists:suppliers_subcategories,id',
                'name' => 'required|string|unique:suppliers_subcategories,name,' . $request->id,
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {

            $suppliers_subcategory = suppliers_subcategory::where('id', $request->id)->first();
            if (!empty($suppliers_subcategory)) {

                $suppliers_subcategory->name = $request->name;
                $suppliers_subcategory->slug = Str::slug($request->name);
                $suppliers_subcategory->meta_keyword = $request->meta_keyword;
                $suppliers_subcategory->meta_description = $request->meta_description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('category_') . '.' . $ext;
                    $file->move(public_path('/uploads/supplier_category/'), $fileName);
                    if ($suppliers_subcategory->image != '') {
                        $oldfile = public_path('/uploads/supplier_category/' . $suppliers_subcategory->image);
                        if (File::exists($oldfile)) {
                            File::delete($oldfile);
                        }
                    }
                    $suppliers_subcategory->image = $fileName;
                }
                $suppliers_subcategory->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Supplier Category updated successfully']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Supplier Category not found!']);
            }
        }
    }


    public function DeleteCategory($category_id)
    {
        $suppliers_subcategory = suppliers_subcategory::where('id', $category_id)->first();
        if (!empty($suppliers_subcategory)) {
            if ($suppliers_subcategory->image != '') {
                $oldfile = public_path('/uploads/supplier_category/' . $suppliers_subcategory->image);
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }

            $suppliers_subcategory->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
        }
    }
    public function edit($category_id)
    {
        $suppliers_subcategory = suppliers_subcategory::where('id', $category_id)->first();
        if (!empty($suppliers_subcategory)) {

            return view('admin.supplier_management.edit_supplier_subcategory', ['pcat' => $suppliers_subcategory]);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
        }
    }
}
