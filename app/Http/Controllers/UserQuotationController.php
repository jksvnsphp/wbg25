<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\OfferQuotation;
use Illuminate\Support\Carbon;
use App\Models\CustomeCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use App\Models\CounterOfferQuotation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
//use Carbon\Carbon;
class UserQuotationController extends Controller
{
    private function createUniqueSlug($title, $id = null)
    {

        $slug = Str::slug($title);
        if ($id) {
            $existing = Quotation::find($id);
            if ($existing && $existing->slug === $slug) {
                return $slug;
            }
        }
        $count = Quotation::where('slug', 'LIKE', "{$slug}%")
            ->when($id, function ($query) use ($id) {
                return $query->where('id', '!=', $id);
            })
            ->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function getQuotePage()
    {
        $categories = CustomeCategory::where('status', 1)
            ->where('deleted', '0')
            ->where('parent_id', '0')
            ->orderBy('category_name', 'ASC')
            ->get();

        return view('external-user.get-quote', compact('categories'));
    }


    public function getAllQuotePage()
    {
        $categories = CustomeCategory::where('status', 1)
            ->where('deleted', '0')
            ->where('parent_id', '0')
            ->orderBy('category_name', 'ASC')
            ->get();

        return view('external-user.get-quote', compact('categories'));
    }
    ///getAllQuotePage
    public function editQuotation($quotation_id)
    {
        $quotation = Quotation::where('id', $quotation_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$quotation) {
            return back()->with(['alert-type' => 'error', 'message' => 'Quotation not found!']);
        }

        // Check if expired
        $expiryDate = Carbon::parse($quotation->created_at)->addDays($quotation->duration);
        if ($expiryDate->isPast()) {
            // Relist quotation from today
            $quotation->created_at = Carbon::now();

            // Optional: reset is_expired flag if exists
            if (Schema::hasColumn('quotations', 'is_expired')) {
                $quotation->is_expired = 0;
            }

            $quotation->save();
        }

        $categories = CustomeCategory::where('status', 1)
            ->where('deleted', '0')
            ->where('parent_id', '0')
            ->orderBy('category_name', 'ASC')
            ->get();

        return view('seller-vendor.quotations.edit-quotation', compact('quotation', 'categories'));
    }

    public function editQuotationold($quotation_id)
    {
        $quotation = Quotation::where('id', $quotation_id)->where('user_id', Auth::user()->id)->first();
        $categories = CustomeCategory::where('status', 1)
            ->where('deleted', '0')
            ->where('parent_id', '0')
            ->orderBy('category_name', 'ASC')
            ->get();
        if (!empty($quotation)) {
            return view('seller-vendor.quotations.edit-quotation', compact('quotation', 'categories'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Quotation not found!']);
        }
    }


    public function updateQuotation(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $rules = [
                'id' => 'required|exists:quotations,id',
                'product_service' => 'required|string',
                'requirement_details' => 'required|string',
                'quantity' => 'required',
                'required_price' => 'required|numeric',
                'category' => 'required|integer',
                'subcategory' => 'nullable|integer',
                'type' => 'required|string',
                'duration' => 'required|numeric',
                'image_1' => 'nullable|image',
                'image_2' => 'nullable|image',
                'image_3' => 'nullable|image',
                'image_4' => 'nullable|image',
                'captcha' => ['required', 'captcha']
            ];
            $errormgs = [
                'captcha' => 'The CAPTCHA verification failed. Please try again.',
            ];
            $validator = Validator::make($request->all(), $rules, $errormgs);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Please fill all required fieled!']);
            } else {
                $quotation = Quotation::where('id', $request->id)->first();
                if ($quotation) {
                    $quotation->product_service = $request->input('product_service');
                    $quotation->slug = $this->createUniqueSlug($request->product_service);
                    $quotation->requirement_details = $request->input('requirement_details');
                    $quotation->quantity = $request->input('quantity');
                    $quotation->price = $request->input('required_price');
                    $quotation->category_id = $request->input('category');
                    $quotation->subcategory_id = $request->input('subcategory');
                    $quotation->type = $request->input('type');
                    if ($request->duration != $quotation->duration) {
                        $quotation->duration = $request->duration;
                        $quotation->created_at = Carbon::now();
                    }
                    $manager = new ImageManager(['driver' => 'gd']);
                    for ($i = 1; $i <= 4; $i++) {
                        if ($request->hasfile('image_' . $i)) {
                            $image = $request->file('image_' . $i);
                            $ext = $image->getClientOriginalExtension();
                            $fileName = uniqid() . '_' . time() . '.' . $ext;
                            $manager->make($image)->resize(480, 360)->save(public_path('uploads/quotation/' . $fileName));
                            $quotation['image_' . $i] = $fileName;
                            $quotation->save();
                        }
                    }
                    $quotation->save();
                    session()->flash('success', 'Congratulation, Your quotation has been relist and published and online now!');
                    if (auth()->user()->account_type == "seller") {
                        return redirect()->route('seller.success.offer.tender', $quotation->slug)->with(['alert-type' => 'success', 'message' => 'Successfully update your data!']);
                    } else {
                        return redirect()->route('buyer.success.offer.tender', $quotation->slug)->with(['alert-type' => 'success', 'message' => 'Successfully update your data!']);
                    }
                } else {
                    return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Quotation not found!']);
                }
            }
        } else {
            return back()->with(['alert-type' => 'unauth', 'message' => 'You must be logged in to access this page!']);
        }
    }
    public function sendGetQuotes(Request $request)
    {

        // dd($request->captcha);
        if (isset(auth()->user()->id)) {
            $rules = [
                'product_service' => 'required|string',
                'requirement_details' => 'required|string',
                'quantity' => 'required',
                'required_price' => 'required|numeric',
                'category' => 'required|integer',
                'subcategory' => 'nullable|integer',
                'type' => 'required|string',
                'duration' => 'required|numeric',
                'image_1' => 'required|image',
                'image_2' => 'nullable|image',
                'image_3' => 'nullable|image',
                'image_4' => 'nullable|image',
                'captcha' => ['required', 'captcha']
            ];
            $errormgs = [
                'captcha' => 'The CAPTCHA verification failed. Please try again.',
            ];
            $validator = Validator::make($request->all(), $rules, $errormgs);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Please fill all required fieled!']);
            } else {
                $quotation = new Quotation();
                $quotation->product_service = $request->input('product_service');
                $quotation->slug = $this->createUniqueSlug($request->product_service);
                $quotation->requirement_details = $request->input('requirement_details');
                $quotation->quantity = $request->input('quantity');
                $quotation->price = $request->input('required_price');
                $quotation->category_id = $request->input('category');
                $quotation->subcategory_id = $request->input('subcategory');
                $quotation->type = $request->input('type');
                $quotation->duration = $request->input('duration');
                $quotation->user_id = auth()->user()->id;
                // save four images use loop image_1, image_2...
                $manager = new ImageManager(['driver' => 'gd']);
                for ($i = 1; $i <= 4; $i++) {
                    if ($request->hasfile('image_' . $i)) {
                        $image = $request->file('image_' . $i);
                        $ext = $image->getClientOriginalExtension();
                        $fileName = uniqid() . '_' . time() . '.' . $ext;
                        $manager->make($image)->resize(480, 360)->save(public_path('uploads/quotation/' . $fileName));
                        $quotation['image_' . $i] = $fileName;
                        $quotation->save();
                    }
                }
                $quotation->save();
                session()->flash('success', 'Congratulation, Your quotation has been published and online now!');
                if (auth()->user()->account_type == "seller") {
                    return redirect()->route('seller.success.offer.tender', $quotation->slug)->with(['alert-type' => 'success', 'message' => 'Successfully saved your data!']);
                } else {
                    return redirect()->route('buyer.success.offer.tender', $quotation->slug)->with(['alert-type' => 'success', 'message' => 'Successfully saved your data!']);
                }
            }
        } else {
            return back()->with(['alert-type' => 'unauth', 'message' => 'You must be logged in to access this page!']);
        }
    }

