<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    //
    public function setBuyerRate(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $validate = Validator::make(
                $request->all(),
                [
                    'vendor_id' => ['required', 'exists:users,id'],
                    'product_id' => ['required', 'exists:products,id'],
                    'rate' => ['required', 'numeric', 'between:1,5'],
                    'order_id' => ['required', 'exists:orders,id'],
                    'order_item_id' => ['required', 'exists:order_items,id'],
                ]
            );
            if ($validate->fails()) {
                return response()->json(['success' => false, 'message' => 'Validation failed!', 'errors' => $validate->errors()], 200);
            } else {
                //  check if rate exist then update it and otherwise insert new
                $rate = Rating::where('vendor_id', $request->vendor_id)
                    ->where('user_id', auth()->user()->id)
                    ->where('order_id', $request->order_id)
                    ->where('product_id', $request->product_id)
                    ->first();
                if ($rate) {
                    $rate->rate = $request->rate;
                    $rate->save();
                    return response()->json(['success' => true, 'message' => 'Rate updated successfully!']);
                } else {
                    $rate = new Rating();
                    $rate->vendor_id = $request->vendor_id;
                    $rate->user_id = auth()->user()->id;
                    $rate->product_id = $request->product_id;
                    $rate->order_id = $request->order_id;
                    $rate->order_item_id = $request->order_item_id;
                    $rate->rate = $request->rate;
                    $rate->save();
                    return response()->json(['success' => true, 'message' => 'Rate set successfully!']);
                }
            }
        } else {
            return response()->json(['success' => false, 'message' => 'You must be logged in to perform this action'], 200);
        }
    }
}
