<?php

namespace App\Http\Controllers;

use App\Models\CustomeCategory;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class CustomeCategoryController extends Controller
{
    //
    public function index()
    {
        $categories = CustomeCategory::where('status', 1)
            ->where('deleted', '0')
            ->where('parent_id', '0')
            ->orderBy('category_name', 'ASC')
            ->get();
        // dd($categories);
        foreach ($categories as $category) {
            $category->children = CustomeCategory::where('parent_id', $category->id)
                ->where('status', '1')
                ->where('deleted', '0')
                ->orderBy('category_name', 'ASC')
                ->get();
        }
        // dd($categories);
        return view('external-user.all-category', compact('categories'));
    }

    public function allCategory()
    {
        $categories = CustomeCategory::where('parent_id', '0')->where('deleted', "0")
            ->orderBy('category_name', 'ASC')
            ->get();
        // dd($categories);
        foreach ($categories as $category) {
            $category->children = CustomeCategory::where('parent_id', $category->id)
                ->where('deleted', "0")
                ->count();
        }
        // dd($categories);
        return view('admin.product_managment.custome-category.all-category', compact('categories'));
    }

    public function statusCategory(Request $request)
    {
        $category_id = $request->id;
        $status = $request->status;
        $category = CustomeCategory::find($category_id);
        if ($category) {
            $category->status = $status;
            $category->save();
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function showChildCategory($category_id)
    {
        $category = CustomeCategory::where('id', $category_id)->where('deleted', '0')->first();
        $categories = CustomeCategory::where('parent_id', $category_id)->where('deleted', '0')->orderBy('classified_image', 'ASC')->get();
        return view('admin.product_managment.custome-category.all-child-category', compact('categories', 'category'));
    }

    public function editCategory($category_id)
    {
        $pcat = CustomeCategory::where('id', $category_id)->where('deleted', '0')->first();
        return view('admin.product_managment.custome-category.edit-category', compact('pcat'));
    }
    public function deleteCategory($category_id)
    {
        $pcat = CustomeCategory::where('id', $category_id)->where('deleted', '0')->first();
        if($pcat){
            $pcat->deleted = 1;
            $pcat->save();
            return redirect()->back()->with(['alert-type'=>'success','message'=>'Category deletd successfully']);
        }else{
            return redirect()->back()->with(['alert-type'=>'error','message'=>'Category not found']);
        }
    }
    public function updateCategory(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:category,id',
            'name' => 'required',
            'image' => 'nullable|image',
            'parent_id' => 'required',
            'title' => 'required|string',
            'keyword' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        $category_id = $request->id;
        $category = CustomeCategory::find($category_id);
        if ($category) {
            $category->category_name = $request->name;
            $category->title = $request->title;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $manager = new ImageManager(['driver' => 'gd']);
                $ext = $file->getClientOriginalExtension();
                $fileName = uniqid('custome_category_' . $category->id) . '.' . $ext;
                $manager->make($file)->resize(500, 500)->save(public_path('uploads/category-images/' . $fileName));
                $category->classified_image = $fileName;
            }
            $category->parent_id = $request->parent_id;
            $category->keyword = $request->keyword;
            $category->description = $request->description;
            $category->save();

            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Successfully save your changes.']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
        }
    }
    public function addCategory(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image',
            'parent_id' => 'required',
            'title' => 'required|string',
            'keyword' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        
        $category = new CustomeCategory();
        $category->category_name = $request->name;
        $category->title = $request->title;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $manager = new ImageManager(['driver' => 'gd']);
            $ext = $file->getClientOriginalExtension();
            $fileName = uniqid('custome_category_') . '.' . $ext;
            $manager->make($file)->resize(500, 500)->save(public_path('uploads/category-images/' . $fileName));
            $category->classified_image = $fileName;
        }
        $category->parent_id = $request->parent_id;
        $category->keyword = $request->keyword;
        $category->description = $request->description;
        $category->save();
        return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Successfully store category.']);
    }
}
