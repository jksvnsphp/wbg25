<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\attribute;
use App\Models\AttributeItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributesController extends Controller
{
    //
    public function index()
    {
        $attributes = attribute::orderBy('id', 'DESC')->get();
        return view('admin.attributes.attributes', compact('attributes'));
    }
    public function edit($id)
    {
        $attributes = attribute::orderBy('id', 'DESC')->get();
        $attribute = attribute::where('id', $id)->with('attribute_options')->first();
        return view('admin.attributes.attributes', compact('attributes', 'attribute'));
    }
    public function create(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'id' => 'nullable',
                'name' => 'required',
                'datatype' => 'required|string',
                'values' => 'nullable|array'
            ]
        );

        if ($validate->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validate->errors())->withInput($request->all());
        } else {
            if (isset($request->id) && $request->id != '') {
                $attribute = attribute::where('id', $request->id)->first();
                $attribute->name = $request->name;
                $attribute->input_option = $request->datatype;
                $attribute->dataType = $request->datatype;
                $attribute->save();
                if (in_array($request->datatype, ['select', 'checkbox', 'radio'])) {
                    
                    $existingItems = AttributeItem::where('attribute_id', $attribute->id)->get()->pluck('attribute_option', 'id')->toArray();

                    $newValues = $request->has('values') ? $request->values : [];
                    $valuesToDelete = array_diff($existingItems, $newValues);
                    $valuesToAdd = array_diff($newValues, $existingItems);
                    if (!empty($valuesToDelete)) {
                        AttributeItem::where('attribute_id', $attribute->id)
                            ->whereIn('attribute_option', $valuesToDelete)
                            ->delete();
                    }

                    // Add new values
                    foreach ($valuesToAdd as $value) {
                        $AttributeItem=new AttributeItem;
                        $AttributeItem->attribute_id=$attribute->id;
                        $AttributeItem->attribute_option=$value;
                        $AttributeItem->save();
                        
                    }
                }


                return back()->with(['alert-type' => 'success', 'message' => 'Attribute updated successfully!']);
            } else {
                $attribute = new attribute;
                $attribute->name = $request->name;
                $attribute->input_option = $request->datatype;
                $attribute->dataType = $request->datatype;
                $attribute->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Attribute created successfully!']);
            }
        }
    }

    public function deleteAttribute($id)
    {
        $attribute = attribute::where('id', $id)->first();
        if ($attribute) {
            $attribute->delete();
        }
        return back()->with(['alert-type' => 'success', 'message' => 'Attribute deleted successfully!']);
    }
}