    public function myquotations()
    {
        if (isset(auth()->user()->id)) {
            $quotations = Quotation::latest()
                ->where('user_id', auth()->user()->id)
                ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])
                ->with('category')
                ->get();
            $unQuotations = Quotation::latest()
                ->where('user_id', auth()->user()->id)
                ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])
                ->get();
            foreach ($unQuotations ?? [] as $unQuotation) {
                $unQuotation->isRead = 1;
                $unQuotation->save();
            }
            return view('seller-vendor.quotations.my-posted-quotations', compact('quotations'));
        } else {
            return back()->with(['alert-type' => 'unauth', 'message' => 'You must be logged in to access this page!']);
        }
    }

    public function myReceivedQuotes()
    {
        if (isset(auth()->user()->id)) {
            $receivedOffers = OfferQuotation::with('sender')
                ->where('vendor_id', auth()->user()->id)
                ->where('status', 'pending')
                ->doesntHave('counters')
                ->get();
            $unReceivedOffers = OfferQuotation::with('sender')
                ->where('vendor_id', auth()->user()->id)
                ->where('status', 'pending')
                ->where('isVendorRead', 0)
                ->doesntHave('counters')
                ->get();
            foreach ($unReceivedOffers ?? [] as $unReceivedOffer) {
                $unReceivedOffer->isVendorRead = 1;
                $unReceivedOffer->save();
            }
            if (auth()->user()->account_type == "seller") {
                return view('seller-vendor.quotations.my-received-quotation', compact('receivedOffers'));
            } else {
                return view('buyer-vendor.quotation-management.my-received-quotation', compact('receivedOffers'));
            }
        } else {
            return back()->with(['alert-type' => 'unauth', 'message' => 'You must be logged in to access this page!']);
        }
    }

    public function myExpiredQuotations()
    {
        if (isset(auth()->user()->id)) {
            $quotations = Quotation::latest()
                ->where('user_id', auth()->user()->id)
                ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) < ?', [Carbon::now()])
                ->with('category')
                ->get();
            $unQuotations = Quotation::latest()
                ->where('user_id', auth()->user()->id)
                ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) < ?', [Carbon::now()])
                ->get();
            foreach ($unQuotations ?? [] as $unQuotation) {
                $unQuotation->isRead = 1;
                $unQuotation->save();
            }
            return view('seller-vendor.quotations.my-posted-quotations', compact('quotations'));
        } else {
            return back()->with(['alert-type' => 'unauth', 'message' => 'You must be logged in to access this page!']);
        }
    }
    public function myDeleteQuotation(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $quotation = Quotation::where('id', $request->quotation_id)->first();
            if ($quotation->user_id == auth()->user()->id) {
                for ($i = 1; $i <= 4; $i++) {
                    $imagePath = public_path('uploads/quotation/' . $quotation->image . '_' . $i);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                }
                $quotation->delete();
                return response()->json(['success' => true, 'message' => 'Successfully deleted your quotation!']);
            } else {
                return response()->json(['success' => false, 'message' => 'You are not authorized to delete this quotation!']);
            }
        } else {
            return response()->json(['success' => false,  'message' => 'You must be logged in to access this page!']);
        }
    }
    public function myDeleteQuote(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $quotation = OfferQuotation::where('id', $request->quotation_id)->first();
            if ($quotation->user_id == auth()->user()->id) {
                $quotation->delete();
                return response()->json(['success' => true, 'message' => 'Successfully deleted your quote!']);
            } else {
                return response()->json(['success' => false,  'message' => 'You are not authorized to delete this quote!']);
            }
        } else {
            return response()->json(['success' => false,  'message' => 'You must be logged in to access this page!']);
        }
    }
    public function myDeleteReceivedQuotation(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $quotation = OfferQuotation::where('id', $request->quotation_id)->first();
            if ($quotation->vendor_id == auth()->user()->id) {
                $quotation->delete();
                return response()->json(['success' => true, 'message' => 'Successfully deleted your quote offer!']);
            } else {
                return response()->json(['success' => false,  'message' => 'You are not authorized to delete this quote!']);
            }
        } else {
            return response()->json(['success' => false,  'message' => 'You must be logged in to access this page!']);
        }
    }
    public function acceptQuoteOffer(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $quotation = OfferQuotation::where('id', $request->quote_id)->where('quotation_id', $request->quotation_id)->first();
            if ($quotation->vendor_id == auth()->user()->id) {
                $quotation->status = "accept";
                $quotation->counter_price = $quotation->offer_price;
                $quotation->save();

                $otherQuotations = OfferQuotation::where('id', '!=', $quotation->id)->where('quotation_id', $request->quotation_id)->where('vendor_id', auth()->user()->id)->get();
                foreach ($otherQuotations as $otherQuotation) {
                    $otherQuotation->status = "reject";
                    $otherQuotation->save();
                }

                return response()->json(['success' => true, 'message' => 'Successfully accept your quote offer!']);
            } else {
                return response()->json(['success' => false,  'message' => 'You are not authorized to accept this quote!']);
            }
        } else {
            return response()->json(['success' => false,  'message' => 'You must be logged in to access this page!']);
        }
    }

    public function mySubmittedQuotes()
    {
        if (isset(auth()->user()->id)) {
            $user = auth()->user();
            $quotations = OfferQuotation::latest()->where('user_id', $user->id)->with('quotation.vendor')->where('status', 'pending')->get();

            $unQuotations = OfferQuotation::latest()->where('user_id', $user->id)->where('status', 'pending')->where('isUserRead', 0)->get();
            foreach ($unQuotations ?? [] as $unQuotation) {
                $unQuotation->isUserRead = 1;
                $unQuotation->save();
            }
            return view('seller-vendor.quotations.my-submitted-quotes', compact('quotations'));
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }


    public function sendQuoteCounterOffer(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $rules = [
                'counter_price' => 'required|numeric|min:0',
                'quote_id' => 'required|exists:offer_quotations,id',
                'quotation_id' => 'required|exists:quotations,id',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Something went to wrong!']);
            } else {
                $quotation = OfferQuotation::where('id', $request->quote_id)->where('quotation_id', $request->quotation_id)->first();
                if (isset($quotation->vendor_id) && $quotation->vendor_id == auth()->user()->id) {
                    $checkCountForUser = CounterOfferQuotation::where('quote_id', $quotation->id)->where('user_id', $quotation->user_id)->first();
                    if (!$checkCountForUser) {
                        $checkCountForUser = new CounterOfferQuotation();
                    }
                    $checkCountForUser->quote_id = $quotation->id;
                    $checkCountForUser->quotation_id = $quotation->quotation_id;
                    $checkCountForUser->user_id = $quotation->user_id;
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

    public function counterOffers()
    {
        if (isset(auth()->user()->id)) {
            $user = auth()->user();
            $quotations = CounterOfferQuotation::latest()->where('user_id', $user->id)->where('status', 'pending')->with('quotation.vendor.company', 'offer.sender')->get();
            $unQuotations = CounterOfferQuotation::latest()->where('user_id', $user->id)->where('status', 'pending')->where('isUserRead', 0)->get();
            foreach ($unQuotations ?? [] as $unQuotation) {
                $unQuotation->isUserRead = 1;
                $unQuotation->save();
            }
            if (auth()->user()->account_type == "seller") {
                return view('seller-vendor.quotations.my-received-counter-quotations', compact('quotations'));
            } else {
                return view('buyer-vendor.quotation-management.my-received-counter-quotations', compact('quotations'));
            }
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function myCounterQuotes()
    {
        if (isset(auth()->user()->id)) {
            $user = auth()->user();

            $quotations = CounterOfferQuotation::latest()->whereHas('offer', function ($query) use ($user) {
                $query->where('vendor_id', $user->id);
            })->where('status', 'pending')->with('quotation', 'offer.sender', 'user')->get();

            $unQuotations = CounterOfferQuotation::latest()->whereHas('offer', function ($query) use ($user) {
                $query->where('vendor_id', $user->id);
            })->where('isVendorRead', 0)->where('status', 'pending')->get();

            foreach ($unQuotations ?? [] as $unQuotation) {
                $unQuotation->isVendorRead = 1;
                $unQuotation->save();
            }

            if (auth()->user()->account_type == "seller") {
                return view('seller-vendor.quotations.my-counter-quotations', compact('quotations'));
            } else {
                return view('buyer-vendor.quotation-management.my-counter-quotations', compact('quotations'));
            }
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function dealQuotes()
    {

        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $quotations = OfferQuotation::where(function ($query) use ($id) {
                $query->where('user_id', $id)
                    ->orWhere('vendor_id', $id);
            })->where('status', 'accept')->with('quotation.vendor', 'sender')->get();

            $unQuotations = OfferQuotation::where(function ($query) {
                $query->where(function ($q) {
                    $q->where('vendor_id', auth()->id())->where('isVendorDealRead', 0);
                })->orWhere(function ($q) {
                    $q->where('user_id', auth()->id())->where('isUserDealRead', 0);
                });
            })->where('status', 'accept')->get();
            foreach ($unQuotations ?? [] as $unQuotation) {
                if ($unQuotation->vendor_id === auth()->id() && $unQuotation->isVendorDealRead == 0) {
                    $unQuotation->isVendorDealRead = 1;
                    $unQuotation->save();
                }

                if ($unQuotation->user_id === auth()->id() && $unQuotation->isUserDealRead == 0) {
                    $unQuotation->isUserDealRead = 1;
                    $unQuotation->save();
                }
            }

            if (auth()->user()->account_type == "seller") {
                return view('seller-vendor.quotations.my-quotation-deals', compact('quotations'));
            } else {
                return view('buyer-vendor.quotation-management.my-quotation-deals', compact('quotations'));
            }
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function dealSupplierQuotes()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $quotations = OfferQuotation::where('user_id', $id)->where('status', 'accept')->with('quotation.vendor', 'sender')->get();

            if (auth()->user()->account_type == "seller") {
                return view('seller-vendor.quotations.my-quotation-deals', compact('quotations'));
            } else {
                return view('buyer-vendor.quotation-management.my-quotation-deals', compact('quotations'));
            }
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function dealMyQuotes()
    {

        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $quotations = OfferQuotation::where('vendor_id', $id)->where('status', 'accept')->with('quotation.vendor', 'sender')->get();

            if (auth()->user()->account_type == "seller") {
                return view('seller-vendor.quotations.my-quotation-deals', compact('quotations'));
            } else {
                return view('buyer-vendor.quotation-management.my-quotation-deals', compact('quotations'));
            }
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function dealQuotesDetails($slug, $offer_id)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $quotationOffer = OfferQuotation::where(function ($query) use ($id) {
                $query->where('user_id', $id)
                    ->orWhere('vendor_id', $id);
            })->where('status', 'accept')->where('id', $offer_id)->with('quotation.vendor.payment_infos', 'sender')->first();

            $quotation = Quotation::where('slug', $slug)->first();

            if (!$quotation) {
                return back()->with(['alert-type' => 'error', 'message' => 'Quotation not found!']);
            }
            if (auth()->user()->account_type == "seller") {
                return view('seller-vendor.quotations.quotation-deal-details', compact('quotationOffer', 'quotation'));
            } else {
                return view('buyer-vendor.quotation-management.my-quotation-deals-details', compact('quotationOffer', 'quotation'));
            }
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function myDeleteCounterQuote(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $quotation = CounterOfferQuotation::where('id', $request->quotation_id)->first();
            if ($quotation->user_id == auth()->user()->id) {
                $quotation->delete();
                return response()->json(['success' => true, 'message' => 'Successfully deleted your counter quote offer!']);
            } else {
                return response()->json(['success' => false,  'message' => 'You are not authorized to delete this counter quote!']);
            }
        } else {
            return response()->json(['success' => false,  'message' => 'You must be logged in to access this page!']);
        }
    }
    public function acceptCounterQuoteOffer(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $quotation = OfferQuotation::where('id', $request->quote_id)->where('quotation_id', $request->quotation_id)->first();
            if (isset($quotation->user_id) && $quotation->user_id == auth()->user()->id) {
                $counterOffer = CounterOfferQuotation::where('id', $request->counter_id)->first();
                if ($counterOffer->status == 'pending') {

                    $counterOffer->status = "accept";
                    $counterOffer->save();

                    $quotation->status = "accept";
                    $quotation->counter_price = $counterOffer->offer_price;
                    $quotation->save();
                }
                return response()->json(['success' => true, 'message' => 'Successfully accept your quote offer!']);
            } else {
                return response()->json(['success' => false,  'message' => 'You are not authorized to delete this quote!']);
            }
        } else {
            return response()->json(['success' => false,  'message' => 'You must be logged in to access this page!']);
        }
    }

    public function updateQuotationDealStatus(Request $request)
    {
        $request->validate([
            'offer_id' => 'required|exists:offer_quotations,id',
            'col' => 'required|string',
            'value' => 'required|string',
        ]);
        if ($request->col == "shipment_status" && $request->value == "shipped") {
            if ($request->has('shipping_company') && $request->input('shipping_company') != "" && $request->has('tracking_number') && $request->input('tracking_number') != "") {
                $orderItem = OfferQuotation::find($request->offer_id);
                $orderItem[$request->col] = $request->value;
                $orderItem->shippment_company = $request->shipping_company;
                $orderItem->tracking_number = $request->tracking_number;
                $orderItem->save();
                return response()->json(['status' => true, 'message' => 'Status updated successfully!']);
            } else {
                return response()->json(['status' => false, 'message' => 'Shipping company and tracking number are required!']);
            }
        }

        $orderItem = OfferQuotation::find($request->offer_id);
        $orderItem[$request->col] = $request->value;
        $orderItem->save();
        return response()->json(['status' => true, 'message' => 'Status updated successfully.']);
    }

    public function myDeleteQuotationImg(Request $request)
    {

        $quotation = Quotation::find($request->id);
        if (!$quotation || !in_array($request->column, ['image_1', 'image_2', 'image_3', 'image_4', 'image_5', 'image_6'])) {
            return response()->json(['success' => false, 'message' => 'Invalid request.']);
        }
        if (isset($quotation[$request->column]) && $quotation[$request->column] != "") {
            $imagePath = public_path('uploads/quotation/' . $quotation[$request->column]);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        // Remove the image reference from DB
        $quotation[$request->column] = null;
        $quotation->save();

        return response()->json(['success' => true, 'message' => 'Image removed successfully.']);
    }
}
