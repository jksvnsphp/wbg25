<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SupplierCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    //
    public function index()
    {
        $suppliers = SupplierCategory::withCount('subCategories')->orderBy('name', 'ASC')->get();
        
        return view('admin.supplier_management.index', compact('suppliers'));
    }


    public function changeStatus(Request $request)
    {
        // dd($request->all());
        $supplier = SupplierCategory::where('id', $request->id)->first();
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
                'name' => 'required|string|unique:supplier_categories,slug',
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
            $SupplierCategory = SupplierCategory::where('slug', $slug)->first();
            if (!empty($SupplierCategory)) {
                return back()->with(['alert-type' => 'error', 'message' => 'Slug is already taken!']);
            } else {
                $SupplierCategory = new SupplierCategory();
                $SupplierCategory->name = $request->name;
                $SupplierCategory->slug = Str::slug($request->name);
                $SupplierCategory->meta_keyword = $request->meta_keyword;
                $SupplierCategory->meta_description = $request->meta_description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('category_') . '.' . $ext;
                    $file->move(public_path('/uploads/supplier_category/'), $fileName);
                    $SupplierCategory->image = $fileName;
                }
                $SupplierCategory->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Supplier Category added successfully']);
            }
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|string|exists:supplier_categories,id',
                'name' => 'required|string|unique:supplier_categories,slug,' . $request->id,
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {

            $SupplierCategory = SupplierCategory::where('id', $request->id)->first();
            if (!empty($SupplierCategory)) {

                $SupplierCategory->name = $request->name;
                $SupplierCategory->slug = Str::slug($request->name);
                $SupplierCategory->meta_keyword = $request->meta_keyword;
                $SupplierCategory->meta_description = $request->meta_description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('category_') . '.' . $ext;
                    $file->move(public_path('/uploads/supplier_category/'), $fileName);
                    if ($SupplierCategory->image != '') {
                        $oldfile = public_path('/uploads/supplier_category/' . $SupplierCategory->image);
                        if (File::exists($oldfile)) {
                            File::delete($oldfile);
                        }
                    }
                    $SupplierCategory->image = $fileName;
                }
                $SupplierCategory->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Supplier Category updated successfully']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Supplier Category not found!']);
            }
        }
    }


    public function DeleteCategory($category_id)
    {
        $SupplierCategory = SupplierCategory::where('id', $category_id)->first();
        if (!empty($SupplierCategory)) {
            if ($SupplierCategory->image != '') {
                $oldfile = public_path('/uploads/supplier_category/' . $SupplierCategory->image);
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }

            $SupplierCategory->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
        }
    }
    public function edit($category_id)
    {
        $SupplierCategory = SupplierCategory::where('id', $category_id)->first();
        if (!empty($SupplierCategory)) {

            return view('admin.supplier_management.edit_supplier_category', ['pcat' => $SupplierCategory]);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
        }
    }



}
