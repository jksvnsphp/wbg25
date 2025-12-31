<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TenderCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
class TendersController extends Controller
{
    //
    public function index(){
        $items=TenderCategory::orderBy('name','ASC')->withCount('subCategory')->get();
        return view('admin.tenders_management.index',compact('items'));
    }

    public function changeStatus(Request $request)
    {
        // dd($request->all());
        $supplier = TenderCategory::where('id', $request->id)->first();
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
                'name' => 'required|string|unique:tender_categories,name',
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
            $TenderCategory = TenderCategory::where('slug', $slug)->first();
            if (!empty($TenderCategory)) {
                return back()->with(['alert-type' => 'error', 'message' => 'Slug is already taken!']);
            } else {
                $TenderCategory = new TenderCategory();
                $TenderCategory->name = $request->name;
                $TenderCategory->slug = Str::slug($request->name);
                $TenderCategory->meta_keyword = $request->meta_keyword;
                $TenderCategory->meta_description = $request->meta_description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('tender_') . '.' . $ext;
                    $file->move(public_path('/uploads/tender_category/'), $fileName);
                    $TenderCategory->image = $fileName;
                }
                $TenderCategory->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Tender Category added successfully']);
            }
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|string|exists:tender_categories,id',
                'name' => 'required|string|unique:tender_categories,name,' . $request->id,
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {

            $TenderCategory = TenderCategory::where('id', $request->id)->first();
            if (!empty($TenderCategory)) {

                $TenderCategory->name = $request->name;
                $TenderCategory->slug = Str::slug($request->name);
                $TenderCategory->meta_keyword = $request->meta_keyword;
                $TenderCategory->meta_description = $request->meta_description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('tender_') . '.' . $ext;
                    $file->move(public_path('/uploads/tender_category/'), $fileName);
                    if ($TenderCategory->image != '') {
                        $oldfile = public_path('/uploads/tender_category/' . $TenderCategory->image);
                        if (File::exists($oldfile)) {
                            File::delete($oldfile);
                        }
                    }
                    $TenderCategory->image = $fileName;
                }
                $TenderCategory->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Tender Category updated successfully']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Tender Category not found!']);
            }
        }
    }


    public function DeleteCategory($category_id)
    {
        $TenderCategory = TenderCategory::where('id', $category_id)->first();
        if (!empty($TenderCategory)) {
            if ($TenderCategory->image != '') {
                $oldfile = public_path('/uploads/supplier_category/' . $TenderCategory->image);
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }

            $TenderCategory->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
        }
    }
    public function edit($category_id)
    {
        $TenderCategory = TenderCategory::where('id', $category_id)->first();
        if (!empty($TenderCategory)) {

            return view('admin.tenders_management.edit_tender_category', ['pcat' => $TenderCategory]);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
        }
    }
}
