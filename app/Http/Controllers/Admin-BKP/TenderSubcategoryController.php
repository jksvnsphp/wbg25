<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\tender_subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class TenderSubcategoryController extends Controller
{
     //
     public function index($id){
        $items=tender_subcategory::with('category')->where('category_id',$id)->orderBy('name','ASC')->get();
        $category_id=$id;
        return view('admin.tenders_management.tender_subcategory',compact('items','category_id'));
     }
 
     public function changeStatus(Request $request)
     {
         // dd($request->all());
         $supplier = tender_subcategory::where('id', $request->id)->first();
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
                 'category_id' => 'required|numeric|exists:tender_categories,id',
                 'name' => 'required|string|unique:tender_subcategories,name',
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
             $tender_subcategory = tender_subcategory::where('slug', $slug)->first();
             if (!empty($tender_subcategory)) {
                 return back()->with(['alert-type' => 'error', 'message' => 'Slug is already taken!']);
             } else {
                 $tender_subcategory = new tender_subcategory();
                 $tender_subcategory->name = $request->name;
                 $tender_subcategory->category_id = $request->category_id;
                 $tender_subcategory->slug = Str::slug($request->name);
                 $tender_subcategory->meta_keyword = $request->meta_keyword;
                 $tender_subcategory->meta_description = $request->meta_description;
                 if ($request->hasFile('image')) {
                     $file = $request->file('image');
                     $ext = $file->getClientOriginalExtension();
                     $fileName = uniqid('tender_') . '.' . $ext;
                     $file->move(public_path('/uploads/tender_category/'), $fileName);
                     $tender_subcategory->image = $fileName;
                 }
                 $tender_subcategory->save();
                 return back()->with(['alert-type' => 'success', 'message' => 'Tender Category added successfully']);
             }
         }
     }
     public function update(Request $request)
     {
         $validator = Validator::make(
             $request->all(),
             [
                 'id' => 'required|string|exists:tender_subcategories,id',
                 'name' => 'required|string|unique:tender_subcategories,name,' . $request->id,
                 'meta_keyword' => 'nullable|string',
                 'image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
                 'meta_description' => 'nullable|string'
             ]
         );
         if ($validator->fails()) {
             return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
         } else {
 
             $tender_subcategory = tender_subcategory::where('id', $request->id)->first();
             if (!empty($tender_subcategory)) {
 
                 $tender_subcategory->name = $request->name;
                 $tender_subcategory->slug = Str::slug($request->name);
                 $tender_subcategory->meta_keyword = $request->meta_keyword;
                 $tender_subcategory->meta_description = $request->meta_description;
                 if ($request->hasFile('image')) {
                     $file = $request->file('image');
                     $ext = $file->getClientOriginalExtension();
                     $fileName = uniqid('tender_') . '.' . $ext;
                     $file->move(public_path('/uploads/tender_category/'), $fileName);
                     if ($tender_subcategory->image != '') {
                         $oldfile = public_path('/uploads/tender_category/' . $tender_subcategory->image);
                         if (File::exists($oldfile)) {
                             File::delete($oldfile);
                         }
                     }
                     $tender_subcategory->image = $fileName;
                 }
                 $tender_subcategory->save();
                 return back()->with(['alert-type' => 'success', 'message' => 'Tender Category updated successfully']);
             } else {
                 return back()->with(['alert-type' => 'error', 'message' => 'Tender Category not found!']);
             }
         }
     }
 
 
     public function DeleteCategory($category_id)
     {
         $tender_subcategory = tender_subcategory::where('id', $category_id)->first();
         if (!empty($tender_subcategory)) {
             if ($tender_subcategory->image != '') {
                 $oldfile = public_path('/uploads/tender_category/' . $tender_subcategory->image);
                 if (File::exists($oldfile)) {
                     File::delete($oldfile);
                 }
             }
 
             $tender_subcategory->delete();
             return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
         } else {
             return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
         }
     }
     public function edit($category_id)
     {
         $tender_subcategory = tender_subcategory::where('id', $category_id)->first();
         if (!empty($tender_subcategory)) {
 
             return view('admin.tenders_management.edit_tender_subcategory', ['pcat' => $tender_subcategory]);
         } else {
             return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
         }
     }
}
