<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupon.create');
    }
    public function edit($id)
    {
        $coupon = Coupon::find($id);
        return view('admin.coupon.edit',compact('coupon'));
    }
    public function save(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        Coupon::create($request->all());
        return redirect()->route('admin.all.coupon')->with(['alert-type'=>'success', 'message'=>'Coupon created successfully']);
    }
    public function updateCoupon(Request $request,$id)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code,'.$id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $coupon=Coupon::where('id',$id)->first();
        $coupon->update($request->all());
        
        return redirect()->route('admin.all.coupon')->with(['alert-type'=>'success', 'message'=>'Coupon updated successfully']);
    }
    public function updateStatus(Request $request)
    {
        $coupon = Coupon::find($request->id);
        $coupon->is_active = $request->status;
        $coupon->save();
        return response()->json(['status' => 'success']);
    }

    public function deleteCoupon($id){
        $coupon = Coupon::find($id);
        $coupon->delete();
        return redirect()->route('admin.all.coupon')->with(['alert-type'=>'success', 'message'=>'Coupon deleted successfully']);
    }
}
