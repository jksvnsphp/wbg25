<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function myBuyProducts()
    {
        $orders = Order::latest()->where('user_id', Auth::user()->id)
            ->whereHas('orderItems')
            ->with('orderItems.product.gallery')
            ->paginate(10);
        return view('buyer-vendor.my-orders-product', compact('orders'));
    }

    public function myBuyProductDetail($order_item_id)
    {
        $item = OrderItem::where('id', $order_item_id)
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->with('order','rate', 'product.vendor.payment_infos', 'product.gallery')
            ->first();
        // dd($item);
        if ($item) {
            return view('buyer-vendor.buy-product-details', compact('item'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'You are not authorized!']);
        }
    }
}
