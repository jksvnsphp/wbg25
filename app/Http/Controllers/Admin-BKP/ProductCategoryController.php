<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\attribute;
use App\Models\category;
use App\Models\category_attribute;
use App\Models\endsubcategory;
use App\Models\parent_category;
use App\Models\subcategory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    //
    public function generateUniqueSlug($name, $model)
{
    // Generate initial slug
    $slug = Str::slug($name);
    $originalSlug = $slug;

    // Check if the slug exists in the database
    $counter = 1;
    while ($model::where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $counter; // Append counter to make slug unique
        $counter++;
    }

    return $slug;
}
    public function showParentCategory()
    {
        $parent_categories = parent_category::orderBy('name', 'ASC')->withCount('category')->get();
        $data = ['parentCategories' => $parent_categories];
        return view('admin.product_managment.show.parent-category', $data);
    }
    public function showCategory($parent_category_id)
    {
        $categories = category::where('parent_category_id', $parent_category_id)->orderBy('name', 'ASC')->withCount('subcategory', 'category_attributes')->get();
        $data = ['categories' => $categories, 'parent_category_id' => $parent_category_id];
        // dd($categories);
        return view('admin.product_managment.show.category', $data);
    }
    public function showSubCategory($category_id)
    {
        $subcategories = subcategory::where('category_id', $category_id)->withCount('endsubcategories')->orderBy('name', 'ASC')->get();
        $data = ['subcategories' => $subcategories, 'category_id' => $category_id];
        // dd($categories);
        return view('admin.product_managment.show.sub-category', $data);
    }
    public function showEndCategory($subcategory_id)
    {
        $endsubcategories = endsubcategory::where('subcategories_id', $subcategory_id)->orderBy('name', 'ASC')->get();
        $data = ['endsubcategories' => $endsubcategories, 'subcategory_id' => $subcategory_id];
        // dd($categories);
        return view('admin.product_managment.show.endsub_category', $data);
    }
    public function showAttributesCategory($category_id)
    {

        $allAttributes = attribute::latest()->get();
        $allcategory_attributes = category_attribute::where('category_id', $category_id)->pluck('attribute_id')->toArray();
        $category_attributes = category_attribute::where('category_id', $category_id)->with('attribute')->orderBy('id', 'ASC')->get();

        $attributesNotInCategory = $allAttributes->reject(function ($attribute) use ($allcategory_attributes) {
            return in_array($attribute->id, $allcategory_attributes);
        });

        $data = ['category_attributes' => $category_attributes, 'allattributes' => $attributesNotInCategory, 'category_id' => $category_id];
        // dd($categories);
        return view('admin.product_managment.show.category-attributes', $data);
    }


    // parent category manager
    public function AddParentCategory(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:parent_categories,name',
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            $slug = Str::slug($request->name);
            //    check slug is exist or not
            $parentCategory = parent_category::where('slug', $slug)->first();
            if (!empty($parentCategory)) {
                return back()->with(['alert-type' => 'error', 'message' => 'Slug is already taken!']);
            } else {
                $parentCategory = new parent_category();
                $parentCategory->name = $request->name;
                $parentCategory->slug = Str::slug($request->name);
                $parentCategory->meta_keywords = $request->meta_keyword;
                $parentCategory->meta_description = $request->meta_description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('category_') . '.' . $ext;
                    $file->move(public_path('/uploads/products/parentCategory/'), $fileName);
                    $parentCategory->image = $fileName;
                }
                $parentCategory->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Parent Category added successfully']);
            }
        }
    }
    public function UpdateParentCategory(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|numeric|exists:parent_categories,id',
                'name' => 'required|unique:parent_categories,name,' . $request->id,
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            $slug = Str::slug($request->name);

            $parentCategory = parent_category::where('id', $request->id)->first();
            $parentCategory->name = $request->name;
            $parentCategory->slug = Str::slug($request->name);
            $parentCategory->meta_keywords = $request->meta_keyword;
            $parentCategory->meta_description = $request->meta_description;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $fileName = uniqid('category_') . '.' . $ext;
                $file->move(public_path('/uploads/products/parentCategory/'), $fileName);
                if ($parentCategory->image != '') {
                    $oldFile = public_path('/uploads/products/parentCategory/' . $parentCategory->image);
                    if (File::exists($oldFile)) {
                        File::delete($oldFile);
                    }
                }
                $parentCategory->image = $fileName;
            }
            $parentCategory->save();
            return back()->with(['alert-type' => 'success', 'message' => 'Parent Category updated successfully']);
        }
    }

    public function DeleteParentCategory($category_id)
    {
        $parent_category = parent_category::where('id', $category_id)->first();
        if (!empty($parent_category)) {
            if ($parent_category->image != '') {
                $oldfile = public_path('/uploads/products/parentCategory/' . $parent_category->image);
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }

            $parent_category->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
        }
    }
    public function updateStatusParentCategory(Request $request)
    {
        $parent_category = parent_category::findOrFail($request->id);
        $parent_category->status = $request->status;
        $parent_category->save();
        return response()->json(['success' => true]);
    }
    public function editParentCategory($category_id)
    {
        $pcat = parent_category::where('id', $category_id)->first();
        if (!empty($pcat)) {
            return view('admin.product_managment.edit.edit-parent-category', compact('pcat'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
        }
    }


    // category manager
    public function AddCategory(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'parent_category_id' => 'required|exists:parent_categories,id',
                'name' => 'required|unique:categories,name',
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            $slug = Str::slug($request->name);
            //    check slug is exist or not
            $category = category::where('slug', $slug)->first();
            if (!empty($category)) {
                return back()->with(['alert-type' => 'error', 'message' => 'Slug is already taken!']);
            } else {
                $category = new category();
                $category->name = $request->name;
                $category->parent_category_id = $request->parent_category_id;
                $category->slug = Str::slug($request->name);
                $category->meta_keywords = $request->meta_keyword;
                $category->meta_description = $request->meta_description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('category_') . '.' . $ext;
                    $file->move(public_path('/uploads/products/category/'), $fileName);
                    $category->image = $fileName;
                }
                $category->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Category added successfully']);
            }
        }
    }

    public function UpdateCategory(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|numeric|exists:categories,id',
                'name' => 'required|unique:categories,name,' . $request->id,
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            $slug = Str::slug($request->name);

            $category = category::where('id', $request->id)->first();
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->meta_keywords = $request->meta_keyword;
            $category->meta_description = $request->meta_description;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $fileName = uniqid('category_') . '.' . $ext;
                $file->move(public_path('/uploads/products/category/'), $fileName);
                if ($category->image != '') {
                    $oldFile = public_path('/uploads/products/category/' . $category->image);
                    if (File::exists($oldFile)) {
                        File::delete($oldFile);
                    }
                }
                $category->image = $fileName;
            }
            $category->save();
            return back()->with(['alert-type' => 'success', 'message' => 'Category updated successfully']);
        }
    }

    public function DeleteCategory($category_id)
    {
        $category = category::where('id', $category_id)->first();
        if (!empty($category)) {
            if ($category->image != '') {
                $oldfile = public_path('/uploads/products/category/' . $category->image);
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }

            $category->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
        }
    }
    public function updateStatusCategory(Request $request)
    {
        $category = category::findOrFail($request->id);
        $category->status = $request->status;
        $category->save();
        return response()->json(['success' => true]);
    }

    public function editCategory($category_id)
    {
        $pcat = category::where('id', $category_id)->first();
        if (!empty($pcat)) {
            return view('admin.product_managment.edit.edit-category', compact('pcat'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
        }
    }
    
    //sub category manager
    public function AddsubCategory(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string',
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            // dd($validator->errors());
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            
                $subcategory = new subcategory();
                $subcategory->name = $request->name;
                $subcategory->category_id = $request->category_id;
                $subcategory->slug = $this->generateUniqueSlug($request->name, subcategory::class);
                $subcategory->meta_keywords = $request->meta_keyword;
                $subcategory->meta_description = $request->meta_description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('subcategory_') . '.' . $ext;
                    $file->move(public_path('/uploads/products/subCategory/'), $fileName);
                    $subcategory->image = $fileName;
                }
                $subcategory->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Sub Category added successfully']);
            
        }
    }

    public function UpdatesubCategory(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|numeric|exists:subcategories,id',
                'name' => 'required|string',
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {


            $subcategory = subcategory::where('id', $request->id)->first();
            $subcategory->name = $request->name;
            $subcategory->slug = $this->generateUniqueSlug($request->name, subcategory::class);
            $subcategory->meta_keywords = $request->meta_keyword;
            $subcategory->meta_description = $request->meta_description;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $fileName = uniqid('subcategory_') . '.' . $ext;
                $file->move(public_path('/uploads/products/subCategory/'), $fileName);
                if ($subcategory->image != '') {
                    $oldFile = public_path('/uploads/products/subCategory/' . $subcategory->image);
                    if (File::exists($oldFile)) {
                        File::delete($oldFile);
                    }
                }
                $subcategory->image = $fileName;
            }
            $subcategory->save();
            return back()->with(['alert-type' => 'success', 'message' => 'Sub Category updated successfully']);
        }
    }

    public function DeletesubCategory($category_id)
    {
        $category = subcategory::where('id', $category_id)->first();
        if (!empty($category)) {
            if ($category->image != '') {
                $oldfile = public_path('/uploads/products/subCategory/' . $category->image);
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }

            $category->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Sub Category not found!']);
        }
    }
    public function updateStatussubCategory(Request $request)
    {
        $category = subcategory::findOrFail($request->id);
        $category->status = $request->status;
        $category->save();
        return response()->json(['success' => true]);
    }


    public function editsubCategory($category_id)
    {
        $pcat = subcategory::where('id', $category_id)->first();
        if (!empty($pcat)) {
            return view('admin.product_managment.edit.edit-sub-category', compact('pcat'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Sub Category not found!']);
        }
    }



    // category attributes
    public function DeleteCategoryAttr($category_id)
    {
        $category = category_attribute::where('id', $category_id)->first();
        if (!empty($category)) {
            $category->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category Attribute not found!']);
        }
    }
    public function AddAttrCategory(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'category_id' => 'required|exists:categories,id',
                'attributes' => 'array',
                'attributes.*' => 'exists:attributes,id',
                'isRequired' => 'required'
            ]
        );
        //  dd($validator->errors());
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {


            $attrs = $request->input('attributes');
            // dd($attrs);
            foreach ($attrs as $atr) {
                $check = category_attribute::where('category_id', $request->category_id)->where('attribute_id', $atr)->first();
                if (empty($check)) {
                    $category = new category_attribute();
                    $category->category_id = $request->category_id;
                    $category->attribute_id = $atr;
                    $category->isRequired = $request->isRequired;
                    $category->save();
                }
            }

            return back()->with(['alert-type' => 'success', 'message' => 'Category Attribute added successfully']);
        }
    }

    public function updateStatusAttrCategory(Request $request)
    {
        $category = category_attribute::findOrFail($request->id);
        if ($category) {
            $field = $request->field;
            if (in_array($field, ['status', 'isRequired'])) {
                $category->$field = $request->value;
                $category->save();

                return response()->json([
                    'success' => true,
                    'message' => ucfirst($field) . ' updated successfully!'
                ]);
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'Category not found!'
            ]);
    }


    // end sub category manager
    public function updateStatusEndsubCategory(Request $request)
    {
        $category = endsubcategory::findOrFail($request->id);
        $category->status = $request->status;
        $category->save();
        return response()->json(['success' => true]);
    }

    public function AddEndsubCategory(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'subcategory_id' => 'required|exists:subcategories,id',
                'name' => 'required|string',
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {
           
                $endsubcategory = new endsubcategory();
                $endsubcategory->name = $request->name;
                $endsubcategory->subcategories_id = $request->subcategory_id;
                $endsubcategory->slug = $this->generateUniqueSlug($request->name, endsubcategory::class);
                $endsubcategory->meta_keywords = $request->meta_keyword;
                $endsubcategory->meta_description = $request->meta_description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('endsubcategory_') . '.' . $ext;
                    $file->move(public_path('/uploads/products/endSubCategory/'), $fileName);
                    $endsubcategory->image = $fileName;
                }
                $endsubcategory->save();
                return back()->with(['alert-type' => 'success', 'message' => 'End Sub Category added successfully']);
            
        }
    }

    public function DeleteEndsubCategory($category_id)
    {
        $category = endsubcategory::where('id', $category_id)->first();
        if (!empty($category)) {
            if ($category->image != '') {
                $oldfile = public_path('/uploads/products/endSubCategory/' . $category->image);
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }

            $category->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'End Sub Category not found!']);
        }
    }

    public function editendsubCategory($category_id)
    {
        $pcat = endsubcategory::where('id', $category_id)->first();
        if (!empty($pcat)) {
            return view('admin.product_managment.edit.edit-end-sub-category', compact('pcat'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Sub Category not found!']);
        }
    }

    public function UpdateendsubCategory(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|numeric|exists:endsubcategories,id',
                'name' => 'required|string',
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {


            $subcategory = endsubcategory::where('id', $request->id)->first();
            $subcategory->name = $request->name;
            $subcategory->slug = $this->generateUniqueSlug($request->name, endsubcategory::class);
            $subcategory->meta_keywords = $request->meta_keyword;
            $subcategory->meta_description = $request->meta_description;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $fileName = uniqid('endsubcategory_') . '.' . $ext;
                $file->move(public_path('/uploads/products/endSubCategory/'), $fileName);
                if ($subcategory->image != '') {
                    $oldFile = public_path('/uploads/products/endSubCategory/' . $subcategory->image);
                    if (File::exists($oldFile)) {
                        File::delete($oldFile);
                    }
                }
                $subcategory->image = $fileName;
            }
            $subcategory->save();
            return back()->with(['alert-type' => 'success', 'message' => 'End Sub Category updated successfully']);
        }
    }
}
