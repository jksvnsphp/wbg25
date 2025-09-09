<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\quotations_subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
class QuotationsSubcategoryController extends Controller
{
    //
    public function index($category_id){
        $items=quotations_subcategory::with('category')->where('category_id',$category_id)->orderBy('name','ASC')->get();

        return view('admin.quotation_management.quotation_subcategories',['items'=>$items,'category_id'=>$category_id]);
    }
   
    public function changeStatus(Request $request)
    {
        // dd($request->all());
        $supplier = quotations_subcategory::where('id', $request->id)->first();
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
                'category_id'=>'required|numeric|exists:quotation_categories,id',
                'name' => 'required|string|unique:quotations_subcategories,name',
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
            $quotations_subcategory = quotations_subcategory::where('slug', $slug)->first();
            if (!empty($quotations_subcategory)) {
                return back()->with(['alert-type' => 'error', 'message' => 'Slug is already taken!']);
            } else {
                $quotations_subcategory = new quotations_subcategory();
                $quotations_subcategory->name = $request->name;
                $quotations_subcategory->category_id = $request->category_id;
                $quotations_subcategory->slug = Str::slug($request->name);
                $quotations_subcategory->meta_keyword = $request->meta_keyword;
                $quotations_subcategory->meta_description = $request->meta_description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('category_') . '.' . $ext;
                    $file->move(public_path('/uploads/quotation_category/'), $fileName);
                    $quotations_subcategory->image = $fileName;
                }
                $quotations_subcategory->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Quotation sub Category added successfully']);
            }
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|string|exists:quotations_subcategories,id',
                'name' => 'required|string|unique:quotations_subcategories,name,' . $request->id,
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {

            $quotations_subcategory = quotations_subcategory::where('id', $request->id)->first();
            if (!empty($quotations_subcategory)) {

                $quotations_subcategory->name = $request->name;
                $quotations_subcategory->slug = Str::slug($request->name);
                $quotations_subcategory->meta_keyword = $request->meta_keyword;
                $quotations_subcategory->meta_description = $request->meta_description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('category_') . '.' . $ext;
                    $file->move(public_path('/uploads/quotation_category/'), $fileName);
                    if ($quotations_subcategory->image != '') {
                        $oldfile = public_path('/uploads/quotation_category/' . $quotations_subcategory->image);
                        if (File::exists($oldfile)) {
                            File::delete($oldfile);
                        }
                    }
                    $quotations_subcategory->image = $fileName;
                }
                $quotations_subcategory->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Quotation Sub Category updated successfully']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Quotation Sub Category not found!']);
            }
        }
    }


    public function DeleteCategory($category_id)
    {
        $quotations_subcategory = quotations_subcategory::where('id', $category_id)->first();
        if (!empty($quotations_subcategory)) {
            if ($quotations_subcategory->image != '') {
                $oldfile = public_path('/uploads/quotation_category/' . $quotations_subcategory->image);
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }

            $quotations_subcategory->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
        }
    }
    public function edit($category_id)
    {
        $quotations_subcategory = quotations_subcategory::where('id', $category_id)->first();
        if (!empty($quotations_subcategory)) {

            return view('admin.quotation_management.edit_quotation_subcategory', ['pcat' => $quotations_subcategory]);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
        }
    }
}
