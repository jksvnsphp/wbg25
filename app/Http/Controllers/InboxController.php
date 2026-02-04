<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\inbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InboxController extends Controller
{

    public function sendMessageToContact(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $validated = $request->validate([
                'receiver_id' => 'required|exists:users,id',
                'tender_id' => 'nullable|exists:tenders,id',
                'quotation_id' => 'nullable|exists:quotations,id',
                'captcha' => 'required|captcha',
                'name' => 'required|string',
                'subject' => 'nullable|string',
                'message' => 'required|string',
            ], [
                'captcha' => 'The CAPTCHA verification failed. Please try again.',
            ]);
            $message = new inbox();
            $message->sender_id = auth()->user()->id;
            $message->receiver_id = $validated['receiver_id'];
            $message->tender_id = $validated['tender_id'] ?? null;
            $message->quotation_id = $validated['quotation_id'] ?? null;
            $message->message = $validated['message'];
            $message->name = $validated['name'];
            $message->subject = $validated['subject'];
            if (isset($validated['tender_id']) && $validated['tender_id'] != "") {
                $message->message_type = "tender_query";
            } elseif (isset($validated['quotation_id']) && $validated['quotation_id'] != "") {
                $message->message_type = "quotation";
            } else {
                $message->message_type = "contact_form";
            }
            $message->is_read = false;
            $message->save();
            return back()->with(['alert-type' => 'success', 'message' => 'Message sent successfully!']);
        } else {
            return back()->with(['alert-type' => 'unauth', 'message' => 'Unauthorized access!']);
        }
    }
    public function sendMessageToContactAjax(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $validator = Validator::make(
                $request->all(),
                [
                    'receiver_id' => 'required|exists:users,id',
                    'tender_id' => 'nullable|exists:tenders,id',
                    'quotation_id' => 'nullable|exists:quotations,id',
                    'name' => 'required|string',
                    'captcha' => 'required|captcha',
                    'subject' => 'nullable|string',
                    'message' => 'required|string',
                ],
                [
                    'captcha' => 'The CAPTCHA verification failed. Please try again.',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => 'Validation failed.', 'errors' => $validator->errors()]);
            } else {
                $message = new inbox();
                $message->sender_id = auth()->user()->id;
                $message->receiver_id = $request['receiver_id'];
                $message->message = $request['message'];
                $message->name = $request['name'];
                $message->subject = $request['subject'];
                $message->tender_id = $request['tender_id'] ?? null;
                $message->quotation_id = $request['quotation_id'] ?? null;

                if (isset($request['tender_id']) && $request['tender_id'] != "") {
                    $message->message_type = "tender_query";
                } elseif (isset($request['quotation_id']) && $request['quotation_id'] != "") {
                    $message->message_type = "quotation";
                } else {
                    $message->message_type = "contact_form";
                }

                $message->is_read = false;
                $message->save();
                return response()->json(['status' => 'success', 'message' => 'Message sent successfully!']);
            }
        } else {
            return response()->json(['status' => 'unauth', 'message' => 'Unauthorized access!']);
        }
    }
    public function sendMessageToProductAjax(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $validator = Validator::make(
                $request->all(),
                [
                    'receiver_id' => 'required|exists:users,id',
                    'product_id' => 'required|exists:products,id',
                    'name' => 'required|string',
                    'captcha' => 'required|captcha',
                    'subject' => 'nullable|string',
                    'message' => 'required|string',
                ],
                [
                    'captcha' => 'The CAPTCHA verification failed. Please try again.',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => 'Validation failed.', 'errors' => $validator->errors()]);
            } else {
                $message = new inbox();
                $message->sender_id = auth()->user()->id;
                $message->receiver_id = $request['receiver_id'];
                $message->product_id = $request['product_id'];
                $message->message = $request['message'];
                $message->name = $request['name'];
                $message->subject = $request['subject'];
                $message->message_type = "contact_form";
                $message->is_read = false;
                $message->save();
                return response()->json(['status' => 'success', 'message' => 'Message sent successfully!']);
            }
        } else {
            return response()->json(['status' => 'unauth', 'message' => 'Unauthorized access!']);
        }
    }
    public function myinbox(Request $request)
    {
        // dd($request->all());
        if (isset(auth()->user()->id)) {

            $unreadMessages = inbox::where(function ($query) {
                $query->where(function ($q) {
                    $q->where('receiver_id', auth()->id())->where('isReceiverRead', 0);
                })->orWhere(function ($q) {
                    $q->where('sender_id', auth()->id())->where('isSenderRead', 0);
                });
            })->get();

            $allMessages = inbox::query()
                ->with('sender', 'receiver', 'product.gallery', 'tender', 'quotation', 'latestChatMessage')
                ->withMax('chatMessages as last_chat_created_at', 'created_at')
                ->withCount([
                    'chatMessages as unread_chat_count' => function ($q) {
                        $q->where('receiver_id', auth()->id())->where('is_read', 0);
                    },
                ])
                ->where(function ($query) {
                    $query->where('receiver_id', auth()->user()->id)
                        ->orWhere('sender_id', auth()->user()->id);
                })
                ->when($request->has('message-type') && $request->input('message-type') !== 'all', function ($query) use ($request) {
                    $messageType = $request->input('message-type');
                    if ($messageType === 'contact') {
                        $query->where('message_type', 'contact_form');
                    } elseif ($messageType === 'product') {
                        $query->where('message_type', 'product_query');
                    } elseif ($messageType === 'tender') {
                        $query->where('message_type', 'tender_query');
                    } elseif ($messageType === 'quotation') {
                        $query->where('message_type', 'quotation');
                    } elseif ($messageType === 'normal') {
                        $query->where('message_type', 'normal');
                    } elseif ($messageType === 'mail') {
                        $query->where('message_type', 'mail');
                    }
                })
                ->when($request->has('format-type') && $request->input('format-type') !== 'all', function ($query) use ($request) {
                    $formatType = $request->input('format-type');
                    if ($formatType === 'incoming') {
                        $query->where('receiver_id', auth()->user()->id);
                    } elseif ($formatType === 'outgoing') {
                        $query->where('sender_id', auth()->user()->id);
                    }
                })
                ->when(($request->has('date') && $request->input('date') != null && $request->input('date') != ""), function ($query) use ($request) {
                    $date = $request->input('date');
                    $query->whereDate('created_at', $date);
                })
                ->orderByRaw('COALESCE(last_chat_created_at, inbox.created_at) DESC')
                ->paginate(10);
            foreach ($unreadMessages ?? [] as $unMessage) {
                if ($unMessage->sender_id == auth()->user()->id) {
                    $unMessage->isSenderRead = 1;
                } elseif ($unMessage->receiver_id == auth()->user()->id) {
                    $unMessage->isReceiverRead = 1;
                }
                $unMessage->save();
            }

            if (auth()->user()->account_type == "seller") {
                return view('seller-vendor.inbox.my-inbox', compact('allMessages'));
            } else {
                return view('buyer-vendor.inbox.my-inbox', compact('allMessages'));
            }
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Unauthorized access!']);
        }
    }
    public function replyMessage($mail_id)
    {
        if (isset(auth()->user()->id)) {
            $message = inbox::where('id', $mail_id)->with('sender', 'product', 'tender', 'quotation')->first();
            // dd($message->toArray());
            if ($message->receiver_id == auth()->user()->id || $message->sender_id == auth()->user()->id) {
                if ($message->receiver_id == auth()->user()->id) {
                    $message->is_read = true;
                    $message->save();
                }

                // Mark chat messages as read for the current (receiving) user
                ChatMessage::where('message_id', $mail_id)
                    ->where('receiver_id', auth()->id())
                    ->where('is_read', 0)
                    ->update(['is_read' => 1]);

                if (auth()->user()->role == "seller") {
                    return view('seller-vendor.inbox.reply-message', compact('message'));
                } else {
                    return view('buyer-vendor.inbox.reply-message', compact('message'));
                }
            } else {
                return redirect()->route('seller-home')->with(['alert-type' => 'error', 'message' => 'You are not authorized to reply this message!']);
            }
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Unauthorized access!']);
        }
    }
    public function deleteMessage($mail_id)
    {
        if (isset(auth()->user()->id)) {
            $message = inbox::find($mail_id);
            if ($message->receiver_id == auth()->user()->id) {
                $message->delete();
                return redirect()->back();
            } else {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'You are not authorized to delete this message!']);
            }
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Unauthorized access!']);
        }
    }


    // Fetch messages for a specific chat
    public function fetchMessages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|exists:users,id',
            'message_id' => 'required|exists:inbox,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }
        // Mark messages as read for the current user when they load the thread
        ChatMessage::where('message_id', $request->message_id)
            ->where('receiver_id', auth()->id())
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        $messages = ChatMessage::where(function ($query) use ($request) {
            $query->where('sender_id', auth()->user()->id)
                ->where('receiver_id', $request->receiver_id)
                ->where('message_id', $request->message_id);
        })
            ->orWhere(function ($query) use ($request) {
                $query->where('sender_id', $request->receiver_id)
                    ->where('receiver_id', auth()->user()->id)
                    ->where('message_id', $request->message_id);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                $message->created_at_human = $message->created_at->diffForHumans();
                return $message;
            });
        return response()->json([
            'status' => 'success',
            'messages' => $messages,
        ]);
    }

    // Send a new message
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|exists:users,id',
            'message_id' => 'required|exists:inbox,id',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }
        $message = new ChatMessage();
        $message->sender_id = auth()->user()->id;
        $message->receiver_id = $request->receiver_id;
        $message->message = $request->message;
        $message->message_id = $request->message_id;
        $message->is_read = 0;
        $message->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Message sent successfully!',
        ]);
    }
}
