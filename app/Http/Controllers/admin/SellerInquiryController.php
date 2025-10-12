<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use App\Models\User;
use App\Models\Inbox;
use App\Models\ChatMessage;

use Illuminate\Http\Request;


class SellerInquiryController extends Controller
{
    public function index()
    {
        // Get only buyer inquiries (filter by message_type if needed)
       $inquiries = Inbox::with(['sender', 'receiver'])
        ->whereHas('sender', function($q) {
        $q->where('account_type', 'seller');
         })
         ->latest()
         ->paginate(10);

            //echo '<pre>'; print_r($inquiries->toArray()); die;

        return view('admin.inquiries.seller.index', compact('inquiries'));
    }

    public function show($id)
    {
           $messages = ChatMessage::where(function ($query) use ($id) {
            //$query->where('sender_id', auth()->user()->id)
               // ->where('receiver_id', $request->receiver_id)
                $query->where('message_id', $id);
        })
            ->orWhere(function ($query) use ($id) {
              //  $query->where('sender_id', $request->receiver_id)
                    //->where('receiver_id', auth()->user()->id)
                    $query->where('message_id', $id);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                $message->created_at_human = $message->created_at->diffForHumans();
                return $message;
            });
        $inquiry = Inbox::with(['sender', 'receiver'])->findOrFail($id);
        return view('admin.inquiries.seller.show', compact('messages', 'inquiry'));
    }

    public function destroy($id)
    {
        $inquiry = Inbox::findOrFail($id);
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted successfully');
    }
}
