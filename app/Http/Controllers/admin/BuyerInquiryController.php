<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use App\Models\User;
use App\Models\Inbox;

use Illuminate\Http\Request;


class BuyerInquiryController extends Controller
{
    public function index()
    {
        // Get only buyer inquiries (filter by message_type if needed)
       $inquiries = Inbox::with(['sender', 'receiver'])
        ->whereHas('sender', function($q) {
        $q->where('account_type', 'buyer');
         })
         ->latest()
         ->paginate(10);

            //echo '<pre>'; print_r($inquiries->toArray()); die;

        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function show($id)
    {
        $inquiry = Inbox::with(['sender', 'receiver'])->findOrFail($id);
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function destroy($id)
    {
        $inquiry = Inbox::findOrFail($id);
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted successfully');
    }
}
