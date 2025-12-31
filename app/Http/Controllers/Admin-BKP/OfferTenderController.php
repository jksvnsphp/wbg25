<?php

namespace App\Http\Controllers;

use App\Models\CounterOfferTender;
use App\Models\OfferTender;
use App\Models\seller_package;
use App\Models\Tender;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OfferTenderController extends Controller
{
    //
    public function sendOffer(Request $request)
    {
        if (isset(auth()->user()->id)) {
            if (isset($request->offer_price) && $request->offer_price > 0) {
                $validate = Validator::make($request->all(), [
                    'tender_id' => 'required|exists:tenders,id',
                    'offer_price' => 'required|numeric|min:1',
                ]);
                if ($validate->fails()) {
                    return response()->json(['status' => false, 'message' => 'Validation failed!', 'error' => $validate->errors()], 200);
                } else {
                    $tender = Tender::where('id', $request->tender_id)->first();
                    if ($tender) {
                        if ($tender->vendor_id == Auth::user()->id) {
                            return response()->json(['status' => false, 'message' => 'You are the owner of this tender'], 200);
                        }
                        $offer = OfferTender::where('tender_id', $request->tender_id)->where('user_id', Auth::user()->id)->first();
                        if (!$offer) {
                            OfferTender::create([
                                'user_id' => Auth::user()->id,
                                'vendor_id' => $tender->vendor_id,
                                'tender_id' => $request->tender_id,
                                'offer_price' => $request->offer_price,
                                'status' => 'pending',
                            ]);
                            // send mail to seller
                            $seller = User::where('id', $tender->vendor_id)->first();
                            $sellerMail = $seller->email;
                            $sellerName = $seller->first_name;
                            $offerPrice = $request->offer_price;
                            $tenderPrice = $tender->price;
                            $tenderName = $tender->name;
                            $seller_subject = "New Offer on $tenderName";
                            $seller_message = 'You have a new offer on your tender' . $tender->title;
                            $image = asset('uploads/tender/' . $tender->image_1);
                            $btnText = 'View Offer';
                            $btnUrl = route('show.tender', $tender->slug);
                            $mailData = [
                                'seller_name' => $sellerName,
                                'seller_subject' => $seller_subject,
                                'seller_message' => $seller_message,
                                'image' => $image,
                                'btnText' => $btnText,
                                'btnUrl' => $btnUrl,
                                'tenderName' => $tenderName,
                                'offer_price' => $offerPrice,
                                'tenderPrice' => $tenderPrice,
                                'user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
                                'user_email' => auth()->user()->email,
                            ];
                            Mail::send('mail.tender-offer', $mailData, function ($message) use ($sellerMail, $seller_subject) {
                                $message->to($sellerMail);
                                $message->subject($seller_subject);
                            });
                            session()->flash('success', 'Congratulation, Your offer on tender has been successfully sent!');
                            if (auth()->user()->account_type == "seller") {
                                $rurl = route('seller.success.offer.tender', $tender->slug);
                            } else {
                                $rurl = route('buyer.success.offer.tender', $tender->slug);
                            }
                            return response()->json([
                                'status' => true,
                                'message' => 'Your offer has been submitted successfully!',
                                'url' => $rurl
                            ], 200);
                        } else {
                            return response()->json(['status' => false, 'message' => 'You have already submitted
                            an offer for this tender'], 200);
                        }
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Tender not found!',
                        ], 200);
                    }
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'You are not allowed to submit an offer for this tender. Offer price should be greater than 0',
                ], 200);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'You must be logged in to submit an offer!',
                'code' => 403
            ], 200);
        }
    }

    public function offeredTender()
    {
        if (isset(auth()->user()->id)) {
            $user = auth()->user();
            $tenders = OfferTender::latest()
                                  ->where('user_id', $user->id)
                                  ->where('status','pending')
                                  ->with('tender.vendor')
                                  ->doesntHave('counters')
                                  ->get();
                                  
            $unTenders = OfferTender::latest()
                                    ->where('user_id', $user->id)
                                    ->where('status','pending')
                                    ->where('isUserRead',0)
                                    ->get();
                                              
            foreach ($unTenders ?? [] as $unTender){
                $unTender->isUserRead=1;
                $unTender->save();
            }
            
            return view('buyer-vendor.offered-tender', compact('tenders'));
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    
    public function dealOfferTender()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $tenders = OfferTender::where(function ($query) {
                                 $query->where(function ($q) {
                                       $q->where('vendor_id', auth()->id());
                                 }
                                )->orWhere(function ($q){
                                   $q->where('user_id', auth()->id());
                                 });
                               })->where('status', 'accept')->with('tender.vendor', 'sender')->get();
            $unTenders = OfferTender::where(function ($query) {
                                 $query->where(function ($q) {
                                       $q->where('vendor_id', auth()->id())->where('isVendorDealRead', 0);
                                 })->orWhere(function ($q){
                                   $q->where('user_id', auth()->id())->where('isUserDealRead', 0);
                                 });
                               })->where('status', 'accept')->get();
                               
            foreach ($unTenders ?? [] as $tender) {
              if ($tender->vendor_id === auth()->id() && $tender->isVendorDealRead == 0) {
                  $tender->isVendorDealRead = 1;
                  $tender->save();
              }

             if ($tender->user_id === auth()->id() && $tender->isUserDealRead == 0) {
                 $tender->isUserDealRead = 1;
                  $tender->save();
             }
            }

            if (auth()->user()->account_type == "seller") {
                return view('seller-vendor.tenders.my-deal-tenders', compact('tenders'));
            } else {
                return view('buyer-vendor.my-deal-tenders', compact('tenders'));
            }
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    
    public function dealMyOfferTender()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $tenders = OfferTender::where('vendor_id', auth()->id())->where('status', 'accept')->with('tender.vendor', 'sender')->get();
                               
            if (auth()->user()->account_type == "seller") {
                return view('seller-vendor.tenders.my-deal-tenders', compact('tenders'));
            } else {
                return view('buyer-vendor.my-deal-tenders', compact('tenders'));
            }
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function dealSupplierOfferTender()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $tenders = OfferTender::where('user_id', auth()->id())->where('status', 'accept')->with('tender.vendor', 'sender')->get();
            

            if (auth()->user()->account_type == "seller") {
                return view('seller-vendor.tenders.my-deal-tenders', compact('tenders'));
            } else {
                return view('buyer-vendor.my-deal-tenders', compact('tenders'));
            }
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

  public function dealTenderDetail($slug, $offer_id)
    {
        $id=Auth::user()->id;
        $tenderOffer = OfferTender::where(function ($query) use ($id) {
            $query->where('user_id', $id)
                ->orWhere('vendor_id', $id);
        })->where('status', 'accept')->where('id',$offer_id)->with('tender.vendor.payment_infos', 'sender')->first();
        
        $tender=Tender::where('slug', $slug)->first();
        if(!$tender){
            return back()->with(['alert-type'=>'error','message'=>'Tender not found!']);
        }
        return view('buyer-vendor.tender-deal-detail',compact('tenderOffer','tender'));
    }

    public function receivedOfferTender()
    {
        if (isset(auth()->user()->id)) {
            $receivedOffers = OfferTender::with('tender', 'sender')->where('vendor_id', auth()->user()->id)->where('status','pending')->doesntHave('counters')->get();
            
            $unReceivedOffers = OfferTender::with('tender', 'sender')->where('vendor_id', auth()->user()->id)->where('status','pending')->where('isVendorRead',0)->get();
            
            foreach ($unReceivedOffers ?? [] as $unReceivedOffer){
                $unReceivedOffer->isVendorRead=1;
                $unReceivedOffer->save();
            }
            return view('seller-vendor.tenders.my-received-offer-tender', compact('receivedOffers'));
        } else {
            return back()->with(['alert-type' => 'unauth', 'message' => 'You must be logged in to access this page!']);
        }
    }


    public function deleteOfferTenderBySeller(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $tender = OfferTender::where('id', $request->offer_id)->where('vendor_id', auth()->user()->id)->first();
            if ($tender) {
                $tender->delete();
                return redirect()->back()->with([
                    'alert-type' => "success",
                    'message' => 'Tender Offer deleted successfully!'
                ]);
            }
            return redirect()->back()->with([
                'alert-type' => "error",
                'message' => 'Failed to delete tender offer.'
            ]);
        } else {
            return redirect()->back()->with([
                'alert-type' => "error",
                'message' => 'Unauthrized delete action'
            ]);
        }
    }

    public function acceptOfferTenderBySeller(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $tender = OfferTender::where('id', $request->offer_id)->where('tender_id', $request->tender_id)->first();
            if ($tender->vendor_id == auth()->user()->id) {
                $tender->status = "accept";
                $tender->counter_price = $tender->offer_price;
                $tender->save();
                
                $tenderMain=Tender::where('id',$request->tender_id)->first();
                // dd($tenderMain);
                $tenderMain->isDeal=1;
                $tenderMain->save();
                
                $otherTenders = OfferTender::where('id', '!=', $tender->id)->where('tender_id', $request->tender_id)->where('vendor_id', auth()->user()->id)->get();
                foreach ($otherTenders as $otherTender) {
                    $otherTender->status = "reject";
                    $otherTender->save();
                }
                return response()->json(['success' => true, 'message' => 'Successfully accept your tender offer!']);
            } else {
                return response()->json(['success' => false,  'message' => 'You are not authorized to accept this tender!']);
            }
        } else {
            return response()->json(['success' => false,  'message' => 'You must be logged in to access this page!']);
        }
    }

    public function acceptCounterOfferTender(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $tender = OfferTender::where('id', $request->offer_id)->where('tender_id', $request->tender_id)->first();
            if (isset($tender->user_id) && $tender->user_id == auth()->user()->id) {
                $counterOffer = CounterOfferTender::where('id', $request->counter_id)->first();
                if ($counterOffer->status == 'pending') {
                    $counterOffer->status = "accept";
                    $counterOffer->save();
                    
                    $tenderMain=Tender::where('id',$tender->tender_id)->first();
                    $tenderMain->isDeal=1;
                    $tenderMain->save();
                    
                    $tender->status = "accept";
                    $tender->counter_price = $counterOffer->offer_price;
                    $tender->save();
                    
                    $otherTenders = OfferTender::where('id', '!=', $tender->id)->where('tender_id', $request->tender_id)->where('vendor_id', auth()->user()->id)->get();
                    foreach ($otherTenders as $otherTender) {
                        $otherTender->status = "reject";
                        $otherTender->save();
                        $counterOffers = CounterOfferTender::where('tender_id', $otherTender->tender_id)->get();
                        foreach ($counterOffers ?? [] as $cOffer) {
                            $cOffer->delete();
                        }
                    }
                }
                
                return response()->json(['success' => true, 'message' => 'Successfully accept your tender offer!']);
            } else {
                return response()->json(['success' => false,  'message' => 'You are not authorized to delete this quote!']);
            }
        } else {
            return response()->json(['success' => false,  'message' => 'You must be logged in to access this page!']);
        }
    }
    
    public function rejectOfferTenderBySeller(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $tender = OfferTender::where('id', $request->offer_id)->where('tender_id', $request->tender_id)->first();
            if ($tender->vendor_id == auth()->user()->id) {
                $tender->status = "reject";
                $tender->save();
                $counterOffers = CounterOfferTender::where('tender_id', $tender->tender_id)->where('offer_id', $tender->id)->get();
                foreach ($counterOffers ?? [] as $cOffer) {
                    $cOffer->delete();
                }
                return response()->json(['success' => true, 'message' => 'Successfully reject your tender offer!']);
            } else {
                return response()->json(['success' => false,  'message' => 'You are not authorized to reject this tender!']);
            }
        } else {
            return response()->json(['success' => false,  'message' => 'You must be logged in to access this page!']);
        }
    }


    public function rejectCounterOfferTender(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $tender = OfferTender::where('id', $request->offer_id)->where('tender_id', $request->tender_id)->first();
            if (isset($tender->user_id) && $tender->user_id == auth()->user()->id) {
                $counterOffer = CounterOfferTender::where('id', $request->counter_id)->first();
                if ($counterOffer->status == 'pending') {
                    $counterOffer->status = "reject";
                    $counterOffer->save();
                    $tender->status = "reject";
                    $tender->save();
                }
                return response()->json(['success' => true, 'message' => 'Successfully reject your tender offer!']);
            } else {
                return response()->json(['success' => false,  'message' => 'You are not authorized to delete this quote!']);
            }
        } else {
            return response()->json(['success' => false,  'message' => 'You must be logged in to access this page!']);
        }
    }

    public function sendCounterOfferTender(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $rules = [
                'counter_price' => 'required|numeric|min:0',
                'offer_id' => 'required|exists:offer_tenders,id',
                'tender_id' => 'required|exists:tenders,id',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Something went to wrong!']);
            } else {
                $tender = OfferTender::where('id', $request->offer_id)->where('tender_id', $request->tender_id)->first();
                if (isset($tender->vendor_id) && $tender->vendor_id == auth()->user()->id) {
                    $checkCountForUser = CounterOfferTender::where('offer_id', $tender->id)->where('user_id', $tender->user_id)->first();
                    if (!$checkCountForUser) {
                        $checkCountForUser = new CounterOfferTender();
                    }
                    $checkCountForUser->offer_id = $tender->id;
                    $checkCountForUser->tender_id = $tender->tender_id;
                    $checkCountForUser->user_id = $tender->user_id;
                    $checkCountForUser->offer_price = $request->counter_price;
                    $checkCountForUser->status = 'pending';
                    $checkCountForUser->save();
                    return response()->json(['status' => true, 'message' => 'Counter offer sent successfully']);
                } else {
                    return response()->json(['status' => false, 'message' => 'You are not authorized to send counter offer!']);
                }
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first!']);
        }
    }

    public function counterOffersTender()
    {
        if (isset(auth()->user()->id)) {
            $user = auth()->user();
            $tenders = CounterOfferTender::latest()->where('user_id', $user->id)->where('status', 'pending')->with('tender', 'offer.sender')->get();
            $unTenders = CounterOfferTender::latest()->where('user_id', $user->id)->where('status', 'pending')->where('isUserRead',0)->with('tender', 'offer.sender')->get();
            foreach ($unTenders ?? [] as $unTender){
                $unTender->isUserRead=1;
                $unTender->save();
            }
            if (auth()->user()->account_type == "seller") {
                return view('seller-vendor.tenders.my-received-counter-offers', compact('tenders'));
            } else {
                return view('buyer-vendor.tender-counter-offers', compact('tenders'));
            }
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function myCountersOffersTender()
    {
        if (isset(auth()->user()->id)) {
            $user = auth()->user();
            
            $tenders = CounterOfferTender::latest()->whereHas('offer', function ($query) use ($user) {
                $query->where('vendor_id', $user->id);
            })->where('status', 'pending')->with('tender', 'offer.sender')->get();
            
            $unTenders = CounterOfferTender::latest()->whereHas('offer', function ($query) use ($user) {
                $query->where('vendor_id', $user->id);
            })->where('status', 'pending')->where('isVendorRead',0)->get();
            
            foreach ($unTenders ?? [] as $unTender){
                $unTender->isVendorRead=1;
                $unTender->save();
            }
            
            if (auth()->user()->account_type == "seller") {
                return view('seller-vendor.tenders.my-counters-offer-tender', compact('tenders'));
            }
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Something went to wrong.']);
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function deleteTenderOffer(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $tender = OfferTender::where('id', $request->offer_id)->where('user_id', auth()->user()->id)->first();
            if ($tender) {
                $tender->delete();
                return redirect()->back()->with([
                    'alert-type' => "success",
                    'message' => 'Tender Offer deleted successfully!'
                ]);
            }
            return redirect()->back()->with([
                'alert-type' => "error",
                'message' => 'Failed to delete tender offer.'
            ]);
        } else {
            return redirect()->back()->with([
                'alert-type' => "error",
                'message' => 'Unauthrized delete action'
            ]);
        }
    }
    
    public function deleteCounterOfferTender(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $tender = CounterOfferTender::where('id', $request->counter_id)->whereHas('offer', function ($query) {
                $query->where('vendor_id', auth()->user()->id);
            })->first();
            if ($tender) {
                $tender->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Tender Counter Offer deleted successfully!'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Tender counter offer not found!'
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Unauthrized delete action!'
            ]);
        }
    }
    public function deleteReceiveCounterOfferTender(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $tender = CounterOfferTender::where('id', $request->counter_id)->where('user_id', auth()->user()->id)->first();
            if ($tender) {
                $tender->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Tender Counter Offer deleted successfully!'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Tender counter offer not found!'
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Unauthrized delete action!'
            ]);
        }
    }
    public function directOrder(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $validate = Validator::make($request->all(), [
                'tender_id' => 'required|exists:tenders,id'
            ]);
            if ($validate->fails()) {
                return response()->json(['status' => false, 'message' => 'Validation failed!', 'error' => $validate->errors()], 200);
            } else {
                $tender = Tender::where('id', $request->tender_id)->first();
                if ($tender) {
                    if ($tender->vendor_id == Auth::user()->id) {
                        return response()->json(['status' => false, 'message' => 'You are the owner of this tender'], 200);
                    }
                    $offer = OfferTender::where('tender_id', $request->tender_id)->where('user_id', Auth::user()->id)->first();
                    if (!$offer) {
                        
                        $offerTend=OfferTender::create([
                            'user_id' => Auth::user()->id,
                            'vendor_id' => $tender->vendor_id,
                            'tender_id' => $request->tender_id,
                            'offer_price' => $tender->price,
                            'status' => 'accept',
                        ]);
                        
                        
                        $tender->isDeal=1;
                        $tender->save();
                        
                        $getOtherOffer=OfferTender::where('id','!=',$offerTend->id)->where('tender_id',$request->tender_id)->get();
                        foreach ($getOtherOffer ?? [] as $offerTender){
                            $offerTender->delete();
                        }
                        
                        // send mail to seller
                        $seller = User::where('id', $tender->vendor_id)->first();
                        $sellerMail = $seller->email;
                        $sellerName = $seller->first_name;
                        $offerPrice = $tender->price;
                        $tenderPrice = $tender->price;
                        $tenderName = $tender->name;
                        $seller_subject = "New Offer on $tenderName";
                        $seller_message = 'You have a new deal on your tender' . $tender->title;
                        $image = asset('uploads/tender/' . $tender->image_1);
                        $btnText = 'View Offer';
                        $btnUrl = route('show.tender', $tender->slug);
                        $mailData = [
                            'seller_name' => $sellerName,
                            'seller_subject' => $seller_subject,
                            'seller_message' => $seller_message,
                            'image' => $image,
                            'btnText' => $btnText,
                            'btnUrl' => $btnUrl,
                            'tenderName' => $tenderName,
                            'offer_price' => $offerPrice,
                            'tenderPrice' => $tenderPrice,
                            'user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
                            'user_email' => auth()->user()->email,
                        ];
                        Mail::send('mail.tender-offer', $mailData, function ($message) use ($sellerMail, $seller_subject) {
                            $message->to($sellerMail);
                            $message->subject($seller_subject);
                        });
                        session()->flash('success', 'Congratulation, Your deal on tender has been successfully sent! Now go to your cart');
                        if (auth()->user()->account_type == "seller") {
                            $rurl = route('seller.success.offer.tender', $tender->slug);
                        } else {
                            $rurl = route('buyer.success.offer.tender', $tender->slug);
                        }
                        return response()->json([
                            'status' => true,
                            'message' => 'Your deal has been submitted successfully!',
                            'url' => $rurl
                        ], 200);
                    } else {
                        return response()->json(['status' => false, 'message' => 'You have already submitted
                            an offer for this tender'], 200);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tender not found!',
                    ], 200);
                }
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'You must be logged in to submit an offer!',
                'code' => 403
            ], 200);
        }
    }

    public function successTenderOfferPage($slug = null)
    {
        if (isset(auth()->user()->id) && session()->has('success')) {
            $message = session('success');
            if (auth()->user()->account_type == "seller") {
                $seller = User::where('id', auth()->user()->id)->first();
                $packageData = seller_package::latest()->where('seller_id', $seller->id)->with('package')->first();
                return view('seller-vendor.success-vendor-profile', compact('seller', 'packageData', 'message'));;
            } else {
                $buyer = User::where('id', auth()->user()->id)->first();
                return view('buyer-vendor.buyer-success', compact('buyer', 'message'));;
            }
        } else {
            return redirect()->route('home');
        }
    }
}
