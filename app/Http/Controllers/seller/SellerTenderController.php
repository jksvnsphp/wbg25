<?php

namespace App\Http\Controllers\seller;

use Carbon\Carbon;
use App\Models\User;
use App\Models\region;
use App\Models\Tender;
use App\Models\Wallet;
use App\Models\countries;
use App\Models\OfferTender;
use Illuminate\Support\Str;
use App\Models\bank_details;
use Illuminate\Http\Request;
use App\Models\seller_package;
use App\Models\tender_setting;
use App\Models\shipping_rate_cost;
use App\Http\Controllers\Controller;
use App\Models\shipping_rate_tables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\ImageManager;
use App\Models\shipping_rate_cost_region;
use Illuminate\Support\Facades\Validator;

class SellerTenderController extends Controller
{
    public function index()
    {
        $vendor_id = auth()->user()->id;
        $vendorBankDetails = bank_details::where('vendor_id', $vendor_id)->first();
        if (
            !$vendorBankDetails ||
            (
                isset($vendorBankDetails->isPayPal, $vendorBankDetails->isBankDetail, $vendorBankDetails->isGooglePay, $vendorBankDetails->isOther) &&
                !$vendorBankDetails->isPayPal &&
                !$vendorBankDetails->isBankDetail &&
                !$vendorBankDetails->isGooglePay &&
                !$vendorBankDetails->isOther
            )
        ) {
            return redirect()->route('seller.add.bank.detail')->with(['alert-type' => 'error', 'message' => 'First complete your bank details.']);
        }


        $seller = User::where('id', $vendor_id)->first();

        $packageData = seller_package::latest()->where('seller_id', $seller->id)->with('package')->first();
        $listedTender = Tender::where('vendor_id', $vendor_id)->count();
        $listingLimit = $packageData->package->sellTenderLimit ?? 0;
        $packageType = $packageData->package->type ?? '';
        $listedLeft = $listingLimit - $listedTender;
        if ($listedLeft <= 0) {
            session()->flash('info-message', 'Your Member Package Upload Credit for tenders have been used up...');
            session()->flash('info-content', 'If you would Upload more tenders, please Upgrade your Membership Package first.');
            $vendorEmail = $seller->email;
            $data = [
                'name' => $seller->first_name,
                'heading' => 'Your Member Package Upload Credit for tenders have been used up...',
                'message_content' => 'If you would Upload more tenders, please Upgrade your Membership Package first.',
                'url' => route('user.member.package'),
            ];
            // Mail::send('mail.seller-listing-expired', $data, function ($message) use ($vendorEmail) {
            //     $message->to($vendorEmail)
            //         ->subject('Your Tender listing limit has been expired!');
            // });
            $seller = auth()->user();
            sendDynamicMail(
                $seller->id,
                'tender_submission_limit_reached_–_unlock_more_opportunities!', // slug from email_templates
                [
                    '[Seller Name]' => $seller->first_name,
                    '[Member Type]' => $packageType,
                    '[Insert Limit]' => $listingLimit,
                    '[Insert Upgrade Link]'    =>  route('user.member.package')
                ]
            );
            return redirect()->route('seller.upgrade.limit')->with(['alert-type' => 'warning', 'message' => 'Your product listing limit has been complete!']);
        }
        $regions = region::where('status', 1)->with('countries')->orderBy('name', 'ASC')->get();

        $countries = countries::where('status', 1)->orderBy('name', 'asc')->get()->map(function ($country) {
            return [
                'id' => $country->id,
                'text' => $country->name,
                'region_id' => $country->region_id ?? ''
            ];
        });
        $regions_countries = region::where('status', 1)->orderBy('name', 'asc')->get()->map(function ($region) {
            return [
                'id' => $region->id,
                'text' => $region->name,
            ];
        });
        return view('seller-vendor.tenders.add-tender', compact('regions', 'countries', 'regions_countries', 'listingLimit', 'listedTender'));
    }
    public function offeredTender()
    {
        if (isset(auth()->user()->id)) {
            $user = auth()->user();
            $tenders = OfferTender::latest()->where('user_id', $user->id)->with('tender.vendor')->where('status', 'pending')->doesntHave('counters')->get();

            $unTenders = OfferTender::latest()
                ->where('user_id', $user->id)
                ->where('status', 'pending')
                ->where('isUserRead', 0)
                ->get();

            foreach ($unTenders ?? [] as $unTender) {
                $unTender->isUserRead = 1;
                $unTender->save();
            }
            return view('seller-vendor.tenders.offered-tender', compact('tenders'));
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    private function createUniqueSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        if ($id) {
            $existing = Tender::find($id);
            if ($existing && $existing->slug === $slug) {
                return $slug;
            }
        }
        $count = Tender::where('slug', 'LIKE', "{$slug}%")
            ->when($id, function ($query) use ($id) {
                return $query->where('id', '!=', $id);
            })
            ->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function saveTender(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $vendor_id = auth()->user()->id;
            $validate = Validator::make(
                $request->all(),
                [
                    'title' => 'required|string|max:255',
                    'currency_type' => 'required|in:usd,eur',
                    'price' => 'required|numeric',
                    'quantity' => 'nullable|numeric',
                    'tender_condition' => 'required|string',
                    'duration' => 'required|integer|min:7',
                    'description' => 'nullable|string',
                    'parent_category_id' => 'required|integer|exists:parent_categories,id',
                    'category_id' => 'required|integer|exists:categories,id',
                    'child_category_id' => 'nullable|integer|exists:subcategories,id',
                    'endchild_category_id' => 'nullable|integer|exists:endsubcategories,id',

                    'shipping_partner' => 'required|string',
                    'shipping_method' => 'required|string',
                    'rate_type' => 'required|array',
                    'rate_regions' => 'required_if:rate_type,region|nullable|array',
                    'rate_country' => 'required_if:rate_type,country|nullable|array',
                    'shipping_cost' => 'required|array',
                    'shipping_cost.*' => 'required',

                    'handling_time' => 'nullable|integer|min:1',
                    'country_region' => 'nullable|integer|exists:countries,id',
                    'state_region' => 'nullable|integer|exists:states,id',
                    'city' => 'nullable|string|max:255',
                    'zip' => 'nullable|string|max:20',

                    'image_1' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                    'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                    'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                    'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                    'image_5' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                    'image_6' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',

                    'buyer_pay' => 'nullable|in:on',
                    'seller_pay' => 'nullable|in:on',
                    'return_timeline' => 'required|integer',
                    'isReturnAccept' => 'nullable|in:on',
                    'refund' => 'nullable|string',

                ],
                [
                    'parent_category_id.required' => 'The parent category is required. Please search and used it.',
                    'parent_category_id.integer' => 'The parent category must be a valid integer.',
                    'parent_category_id.exists' => 'The selected parent category does not exist in the database.',

                    'category_id.required' => 'The category field is required. Please search and used it',
                    'category_id.integer' => 'The category must be a valid integer.',
                    'category_id.exists' => 'The selected category does not exist in the database.',

                    'child_category_id.integer' => 'The child category must be a valid integer.',
                    'child_category_id.exists' => 'The selected child category does not exist in the database.',

                    'endchild_category_id.integer' => 'The end child category must be a valid integer.',
                    'endchild_category_id.exists' => 'The selected end child category does not exist in the database.',
                    'image_1.required' => 'The primary image is required.',
                ]
            );

            if ($validate->fails()) {
                return response()->json(['error' => $validate->messages()], 422);
            } else {


                $rateTableId = null;
                if ($request->shipping_partner != "") {
                    $newRateTable = new shipping_rate_tables();
                    $newRateTable->shipping_partner = $request->shipping_partner;
                    $newRateTable->shipping_method = $request->shipping_method;
                    $newRateTable->vendor_id = $vendor_id;
                    $newRateTable->save();
                    $rateTableId = $newRateTable->id;

                    foreach ($request->rate_type as $key => $type) {

                        if ($type === 'region') {

                            $newRate = new shipping_rate_cost();
                            $newRate->shipping_rate_id = $rateTableId;
                            $newRate->shipping_type = 'region';
                            $newRate->cost = $request->shipping_cost[$key] ?? 0;
                            $newRate->save();

                            // ✅ USE INDEXED REGIONS
                            $regions = $request->rate_regions[$key] ?? [];

                            if (isset($regions[0]) && $regions[0] === 'worldwide') {

                                $newRegion = new shipping_rate_cost_region();
                                $newRegion->shipping_rate_cost_id = $newRate->id;
                                $newRegion->region_id = null;
                                $newRegion->country_id = null;
                                $newRegion->isWorldwide = 1;
                                $newRegion->save();
                            } else {

                                foreach ($regions as $area) {
                                    $newRegion = new shipping_rate_cost_region();
                                    $newRegion->shipping_rate_cost_id = $newRate->id;
                                    $newRegion->region_id = $area;
                                    $newRegion->isWorldwide = 0;
                                    $newRegion->save();
                                }
                            }
                        } elseif ($type === 'country') {

                            $newRate = new shipping_rate_cost();
                            $newRate->shipping_rate_id = $rateTableId;
                            $newRate->shipping_type = 'country';
                            $newRate->cost = $request->shipping_cost[$key] ?? 0;
                            $newRate->save();

                            $countryId = $request->rate_country[$key] ?? null;

                            if ($countryId) {
                                $newRegion = new shipping_rate_cost_region();
                                $newRegion->shipping_rate_cost_id = $newRate->id;
                                $newRegion->country_id = $countryId;
                                $newRegion->isWorldwide = 0;
                                $newRegion->save();
                            }
                        }
                    }
                }


                $tender = new Tender();
                $tender->name = $request->title;
                $tender->slug = $this->createUniqueSlug($request->title);
                $tender->description = $request->description;
                $tender->price = isset($request->price) ? $request->price : 0;
                $tender->quantity = isset($request->quantity) ? $request->quantity : 0;
                $tender->currency = isset($request->currency_type) ? $request->currency_type : "usd";
                $tender->tender_condition = $request->tender_condition;
                $tender->vendor_id = $vendor_id;
                $tender->rate_table_id = $rateTableId;
                $tender->parent_category_id = $request->parent_category_id;
                $tender->category_id = $request->category_id;
                $tender->subcategory_id = $request->child_category_id;
                $tender->childcategory_id = $request->endchild_category_id;
                $tender->duration = $request->duration;

                $tender->isReturnAccept = $request->isReturnAccept == "on" ? 1 : 0;
                if ($request->isReturnAccept == "on") {
                    $tender->buyer_pay = $request->buyer_pay == "on" ? 1 : 0;
                    $tender->seller_pay = $request->seller_pay == "on" ? 1 : 0;
                    $tender->refund = $request->refund;
                    $tender->return_timeline = $request->return_timeline;
                } else {
                    $tender->buyer_pay = $request->buyer_pay == "on" ? 1 : 0;
                    $tender->seller_pay = $request->seller_pay == "on" ? 1 : 0;
                    $tender->refund = $request->refund;
                    $tender->return_timeline = $request->return_timeline;
                }


                // Tender gallery
                $manager = new ImageManager(['driver' => 'gd']);
                for ($i = 1; $i <= 6; $i++) {
                    if ($request->hasfile('image_' . $i)) {
                        $image = $request->file('image_' . $i);
                        $ext = $image->getClientOriginalExtension();
                        $fileName = uniqid() . '_' . time() . '.' . $ext;
                        $manager->make($image)->resize(480, 360)->save(public_path('uploads/tender/' . $fileName));
                        $tender['image_' . $i] = $fileName;
                        $tender->save();
                    }
                }
                $tender->save();
                $setting = new tender_setting();
                $setting->tendor_id = $tender->id;
                $setting->handling_time = $request->handling_time;
                $setting->country_id = $request->country_region;
                $setting->state_id = $request->state_region;
                $setting->city = $request->city;
                $setting->pincode = $request->zip;
                $setting->save();
                $url = route('seller.success.tender', [$tender->slug, 'add']);
                //$seller = User::find($tender->user_id);

                sendDynamicMail(
                    auth()->user()->id,
                    'confirmation_of_your_tender_listing', // slug from email_templates
                    [
                        '[User Name]'     => auth()->user()->first_name,
                        '[Tender]'          => $tender->name,
                        '[Title of the Listing]'     => $tender->name,
                        '[Listing Link]'      =>  route('seller.success.tender', [$tender->slug, 'add']),
                    ]
                );
                return response()->json(['success' => true, 'message' => 'Tender publish successfully', 'url' => $url], 200);
            }
        } else {
            return response()->json(['error' => ['message' => "Unauthrized access this page!"]], 422);
        }
    }

    public function mytender()
    {
        if (isset(auth()->user()->id)) {
            $user = auth()->user();
            $tenders = Tender::where('vendor_id', $user->id)
                ->where('isDeal', 0)
                ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])
                ->get();

            $unReadTenders = Tender::where('vendor_id', $user->id)->where('isRead', 0)->get();
            $tenders->is_expired = 0;
            foreach ($unReadTenders ?? [] as $unReadTender) {
                $unReadTender->isRead = 1;
                $unReadTender->save();
            }
            //echo '<pre>';
            //print_r($tenders);
            //echo '</pre>';
            return view('seller-vendor.tenders.my-tenders', compact('tenders'));
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function myExpiredTender()
    {
        if (isset(auth()->user()->id)) {
            $user = auth()->user();
            $tenders = Tender::where('vendor_id', $user->id)
                ->where('isDeal', 0)
                ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) < ?', [Carbon::now()])
                ->get();

            $unReadTenders = Tender::where('vendor_id', $user->id)->where('isRead', 0)->get();

            foreach ($unReadTenders ?? [] as $unReadTender) {
                $unReadTender->isRead = 1;
                $unReadTender->save();
            }
            $tenders->is_expired = 1;
            //echo '<pre>';
            //print_r($tenders);
            //echo '</pre>';
            return view('seller-vendor.tenders.my-expired-tenders', compact('tenders'));
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function statusChange(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $validator = Validator::make($request->all(), ['tender_id' => 'required', 'key' => 'required', 'value' => 'required']);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => "Invalid request", 'errors' => $validator->errors()]);
            }
            $tender = Tender::find($request->tender_id);
            if ($tender) {
                $tender->status = $request->value;
                $tender->save();
            }
            return response()->json(['status' => true, 'message' => "Tender status changed successfully"]);
        } else {
            return response()->json(['status' => false, 'message' => "Unauthrized access this page!"]);
        }
    }

    public function deleteTender(Request $request)
    {
        $tender = Tender::find($request->tender_id);
        if ($tender) {
            for ($i = 1; $i <= 6; $i++) {
                $imagePath = public_path('uploads/tender/' . $tender->image . '_' . $i);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
            $tender->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tender and associated files deleted successfully!'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete tender.'
        ]);
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




    public function editTender($slug)
    {
        if (!auth()->check()) {
            return redirect()->back()->with([
                'alert-type' => 'warning',
                'message' => 'Unauthorized access this page!'
            ]);
        }

        $regions = region::where('status', 1)
            ->with('countries')
            ->orderBy('name', 'ASC')
            ->get();

        $countries = countries::where('status', 1)
            ->orderBy('name', 'asc')
            ->get()
            ->map(fn($c) => ['id' => $c->id, 'text' => $c->name]);

        $regions_countries = region::where('status', 1)
            ->orderBy('name', 'asc')
            ->get()
            ->map(fn($r) => ['id' => $r->id, 'text' => $r->name]);

        $tender = Tender::where('slug', $slug)
            ->where('vendor_id', auth()->id())
            ->with(
                'parentcategory',
                'category',
                'childcategory',
                'endchildcategory',
                'tender_setting',
                'rate_table.shipping_rate_costs.shipping_regions'
            )
            ->first();

        if (!$tender) {
            return redirect()->back()->with([
                'alert-type' => 'warning',
                'message' => 'Tender not found!'
            ]);
        }

        /**  CHECK IF EXPIRED */
        $expiryDate = Carbon::parse($tender->created_at)->addDays($tender->duration);

        $tender->is_expired = $expiryDate->isPast() ? 1 : 0;

    // Optional: Save in DB if you want
    // $tender->save();

        /** CATEGORY PATH LOGIC (UNCHANGED) */
        $searchedCategory = '';
        $searchedPath = '';

        if ($tender->parentcategory) {
            $searchedCategory = $tender->parentcategory->name;
            $searchedPath = $searchedCategory;
        }

        if ($tender->category) {
            $searchedCategory = $tender->category->name;
            $searchedPath .= ' > ' . $searchedCategory;
        }

        if ($tender->childcategory) {
            $searchedCategory = $tender->childcategory->name;
            $searchedPath .= ' > ' . $searchedCategory;
        }

        if ($tender->endchildcategory) {
            $searchedCategory = $tender->endchildcategory->name;
            $searchedPath .= ' > ' . $searchedCategory;
        }

        $tender->searched_category = $searchedCategory;
        $tender->searched_path = $searchedPath;

        return view('seller-vendor.tenders.edit-tender', compact(
            'tender',
            'regions',
            'countries',
            'regions_countries'
        ));
    }

    public function successTender($slug)
    {
        if (isset(auth()->user()->id)) {
            $seller = User::where('id', auth()->user()->id)->first();
            $packageData = seller_package::latest()->where('seller_id', $seller->id)->with('package')->first();
            $tender = Tender::where('slug', $slug)->where('vendor_id', auth()->user()->id)->first();
            if ($tender) {

                return view('seller-vendor.tenders.success', compact('tender', 'seller', 'packageData'));
            } else {
                abort(404, 'Tender not found!');
            }
        } else {
            abort(403, 'Forbidden');
        }
    }


    public function editTenderold($slug)
    {
        if (isset(auth()->user()->id)) {
            $regions = region::where('status', 1)->with('countries')->orderBy('name', 'ASC')->get();

            $countries = countries::where('status', 1)->orderBy('name', 'asc')->get()->map(function ($country) {
                return [
                    'id' => $country->id,
                    'text' => $country->name,
                ];
            });
            $regions_countries = region::where('status', 1)->orderBy('name', 'asc')->get()->map(function ($region) {
                return [
                    'id' => $region->id,
                    'text' => $region->name,
                ];
            });
            $tender = Tender::where('slug', $slug)->where('vendor_id', auth()->user()->id)->with('parentcategory', 'category', 'childcategory', 'endchildcategory', 'tender_setting', 'rate_table.shipping_rate_costs.shipping_regions')->first();
            if (isset($tender)) {
                $searchedCategory = '';
                $searchedPath = '';
                if (isset($tender->parent_category_id) && $tender->parent_category_id != "" && isset($tender->parentcategory->id)) {
                    $searchedCategory = $tender->parentcategory->name;
                    $searchedPath .= $tender->parentcategory->name;
                }
                if (isset($tender->category_id) && $tender->category_id != "" && isset($tender->category->id) && $tender->category->id != "") {
                    $searchedCategory = $tender->category->name;
                    $searchedPath .= ' > ' . $tender->category->name;
                }
                if (isset($tender->subcategory_id) && $tender->subcategory_id != "" && isset($tender->childcategory->id) && $tender->childcategory->id != "") {
                    $searchedCategory = $tender->childcategory->name;
                    $searchedPath .= ' > ' . $tender->childcategory->name;
                }
                if (isset($tender->childcategory_id) && $tender->childcategory_id != "" && isset($tender->endchildcategory->id) && $tender->endchildcategory->id != "") {
                    $searchedCategory = $tender->endchildcategory->name;
                    $searchedPath .= ' > ' . $tender->endchildcategory->name;
                }
                $tender->searched_category = $searchedCategory;
                $tender->searched_path = $searchedPath;

                return view('seller-vendor.tenders.edit-tender', compact('tender', 'regions', 'countries', 'regions_countries'));
            } else {
                return redirect()->back()->with(['alert-type' => 'warning', 'message' => 'Tender not found!']);
            }
        } else {
            return redirect()->back()->with(['alert-type' => 'warning', 'message' => 'Unauthrized access this page!']);
        }
    }

    public function updateTender(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $vendor_id = auth()->user()->id;
            $validate = Validator::make(
                $request->all(),
                [
                    'id' => 'required|exists:tenders,id',
                    'title' => 'required|string|max:255',
                    'currency_type' => 'required|string|in:usd,eur',
                    'price' => 'required|numeric',
                    'quantity' => 'required|numeric',
                    'tender_condition' => 'required|string',
                    'duration' => 'required|integer|min:7',
                    'description' => 'nullable|string',
                    'parent_category_id' => 'required|integer|exists:parent_categories,id',
                    'category_id' => 'nullable|integer|exists:categories,id',
                    'child_category_id' => 'nullable|integer|exists:subcategories,id',
                    'endchild_category_id' => 'nullable|integer|exists:endsubcategories,id',
                    'shipping_partner' => 'required|string',
                    'shipping_method' => 'required|string',
                    'rate_type' => 'required|array',
                    'rate_regions' => 'required_if:rate_type,region|nullable|array',
                    'rate_country' => 'required_if:rate_type,country|nullable|array',
                    'shipping_cost' => 'required|array',
                    'shipping_cost.*' => 'required',

                    'handling_time' => 'nullable|integer|min:1',
                    'country_region' => 'nullable|integer|exists:countries,id',
                    'state_region' => 'nullable|integer|exists:states,id',
                    'city' => 'nullable|string|max:255',
                    'zip' => 'nullable|string|max:20',
                    'buyer_pay' => 'nullable|in:on',
                    'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                    'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                    'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                    'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                    'image_5' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                    'image_6' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',

                    'buyer_pay' => 'nullable|in:on',
                    'seller_pay' => 'nullable|in:on',
                    'return_timeline' => 'required|integer',
                    'isReturnAccept' => 'nullable|in:on',
                    'refund' => 'nullable|string',

                ],
                [
                    'parent_category_id.required' => 'The parent category is required. Please search and used it.',
                    'parent_category_id.integer' => 'The parent category must be a valid integer.',
                    'parent_category_id.exists' => 'The selected parent category does not exist in the database.',

                    'category_id.required' => 'The category field is required. Please search and used it',
                    'category_id.integer' => 'The category must be a valid integer.',
                    'category_id.exists' => 'The selected category does not exist in the database.',

                    'child_category_id.integer' => 'The child category must be a valid integer.',
                    'child_category_id.exists' => 'The selected child category does not exist in the database.',

                    'endchild_category_id.integer' => 'The end child category must be a valid integer.',
                    'endchild_category_id.exists' => 'The selected end child category does not exist in the database.',
                ]
            );

            if ($validate->fails()) {
                return response()->json(['error' => $validate->messages()], 422);
            } else {
                $tender = Tender::find($request->id);

                if (!$tender) {
                    return response()->json(['success' => false, 'message' => 'Tender not found']);
                }


                if ($tender) {
                    $isExpired = Carbon::parse($tender->created_at)
                        ->addDays($tender->duration)
                        ->isPast();
                    $rateTableId = null;
                    if ($request->shipping_partner != "") {
                        $newRateTable = new shipping_rate_tables();
                        $newRateTable->shipping_partner = $request->shipping_partner;
                        $newRateTable->shipping_method = $request->shipping_method;
                        $newRateTable->vendor_id = $vendor_id;
                        $newRateTable->save();
                        $rateTableId = $newRateTable->id;

                        foreach ($request->rate_type as $key => $type) {

                            if ($type === 'region') {

                                $newRate = new shipping_rate_cost();
                                $newRate->shipping_rate_id = $rateTableId;
                                $newRate->shipping_type = 'region';
                                $newRate->cost = $request->shipping_cost[$key] ?? 0;
                                $newRate->save();

                                // ✅ USE INDEXED REGIONS
                                $regions = $request->rate_regions[$key] ?? [];

                                if (isset($regions[0]) && $regions[0] === 'worldwide') {

                                    $newRegion = new shipping_rate_cost_region();
                                    $newRegion->shipping_rate_cost_id = $newRate->id;
                                    $newRegion->region_id = null;
                                    $newRegion->country_id = null;
                                    $newRegion->isWorldwide = 1;
                                    $newRegion->save();
                                } else {

                                    foreach ($regions as $area) {
                                        $newRegion = new shipping_rate_cost_region();
                                        $newRegion->shipping_rate_cost_id = $newRate->id;
                                        $newRegion->region_id = $area;
                                        $newRegion->isWorldwide = 0;
                                        $newRegion->save();
                                    }
                                }
                            } elseif ($type === 'country') {

                                $newRate = new shipping_rate_cost();
                                $newRate->shipping_rate_id = $rateTableId;
                                $newRate->shipping_type = 'country';
                                $newRate->cost = $request->shipping_cost[$key] ?? 0;
                                $newRate->save();

                                $countryId = $request->rate_country[$key] ?? null;

                                if ($countryId) {
                                    $newRegion = new shipping_rate_cost_region();
                                    $newRegion->shipping_rate_cost_id = $newRate->id;
                                    $newRegion->country_id = $countryId;
                                    $newRegion->isWorldwide = 0;
                                    $newRegion->save();
                                }
                            }
                        }
                    }

                    // delete old rate table
                    $old_shipping_rate = shipping_rate_tables::where('id', $tender->rate_table_id)->first();
                    if ($old_shipping_rate) {
                        $old_shipping_rate->delete();
                    }


                    $tender->name = $request->title;
                    $tender->slug = $this->createUniqueSlug($request->title, $request->id);
                    $tender->description = $request->description;
                    $tender->price = isset($request->price) ? $request->price : 0;
                    $tender->quantity = isset($request->quantity) ? $request->quantity : 1000;
                    $tender->currency = isset($request->currency_type) ? $request->currency_type : "usd";
                    $tender->tender_condition = $request->tender_condition;
                    $tender->vendor_id = $vendor_id;
                    $tender->rate_table_id = $rateTableId;
                    $tender->parent_category_id = $request->parent_category_id;
                    $tender->category_id = $request->category_id;
                    $tender->subcategory_id = $request->child_category_id;
                    $tender->childcategory_id = $request->endchild_category_id;

                    if ($isExpired) {

                        $tender->created_at = Carbon::now();
                        $tender->duration  = $request->duration;
                        $tender->isDeal    = 0; // reopen if needed



                    } elseif ($request->duration != $tender->duration) {
                        // tender active → only update duration
                        $tender->duration = $request->duration;
                    }


                    $tender->isReturnAccept = $request->isReturnAccept == "on" ? 1 : 0;
                    if ($request->isReturnAccept == "on") {
                        $tender->buyer_pay = $request->buyer_pay == "on" ? 1 : 0;
                        $tender->seller_pay = $request->seller_pay == "on" ? 1 : 0;
                        $tender->refund = $request->refund;
                        $tender->return_timeline = $request->return_timeline;
                    } else {
                        $tender->buyer_pay = $request->buyer_pay == "on" ? 1 : 0;
                        $tender->seller_pay = $request->seller_pay == "on" ? 1 : 0;
                        $tender->refund = $request->refund;
                        $tender->return_timeline = $request->return_timeline;
                    }






                    // Tender gallery
                    $manager = new ImageManager(['driver' => 'gd']);
                    for ($i = 1; $i <= 6; $i++) {
                        if ($request->hasfile('image_' . $i)) {
                            $image = $request->file('image_' . $i);

                            $ext = $image->getClientOriginalExtension();
                            $fileName = uniqid() . '_' . time() . '.' . $ext;
                            $manager->make($image)->resize(480, 360)->save(public_path('uploads/tender/' . $fileName));
                            $oldFile = public_path('uploads/tender/' . $tender['image_' . $i]);
                            if (File::exists($oldFile)) {
                                File::delete($oldFile);
                            }
                            $tender['image_' . $i] = $fileName;
                            $tender->save();
                        }
                    }
                    $tender->save();

                    $old_setting = tender_setting::where('tendor_id', $tender->id)->first();
                    if ($old_setting) {
                        $old_setting->delete();
                    }

                    $setting = new tender_setting();
                    $setting->tendor_id = $tender->id;
                    $setting->handling_time = $request->handling_time;
                    $setting->country_id = $request->country_region;
                    $setting->state_id = $request->state_region;
                    $setting->city = $request->city;
                    $setting->pincode = $request->zip;
                    $setting->save();
                    $url = route('seller.success.tender', [$tender->slug, 'edit']);
                    return response()->json(['success' => true, 'message' => 'Tender updated successfully', 'url' => $url], 200);
                } else {
                    return response()->json(['success' => false, 'message' => 'Tender not found']);
                }
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Unauthrized access. Please login']);
        }
    }


    public function successPage($slug, $what = "add")
    {
        if (isset(auth()->user()->id)) {
            $seller = User::where('id', auth()->user()->id)->first();
            $packageData = seller_package::latest()->where('seller_id', $seller->id)->with('package')->first();
            $tender = Tender::where('slug', $slug)->where('vendor_id', auth()->user()->id)->first();
            if ($tender) {
                return view('seller-vendor.tenders.success-tender-edit-add', compact('tender', 'seller', 'packageData', 'what'));
            } else {
                abort(404, 'Tender not found!');
            }
        } else {
            abort(403, 'Forbidden');
        }
    }

    public function dealTenderDetail($slug, $offer_id)
    {
        $id = Auth::user()->id;
        $tenderOffer = OfferTender::where(function ($query) use ($id) {
            $query->where('user_id', $id)
                ->orWhere('vendor_id', $id);
        })->where('status', 'accept')->where('id', $offer_id)->with('tender.vendor.payment_infos', 'sender')->first();
        // dd($tenderOffer->toArray());
        $tender = Tender::where('slug', $slug)->first();
        if (!$tender) {
            return back()->with(['alert-type' => 'error', 'message' => 'Tender not found!']);
        }
        return view('seller-vendor.tenders.tender-deal-detail', compact('tenderOffer', 'tender'));
    }

    public function statusDealChange(Request $request)
    {
        $request->validate([
            'offer_id' => 'required|exists:offer_tenders,id',
            'col' => 'required|string',
            'value' => 'required|string',
        ]);
        if ($request->col == "shipment_status" && $request->value == "shipped") {
            if ($request->has('shipping_company') && $request->input('shipping_company') != "" && $request->has('tracking_number') && $request->input('tracking_number') != "") {
                $orderItem = OfferTender::find($request->offer_id);
                $orderItem[$request->col] = $request->value;
                $orderItem->shippment_company = $request->shipping_company;
                $orderItem->tracking_number = $request->tracking_number;
                $orderItem->save();
                return response()->json(['status' => true, 'message' => 'Status updated successfully!']);
            } else {
                return response()->json(['status' => false, 'message' => 'Shipping company and tracking number are required!']);
            }
        }

        $orderItem = OfferTender::find($request->offer_id);
        $orderItem[$request->col] = $request->value;
        $orderItem->save();

        // Expire Tender
        $tender = Tender::find($orderItem->tender_id);
        $tender['duration'] = 0;
        $tender->save();

        // Save to SaleProvision table
        $totalPrice = $orderItem->offer_price;
        $provisionAmount = (5 / 100) * $totalPrice;

        $saleProvision = new Wallet();
        $saleProvision->order_item_id   = 0;
        $saleProvision->offer_quotation_id = 0;
        $saleProvision->offer_tender_id = $orderItem->id;
        $saleProvision->user_id         = auth()->user()->id;
        $saleProvision->debit          = $provisionAmount;
        $saleProvision->type            = 'sale_provision';
        $saleProvision->save();

        return response()->json(['status' => true, 'message' => 'Status updated successfully.']);
    }

    public function deleteTenderImg(Request $request)
    {
        $tender = Tender::find($request->id);
        if (!$tender || !in_array($request->column, ['image_1', 'image_2', 'image_3', 'image_4', 'image_5', 'image_6'])) {
            return response()->json(['success' => false, 'message' => 'Invalid request.']);
        }
        if (isset($tender[$request->column]) && $tender[$request->column] != "") {
            $imagePath = public_path('uploads/tender/' . $tender[$request->column]);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        // Remove the image reference from DB
        $tender[$request->column] = null;
        $tender->save();

        return response()->json(['success' => true, 'message' => 'Image removed successfully.']);
    }
}
