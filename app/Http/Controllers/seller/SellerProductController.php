<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\category_attribute;
use App\Models\countries;
use App\Models\endsubcategory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\product_attribute;
use App\Models\product_gallery;
use App\Models\product_video;
use App\Models\products;
use App\Models\productSetting;
use App\Models\region;
use App\Models\seller_package;
use App\Models\shipping_rate_cost;
use App\Models\shipping_rate_cost_region;
use App\Models\shipping_rate_tables;
use App\Models\subcategory;
use App\Models\bank_details;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class SellerProductController extends Controller
{
    //
    public function addProduct()
    {

        if (isset(auth()->user()->id)) {

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
            $listedProduct = products::where('vendor_id', $vendor_id)->count();
            $listingLimit = $packageData->package->productLimit ?? 0;
            $packageType = $packageData->package->type ?? '';
            $listedLeft = $listingLimit - $listedProduct;
            if ($listedLeft <= 0) {
                session()->flash('info-message', 'Your Member Package Upload Credit for products have been used up...');
                session()->flash('info-content', 'If you would Upload more products, please Upgrade your Membership Package first.');
                $vendorEmail = $seller->email;
                $data = [
                    'name' => $seller->first_name,
                    'heading' => 'Your Member Package Upload Credit for products have been used up...',
                    'message_content' => 'If you would Upload more products, please Upgrade your Membership Package first.',
                    'url' => route('user.member.package'),
                ];
                Mail::send('mail.seller-listing-expired', $data, function ($message) use ($vendorEmail) {
                    $message->to($vendorEmail)
                        ->subject('Your Product listing limit has been expired!');
                });
                return redirect()->route('seller.upgrade.limit')->with(['alert-type' => 'warning', 'message' => 'Your product listing limit has been complete!']);
            }
            $regions = region::where('status', 1)->with('countries')->orderBy('name', 'ASC')->get();
            $countries = countries::where('status', 1)->orderBy('name', 'asc')->get()->map(function ($country) {
                return [
                    'id' => $country->id,
                    'text' => $country->name,
                    'region_id' => $country->region_id ?? '',
                ];
            });
            $regions_countries = region::where('status', 1)->orderBy('name', 'asc')->get()->map(function ($region) {
                return [
                    'id' => $region->id,
                    'text' => $region->name,
                ];
            });
            return view('seller-vendor.product.add-single-product', compact('countries',  'regions', 'regions_countries', 'listingLimit', 'listedProduct'));
        } else {
            return redirect()->route('login');
        }
    }
    
    public function upgradeLimitPackage()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $seller = User::where('id', $id)->first();
            $packageData = seller_package::latest()->where('seller_id', $seller->id)->with('package')->first();
            if (session('info-message') != null) {
                return view('seller-vendor.product.upgrade-membership-alert', compact('packageData', 'seller'));
            } else {
                return redirect()->route('seller.dashboard');
            }
        } else {
            return redirect()->route('login');
        }
    }
    
    public function addMultipleProduct()
    {
        if (isset(auth()->user()->id)) {
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
            $listedProduct = products::where('vendor_id', $vendor_id)->count();
            $listingLimit = $packageData->package->productLimit ?? 0;
            $packageType = $packageData->package->type ?? '';
            if ($packageType == "bronce") {
                session()->flash('info-message', 'Your Membership Package does not support multiple listings.');
                session()->flash('info-content', 'To enable multiple listings, please upgrade your Membership Package.');
                return redirect()->route('seller.upgrade.limit')->with([
                    'alert-type' => 'warning',
                    'message' => 'Your current Membership Package does not allow multiple listings. Upgrade now to access this feature!'
                ]);
            }
            $listedLeft = $listingLimit - $listedProduct;
            if ($listedLeft <= 0) {
                session()->flash('info-message', 'Your Member Package Upload Credit for products have been used up...');
                session()->flash('info-content', 'If you would Upload more products, please Upgrade your Membership Package first.');
                $vendorEmail = $seller->email;
                $data = [
                    'name' => $seller->first_name,
                    'heading' => 'Your Member Package Upload Credit for products have been used up...',
                    'message_content' => 'If you would Upload more products, please Upgrade your Membership Package first.',
                    'url' => route('user.member.package'),
                ];
                Mail::send('mail.seller-listing-expired', $data, function ($message) use ($vendorEmail) {
                    $message->to($vendorEmail)
                        ->subject('Your Product listing limit has been expired!');
                });
                return redirect()->route('seller.upgrade.limit')->with(['alert-type' => 'warning', 'message' => 'Your product listing limit has been complete!']);
            }
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
            return view('seller-vendor.product.multiplylisting', compact('countries',  'regions', 'regions_countries', 'listingLimit', 'listedProduct'));
        } else {
            return redirect()->route('login');
        }
    }

    public function editProduct($product_id)
    {
        if (isset(auth()->user()->id)) {
            $vendor_id = auth()->user()->id;

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
            $product = products::where('id', $product_id)->where('vendor_id', $vendor_id)->with('parentcategory', 'category', 'childcategory', 'endchildcategory', 'gallery', 'video', 'product_attributes', 'product_setting', 'rate_table.shipping_rate_costs.shipping_regions')->first();

            if ($product) {
                // dd($product->rate_table->toArray());
                $searchedPath = '';
                $searched_cat = '';
                if (isset($product->parent_category_id) && $product->parent_category_id != "" && isset($product->parentcategory->id)) {
                    $searchedPath .= $product->parentcategory->name;
                    $searched_cat = $product->parentcategory->name;
                }
                if (isset($product->category_id) && $product->category_id != "" && isset($product->category->id) && $product->category->id != "") {
                    $searchedPath .= ' >' . $product->category->name;
                    $searched_cat = $product->category->name;
                }
                if (isset($product->subcategory_id) && $product->subcategory_id != "" && isset($product->childcategory->id) && $product->childcategory->id != "") {
                    $searchedPath .= ' >' . $product->childcategory->name;
                    $searched_cat = $product->childcategory->name;
                }
                if (isset($product->childcategory_id) && $product->childcategory_id != "" && isset($product->endchildcategory->id) && $product->endchildcategory->id != "") {
                    $searchedPath .= ' >' . $product->endchildcategory->name;
                    $searched_cat = $product->endchildcategory->name;
                }
                $product->searched_path = $searchedPath;
                $product->searched_cat = $searched_cat;
            } else {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Product not found!']);
            }

            return view('seller-vendor.product.edit-single-product', compact('countries',  'regions', 'regions_countries', 'product'));
        } else {
            return redirect()->route('login');
        }
    }
    public function editMultiplyListing($product_id)
    {
        if (isset(auth()->user()->id)) {
            $vendor_id = auth()->user()->id;

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
            $product = products::where('id', $product_id)->where('vendor_id', $vendor_id)->with('parentcategory', 'category', 'childcategory', 'endchildcategory', 'gallery', 'video', 'product_attributes', 'product_setting', 'rate_table.shipping_rate_costs.shipping_regions')->first();

            if ($product) {
                // dd($product->rate_table->toArray());
                $searchedPath = '';
                $searched_cat = '';
                if (isset($product->parent_category_id) && $product->parent_category_id != "" && isset($product->parentcategory->id)) {
                    $searchedPath .= $product->parentcategory->name;
                    $searched_cat = $product->parentcategory->name;
                }
                if (isset($product->category_id) && $product->category_id != "" && isset($product->category->id) && $product->category->id != "") {
                    $searchedPath .= ' >' . $product->category->name;
                    $searched_cat = $product->category->name;
                }
                if (isset($product->subcategory_id) && $product->subcategory_id != "" && isset($product->childcategory->id) && $product->childcategory->id != "") {
                    $searchedPath .= ' >' . $product->childcategory->name;
                    $searched_cat = $product->childcategory->name;
                }
                if (isset($product->childcategory_id) && $product->childcategory_id != "" && isset($product->endchildcategory->id) && $product->endchildcategory->id != "") {
                    $searchedPath .= ' >' . $product->endchildcategory->name;
                    $searched_cat = $product->endchildcategory->name;
                }
                $product->searched_path = $searchedPath;
                $product->searched_cat = $searched_cat;
            } else {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Product not found!']);
            }

            return view('seller-vendor.product.edit-multiple-listing', compact('countries',  'regions', 'regions_countries', 'product'));
        } else {
            return redirect()->route('login');
        }
    }

    // Controller Method to Get Subcategories
    public function getSubCategories(Request $request)
    {
        $subCategories = category::where('parent_category_id', $request->category_id)->where('status', 1)->orderBy('name', 'ASC')->get();
        return response()->json($subCategories);
    }

    public function getSubSubCategories(Request $request)
    {
        $subSubCategories = subcategory::where('category_id', $request->sub_category_id)->where('status', 1)->orderBy('name', 'ASC')->get();
        return response()->json($subSubCategories);
    }

    public function getChildCategories(Request $request)
    {
        $childCategories = endsubcategory::where('subcategories_id', $request->sub_sub_category_id)->where('status', 1)->orderBy('name', 'ASC')->get();
        return response()->json($childCategories);
    }

    public function getCategoryAttributes(Request $request)
    {
        $categoryId = $request->category_id;


        $categoryAttributes = category_attribute::with(['attribute.items'])
            ->where('category_id', $categoryId)
            ->where('status', 1)
            ->get();
        $attributes = $categoryAttributes->map(function ($categoryAttribute) {
            return [
                'id' => $categoryAttribute->id,
                'name' => $categoryAttribute->attribute->name,
                'input_option' => $categoryAttribute->attribute->input_option,
                'items' => $categoryAttribute->attribute->items,
                'isRequired' => $categoryAttribute->isRequired
            ];
        });

        return response()->json($attributes);
    }

    private function createUniqueSlug($productName)
    {
        // Create a basic slug
        $slug = Str::slug($productName);
        $count = products::where('slug', 'LIKE', "{$slug}%")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function storeProduct(Request $request)
    {
        // dd($request->all());
        if (isset(auth()->user()->id)) {
            $vendor_id = auth()->user()->id;
            $validate = Validator::make(
                $request->all(),
                [
                    'item_title' => 'required|string|max:255',
                    'parent_category_id' => 'required|integer|exists:parent_categories,id',
                    'category_id' => 'required|integer|exists:categories,id',
                    'child_category_id' => 'nullable|integer|exists:subcategories,id',
                    'endchild_category_id' => 'nullable|integer|exists:endsubcategories,id',
                    'totalQty' => 'required|numeric',
                    'item_condition' => 'required|string',
                    'buyer_need_detail' => 'nullable|in:on',
                    'attribute' => 'nullable|array',
                    'attribute.*' => 'nullable',
                    'item_description' => 'nullable|string',
                    'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                    'video' => 'nullable|mimetypes:video/mp4,video/mpeg,video/quicktime',

                    'ispcs' => 'array',
                    'ispcs.*' => 'nullable|in:on',
                    'currency' => 'array',
                    'currency.*' => 'nullable|in:USD,EUR',
                    'pcsmin' => 'nullable|array',
                    'pcsmin.*' => 'nullable',
                    'pcsmax' => 'nullable|array',
                    'pcsmax.*' => 'nullable',
                    'cost' => 'nullable|array',
                    'cost.*' => 'nullable|numeric|min:0',

                    'totalQty' => 'nullable|min:1|numeric',
                    'isLimitedOffer' => 'nullable|in:on',
                    'isDailyDeal' => 'nullable|in:on',
                    'isBulkBuy' => 'nullable|in:on',
                    'isHotProduct' => 'nullable|in:on',

                    'duration' => 'required|integer|min:1',
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
                    'seller_pay' => 'nullable|in:on',
                    'return_timeline' => 'required|integer',
                    'isReturnAccept' => 'nullable|in:on',
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
                // first need to check rate table
                $rateTableId = null;
                if ($request->shipping_partner != "") {
                    $newRateTable = new shipping_rate_tables();
                    $newRateTable->shipping_partner = $request->shipping_partner;
                    $newRateTable->shipping_method = $request->shipping_method;
                    $newRateTable->vendor_id = $vendor_id;
                    $newRateTable->save();
                    $rateTableId = $newRateTable->id;

                    foreach ($request->rate_type as $key => $type) {
                        if ($type == 'region') {
                            $newRate = new shipping_rate_cost();
                            $newRate->shipping_rate_id = $rateTableId;
                            $newRate->shipping_type = $type;
                            $newRate->cost = isset($request['shipping_cost'][$key]) ? $request['shipping_cost'][$key] : 0;
                            // dd($request['rate'][$key]);
                            $newRate->save();
                            foreach ($request->rate_regions as $region) {
                                $regions = isset($region) ? $region : [];
                                // dd($regions);
                                if (isset($regions[0]) && $regions[0] == "worldwide") {
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
                                        $newRegion->save();
                                    }
                                }
                            }
                        } elseif ($type == "country") {
                            $newRate = new shipping_rate_cost();
                            $newRate->shipping_rate_id = $rateTableId;
                            $newRate->shipping_type = $type;
                            $newRate->cost = isset($request['shipping_cost'][$key]) ? $request['shipping_cost'][$key] : 0;
                            // dd($request['rate'][$key]);
                            $newRate->save();

                            $countryId = isset($request->rate_country[$key]) ? $request->rate_country[$key] : 0;
                            // dd($countryId);
                            if ($countryId) {
                                $newRegion = new shipping_rate_cost_region();
                                $newRegion->shipping_rate_cost_id = $newRate->id;
                                $newRegion->country_id = $countryId;
                                $newRegion->save();
                            }
                        }
                    }
                }


                $product = new products();
                $product->name = $request->item_title;
                $product->slug = $this->createUniqueSlug($request->item_title);
                $product->description = $request->item_description;
                $product->price = isset($request->cost[0]) ? $request->cost[0] : 0;
                $product->item_condition = $request->item_condition;
                $product->isAttribute = $request->buyer_need_detail == "on" ? 1 : 0;;
                $product->isSetting = 1;
                $product->isRate = 1;
                $product->rate_table_id = $rateTableId;
                $product->vendor_id = $vendor_id;
                $product->totalQty = $request->totalQty;
                // $product->attr_data = $attr_data;
                $product->parent_category_id = $request->parent_category_id;
                $product->category_id = $request->category_id;
                $product->subcategory_id = $request->child_category_id;
                $product->childcategory_id = $request->endchild_category_id;
                $product->isLimitedOffer = $request->isLimitedOffer == "on" ? 1 : 0;
                $product->isDailyDeal = $request->isDailyDeal == "on" ? 1 : 0;
                $product->isBulkBuy = $request->isBulkBuy == "on" ? 1 : 0;
                $product->isHotProduct = $request->isHotProduct == "on" ? 1 : 0;
                $product->duration = $request->duration;

                $product->isPrice0 = (isset($request->ispcs[0]) && $request->ispcs[0] == "on") ? 1 : 0;
                $product->isPrice1 = (isset($request->ispcs[1]) && $request->ispcs[1] == "on") ? 1 : 0;
                $product->isPrice2 = (isset($request->ispcs[2]) && $request->ispcs[2] == "on") ? 1 : 0;


                $product->currency0 = (isset($request->currency[0]) && $request->currency[0] != '') ? $request->currency[0] : "USD";
                $product->currency1 = (isset($request->currency[1]) && $request->currency[1] != '') ? $request->currency[1] : "USD";
                $product->currency2 = (isset($request->currency[2]) && $request->currency[2] != '') ? $request->currency[2] : "USD";


                if (isset($request->pcsmin[0]) && isset($request->pcsmax[0])) {
                    $product->qtymin0 = $request->pcsmin[0] ?? 1;
                    $product->qtymax0 = $request->pcsmax[0] ?? 10;
                }
                if (isset($request->pcsmin[1]) && isset($request->pcsmax[1])) {
                    $product->qtymin1 = $request->pcsmin[1] ?? 11;
                    $product->qtymax1 = $request->pcsmax[1] ?? 50;
                }
                if (isset($request->pcsmin[2]) && isset($request->pcsmax[2])) {
                    $product->qtymin2 = $request->pcsmin[2] ?? 51;
                    $product->qtymax2 = $request->pcsmax[2] ?? 100;
                }
                $product->price0 = isset($request->cost[0]) ? $request->cost[0] : 0;
                $product->price1 = isset($request->cost[1]) ? $request->cost[1] : 0;
                $product->price2 = isset($request->cost[2]) ? $request->cost[2] : 0;
                $pricesAr = [];
                if (isset($request->cost[0]) && $request->cost[0] > 0) {
                    $pricesAr[] = $request->cost[0];
                }
                if (isset($request->cost[1]) && $request->cost[1] > 0) {
                    $pricesAr[] = $request->cost[1];
                }
                if (isset($request->cost[2]) && $request->cost[2] > 0) {
                    $pricesAr[] = $request->cost[2];
                }
                $minPrice = min($pricesAr) ?? 0;
                $maxPrice = max($pricesAr) ?? 0;
                $product->price = $minPrice;
                $product->minPrice = $minPrice;
                $product->maxPrice = $maxPrice;
                $product->save();


                // extra attributes
                if (isset($request->buyer_need_detail) && $request->buyer_need_detail != "") {
                    $spacific_name = $request->input('spacific_name');
                    $spacific_value = $request->input('spacific_detail');
                    $extrasAttributes = [];

                    if (is_array($spacific_name) && is_array($spacific_value)) {
                        foreach ($spacific_name as $index => $name) {
                            $extrasAttributes[] = [
                                'name' => $name,
                                'value' => $spacific_value[$index] ?? null,
                            ];
                        }
                    }
                    $product->extraAttributes = json_encode($extrasAttributes, JSON_PRETTY_PRINT);
                    $product->save();
                }
                // store attributes value
                if (isset($request->attribute) && isset($request->buyer_need_detail) && $request->buyer_need_detail != "") {

                    foreach ($request->attribute as $key => $value) {
                        if ($value != null && $value != "") {
                            $attributeTable = new product_attribute();
                            $attributeTable->attribute_id = $key;
                            $attributeTable->product_id = $product->id;
                            if (is_array($value)) {
                                $attributeTable->attribute_value = json_encode($value);
                            } else {

                                $attributeTable->attribute_value = $value;
                            }
                            $attributeTable->save();
                        }
                    }
                }


                $setting = new productSetting();
                $setting->product_id = $product->id;
                $setting->handling_time = $request->handling_time;
                $setting->country_id = $request->country_region;
                $setting->state_id = $request->state_region;
                $setting->city = $request->city;
                $setting->pincode = $request->zip;
                $setting->return_timeline = $request->return_timeline;
                $setting->buyer_pay = $request->buyer_pay == "on" ? 1 : 0;
                $setting->seller_pay = $request->seller_pay == "on" ? 1 : 0;
                $setting->isReturnAccept = $request->isReturnAccept == "on" ? 1 : 0;
                $setting->refund = $request->refund;
                $setting->save();


                // for video
                if ($request->hasfile('video')) {
                    $video = $request->file('video');
                    $videoName = uniqid() . '_' . time() . '.' . $video->getClientOriginalExtension();
                    $video->move('uploads/products/videos/', $videoName);
                    $productVideo = new product_video();
                    $productVideo->product_id = $product->id;
                    $productVideo->video_url = $videoName;
                    $productVideo->save();
                }
                // product gallery

                if ($request->hasfile('images')) {
                    $images = $request->file('images');
                    foreach ($images as $image) {
                        $productGallery = new product_gallery();
                        $manager = new ImageManager(['driver' => 'gd']);
                        $ext = $image->getClientOriginalExtension();
                        $fileName = uniqid() . '_' . time() . '.' . $ext;
                        $manager->make($image)->resize(400, 400)->save(public_path('uploads/products/gallery/' . $fileName));
                        $productGallery->product_id = $product->id;
                        $productGallery->image = $fileName;
                        $productGallery->save();
                    }
                }
                $data = [
                    'product' => [
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'totalQty' => $product->totalQty,
                        'url' => route('product.detail', $product->slug)
                    ]
                ];
                $vendorEmail = User::find($vendor_id)->email;
                Mail::send('mail.seller-after-list-product', $data, function ($message) use ($vendorEmail) {
                    $message->to($vendorEmail)
                        ->subject('Your Product Has Been Listed!');
                });
                // here need to send message for success
                $url = route('seller.success.list.product', [$product->slug, 'add']);
                return response()->json(['success' => true, 'message' => 'Product added successfully', 'url' => $url], 200);
            }
        } else {
            return response()->json(['error' => ['message' => "Unauthrized access this page!"]], 422);
        }
    }

    public function storeMultipleProduct(Request $request)
    {
        // dd($request->all());
        if (isset(auth()->user()->id)) {
            $vendor_id = auth()->user()->id;
            $validate = Validator::make(
                $request->all(),
                [
                    'item_title' => 'required|string|max:255',
                    'parent_category_id' => 'required|integer|exists:parent_categories,id',
                    'category_id' => 'required|integer|exists:categories,id',
                    'child_category_id' => 'nullable|integer|exists:subcategories,id',
                    'endchild_category_id' => 'nullable|integer|exists:endsubcategories,id',
                    'item_condition' => 'required|string',
                    'listingType' => 'required|string',
                    'buyer_need_detail' => 'nullable|in:on',
                    'combinations' => 'required|array',
                    'attribute' => 'nullable|array',
                    'attribute.*' => 'nullable',
                    'item_description' => 'nullable|string',
                    'video' => 'nullable|mimetypes:video/mp4,video/mpeg,video/quicktime',
                    'main_gallery_images.*' => 'nullable|image',
                    'ispcs' => 'array',
                    'ispcs.*' => 'nullable|in:on',
                    'currency' => 'array',
                    'currency.*' => 'nullable|in:USD,EUR',
                    'pcsmin' => 'nullable|array',
                    'pcsmin.*' => 'nullable',
                    'pcsmax' => 'nullable|array',
                    'pcsmax.*' => 'nullable',
                    'cost' => 'nullable|array',
                    'cost.*' => 'nullable|numeric|min:0',

                    'totalQty' => 'nullable|min:1|numeric',
                    'isLimitedOffer' => 'nullable|in:on',
                    'isDailyDeal' => 'nullable|in:on',
                    'isBulkBuy' => 'nullable|in:on',
                    'isHotProduct' => 'nullable|in:on',

                    // 'duration' => 'required|integer|min:1',
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
                    'seller_pay' => 'nullable|in:on',
                    'return_timeline' => 'required|integer',
                    'isReturnAccept' => 'nullable|in:on',
                ],
                [
                    'combinations.required' => 'Combinations are required. Please add characterstics and values.',
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
                // first need to check rate table

                $rateTableId = null;
                if ($request->shipping_partner != "") {
                    $newRateTable = new shipping_rate_tables();
                    $newRateTable->shipping_partner = $request->shipping_partner;
                    $newRateTable->shipping_method = $request->shipping_method;
                    $newRateTable->vendor_id = $vendor_id;
                    $newRateTable->save();
                    $rateTableId = $newRateTable->id;

                    foreach ($request->rate_type as $key => $type) {
                        if ($type == 'region') {
                            $newRate = new shipping_rate_cost();
                            $newRate->shipping_rate_id = $rateTableId;
                            $newRate->shipping_type = $type;
                            $newRate->cost = isset($request['shipping_cost'][$key]) ? $request['shipping_cost'][$key] : 0;
                            // dd($request['rate'][$key]);
                            $newRate->save();
                            foreach ($request->rate_regions as $region) {
                                $regions = isset($region) ? $region : [];
                                // dd($regions);
                                if (isset($regions[0]) && $regions[0] == "worldwide") {
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
                                        $newRegion->save();
                                    }
                                }
                            }
                        } elseif ($type == "country") {
                            $newRate = new shipping_rate_cost();
                            $newRate->shipping_rate_id = $rateTableId;
                            $newRate->shipping_type = $type;
                            $newRate->cost = isset($request['shipping_cost'][$key]) ? $request['shipping_cost'][$key] : 0;
                            // dd($request['rate'][$key]);
                            $newRate->save();

                            $countryId = isset($request->rate_country[$key]) ? $request->rate_country[$key] : 0;
                            // dd($countryId);
                            if ($countryId) {
                                $newRegion = new shipping_rate_cost_region();
                                $newRegion->shipping_rate_cost_id = $newRate->id;
                                $newRegion->country_id = $countryId;
                                $newRegion->save();
                            }
                        }
                    }
                }

                $combinations = $request->combinations;
                $com_result = [];
                $pricesAr = [];
                if ($combinations) {
                    foreach ($combinations as $_variant) {
                        if ($_variant['price'] > 0 && $_variant['quantity'] > 0) {
                            $pricesAr[] = $_variant['price'];
                            if (isset($_variant['gallery']) && is_array($_variant['gallery'])) {
                                $uploadedImages = [];

                                foreach ($_variant['gallery'] as $image) {
                                    if ($image instanceof \Illuminate\Http\UploadedFile) {
                                        $imageName = uniqid('product_') . '_' . $image->getClientOriginalName();
                                        $image->move(public_path('uploads/products'), $imageName);
                                        $uploadedImages[] = $imageName;
                                    }
                                }
                            } else {
                                $uploadedImages = [];
                            }
                            $com_result[] = [
                                'quantity' => $_variant['quantity'],
                                'price' => $_variant['price'],
                                'attributes' => $_variant['attributes'],
                                'images' => $uploadedImages
                            ];
                        }
                    }
                }
                $jsonResult = json_encode($com_result, JSON_PRETTY_PRINT);
                $product = new products();
                $product->name = $request->item_title;
                $product->slug = $this->createUniqueSlug($request->item_title);
                $product->description = $request->item_description;
                $minPrice = min($pricesAr) ?? 0;
                $maxPrice = max($pricesAr) ?? 0;
                $product->price = $minPrice;
                $product->minPrice = $minPrice;
                $product->maxPrice = $maxPrice;
                $product->isListingType =  $request->listingType;
                $product->item_condition = $request->item_condition;
                $product->isAttribute = $request->buyer_need_detail == "on" ? 1 : 0;;
                $product->isSetting = 1;
                $product->isRate = 1;
                $product->rate_table_id = $rateTableId ?? null;
                $product->isMultiple = 1;
                $product->variants = $jsonResult;
                $product->vendor_id = $vendor_id;
                $product->totalQty = 0;
                $product->parent_category_id = $request->parent_category_id;
                $product->category_id = $request->category_id;
                $product->subcategory_id = $request->child_category_id;
                $product->childcategory_id = $request->endchild_category_id;
                $product->isLimitedOffer = $request->isLimitedOffer == "on" ? 1 : 0;
                $product->isDailyDeal = $request->isDailyDeal == "on" ? 1 : 0;
                $product->isBulkBuy = $request->isBulkBuy == "on" ? 1 : 0;
                $product->isHotProduct = $request->isHotProduct == "on" ? 1 : 0;
                $product->duration = 0;
                $product->save();


                // extra attributes
                if (isset($request->buyer_need_detail) && $request->buyer_need_detail != "") {
                    $spacific_name = $request->input('spacific_name');
                    $spacific_value = $request->input('spacific_detail');
                    $extrasAttributes = [];

                    if (is_array($spacific_name) && is_array($spacific_value)) {
                        foreach ($spacific_name as $index => $name) {
                            $extrasAttributes[] = [
                                'name' => $name,
                                'value' => $spacific_value[$index] ?? null,
                            ];
                        }
                    }
                    $product->extraAttributes = json_encode($extrasAttributes, JSON_PRETTY_PRINT);
                    $product->save();
                }
                // store attributes value
                if (isset($request->attribute) && isset($request->buyer_need_detail) && $request->buyer_need_detail != "") {

                    foreach ($request->attribute as $key => $value) {
                        if ($value != null && $value != "") {
                            $attributeTable = new product_attribute();
                            $attributeTable->attribute_id = $key;
                            $attributeTable->product_id = $product->id;
                            if (is_array($value)) {
                                $attributeTable->attribute_value = json_encode($value);
                            } else {

                                $attributeTable->attribute_value = $value;
                            }
                            $attributeTable->save();
                        }
                    }
                }


                $setting = new productSetting();
                $setting->product_id = $product->id;
                $setting->handling_time = $request->handling_time;
                $setting->country_id = $request->country_region;
                $setting->state_id = $request->state_region;
                $setting->city = $request->city;
                $setting->pincode = $request->zip;
                $setting->return_timeline = $request->return_timeline;
                $setting->buyer_pay = $request->buyer_pay == "on" ? 1 : 0;
                $setting->seller_pay = $request->seller_pay == "on" ? 1 : 0;
                $setting->isReturnAccept = $request->isReturnAccept == "on" ? 1 : 0;
                $setting->refund = $request->refund;
                $setting->save();


                // for video
                if ($request->hasfile('video')) {
                    $video = $request->file('video');
                    $videoName = uniqid() . '_' . time() . '.' . $video->getClientOriginalExtension();
                    $video->move('uploads/products/videos/', $videoName);
                    $productVideo = new product_video();
                    $productVideo->product_id = $product->id;
                    $productVideo->video_url = $videoName;
                    $productVideo->save();
                }
                // product gallery
                $main_gallery = [];
                if ($request->hasfile('main_gallery_images')) {
                    $images = $request->file('main_gallery_images');
                    foreach ($images as $index => $image) {
                        $manager = new ImageManager(['driver' => 'gd']);
                        $ext = $image->getClientOriginalExtension();
                        $fileName = uniqid() . '_' . time() . '.' . $ext;
                        $manager->make($image)->resize(400, 400)->save(public_path('uploads/products/' . $fileName));
                        $main_gallery[] = [
                            'index' => $index,
                            'image' => $fileName,
                        ];
                    }
                }
                $product->mainGallery = json_encode($main_gallery);
                $product->save();

                $totalQty = 0;
                $prices = [];
                $variants = is_string($product->variants)
                    ? json_decode($product->variants, true)
                    : $product->variants;
                $variants = is_array($variants) ? $variants : [];
                foreach ($variants as $variant) {
                    $totalQty += isset($variant['quantity'])
                        ? (int) $variant['quantity']
                        : 0;
                    if (
                        isset($variant['price']) &&
                        is_numeric($variant['price'])
                    ) {
                        $prices[] = $variant['price'];
                    }
                }
                $pminPrice = !empty($prices)
                    ? min($prices)
                    : $product->minPrice ?? 1;
                $pmaxPrice = !empty($prices)
                    ? max($prices)
                    : $product->maxPrice ?? 1;
                if ($pminPrice == $pmaxPrice) {
                    $product_price = $pminPrice;
                } else {
                    $product_price = $pminPrice . '-$' . $pmaxPrice;
                }

                $data = [
                    'product' => [
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product_price,
                        'totalQty' => $totalQty,
                        'url' => route('product.detail', $product->slug)
                    ]
                ];
                $vendorEmail = User::find($vendor_id)->email;
                Mail::send('mail.seller-after-list-product', $data, function ($message) use ($vendorEmail) {
                    $message->to($vendorEmail)
                        ->subject('Your Product Has Been Listed!');
                });
                // here need to send message for success
                $url = route('seller.success.list.product', [$product->slug, 'add']);
                return response()->json(['success' => true, 'message' => 'Product added successfully', 'url' => $url], 200);
            }
        } else {
            return response()->json(['error' => ['message' => "Unauthrized access this page!"]], 422);
        }
    }

    public function updateProduct(Request $request)
    {
        // dd($request->all());
        if (isset(auth()->user()->id)) {
            $vendor_id = auth()->user()->id;
            $validate = Validator::make(
                $request->all(),
                [
                    'product_id' => 'required|integer|exists:products,id',
                    'item_title' => 'required|string|max:255',
                    'parent_category_id' => 'required|integer|exists:parent_categories,id',
                    'category_id' => 'required|integer|exists:categories,id',
                    'child_category_id' => 'nullable|integer|exists:subcategories,id',
                    'endchild_category_id' => 'nullable|integer|exists:endsubcategories,id',
                    'totalQty' => 'required|numeric',
                    'item_condition' => 'required|string',
                    'buyer_need_detail' => 'nullable|in:on',
                    'attribute' => 'nullable|array',
                    'attribute.*' => 'nullable',
                    'item_description' => 'nullable|string',
                    'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                    'video' => 'nullable|mimetypes:video/mp4,video/mpeg,video/quicktime',

                    'ispcs' => 'array',
                    'ispcs.*' => 'nullable|in:on',
                    'currency' => 'array',
                    'currency.*' => 'nullable|in:USD,EUR',
                    'pcsmin' => 'nullable|array',
                    'pcsmin.*' => 'nullable',
                    'pcsmax' => 'nullable|array',
                    'pcsmax.*' => 'nullable',
                    'cost' => 'nullable|array',
                    'cost.*' => 'nullable|numeric|min:0',

                    'totalQty' => 'nullable|min:1|numeric',
                    'isLimitedOffer' => 'nullable|in:on',
                    'isDailyDeal' => 'nullable|in:on',
                    'isBulkBuy' => 'nullable|in:on',
                    'isHotProduct' => 'nullable|in:on',

                    'duration' => 'required|integer|min:1',
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
                    'seller_pay' => 'nullable|in:on',
                    'return_timeline' => 'required|integer',
                    'isReturnAccept' => 'nullable|in:on',
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
                // first need to check rate table
                $product = products::where('id', $request->product_id)->first();

                if ($product) {

                    $rateTableId = null;
                    if ($request->shipping_partner != "") {
                        $newRateTable = new shipping_rate_tables();
                        $newRateTable->shipping_partner = $request->shipping_partner;
                        $newRateTable->shipping_method = $request->shipping_method;
                        $newRateTable->vendor_id = $vendor_id;
                        $newRateTable->save();
                        $rateTableId = $newRateTable->id;

                        foreach ($request->rate_type as $key => $type) {
                            if ($type == 'region') {
                                $newRate = new shipping_rate_cost();
                                $newRate->shipping_rate_id = $rateTableId;
                                $newRate->shipping_type = $type;
                                $newRate->cost = isset($request['shipping_cost'][$key]) ? $request['shipping_cost'][$key] : 0;
                                // dd($request['rate'][$key]);
                                $newRate->save();
                                foreach ($request->rate_regions as $region) {
                                    $regions = isset($region) ? $region : [];
                                    // dd($regions);
                                    if (isset($regions[0]) && $regions[0] == "worldwide") {
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
                                            $newRegion->save();
                                        }
                                    }
                                }
                            } elseif ($type == "country") {
                                $newRate = new shipping_rate_cost();
                                $newRate->shipping_rate_id = $rateTableId;
                                $newRate->shipping_type = $type;
                                $newRate->cost = isset($request['shipping_cost'][$key]) ? $request['shipping_cost'][$key] : 0;
                                // dd($request['rate'][$key]);
                                $newRate->save();

                                $countryId = isset($request->rate_country[$key]) ? $request->rate_country[$key] : 0;
                                // dd($countryId);
                                if ($countryId) {
                                    $newRegion = new shipping_rate_cost_region();
                                    $newRegion->shipping_rate_cost_id = $newRate->id;
                                    $newRegion->country_id = $countryId;
                                    $newRegion->save();
                                }
                            }
                        }
                    }

                    // delete old rate table
                    $old_shipping_rate = shipping_rate_tables::where('id', $product->rate_table_id)->first();
                    if ($old_shipping_rate) {
                        $old_shipping_rate->delete();
                    }


                    $product->name = $request->item_title;
                    $product->slug = $this->createUniqueSlug($request->item_title);
                    $product->description = $request->item_description;
                    $product->price = isset($request->cost[0]) ? $request->cost[0] : 0;
                    $product->item_condition = $request->item_condition;
                    $product->isAttribute = $request->buyer_need_detail == "on" ? 1 : 0;;
                    $product->isSetting = 1;
                    $product->isRate = 1;
                    $product->rate_table_id = $rateTableId;
                    $product->vendor_id = $vendor_id;
                    $product->totalQty = $request->totalQty;
                    $product->isList = 1;
                    $product->parent_category_id = $request->parent_category_id;
                    $product->category_id = $request->category_id;
                    $product->subcategory_id = $request->child_category_id;
                    $product->childcategory_id = $request->endchild_category_id;
                    $product->isLimitedOffer = $request->isLimitedOffer == "on" ? 1 : 0;
                    $product->isDailyDeal = $request->isDailyDeal == "on" ? 1 : 0;
                    $product->isBulkBuy = $request->isBulkBuy == "on" ? 1 : 0;
                    $product->isHotProduct = $request->isHotProduct == "on" ? 1 : 0;
                    $product->duration = $request->duration;

                    $product->isPrice0 = (isset($request->ispcs[0]) && $request->ispcs[0] == "on") ? 1 : 0;
                    $product->isPrice1 = (isset($request->ispcs[1]) && $request->ispcs[1] == "on") ? 1 : 0;
                    $product->isPrice2 = (isset($request->ispcs[2]) && $request->ispcs[2] == "on") ? 1 : 0;


                    $product->currency0 = (isset($request->currency[0]) && $request->currency[0] != '') ? $request->currency[0] : "USD";
                    $product->currency1 = (isset($request->currency[1]) && $request->currency[1] != '') ? $request->currency[1] : "USD";
                    $product->currency2 = (isset($request->currency[2]) && $request->currency[2] != '') ? $request->currency[2] : "USD";


                    if (isset($request->pcsmin[0]) && isset($request->pcsmax[0])) {
                        $product->qtymin0 = $request->pcsmin[0] ?? 1;
                        $product->qtymax0 = $request->pcsmax[0] ?? 10;
                    }
                    if (isset($request->pcsmin[1]) && isset($request->pcsmax[1])) {
                        $product->qtymin1 = $request->pcsmin[1] ?? 11;
                        $product->qtymax1 = $request->pcsmax[1] ?? 50;
                    }
                    if (isset($request->pcsmin[2]) && isset($request->pcsmax[2])) {
                        $product->qtymin2 = $request->pcsmin[2] ?? 51;
                        $product->qtymax2 = $request->pcsmax[2] ?? 100;
                    }


                    $product->price0 = isset($request->cost[0]) ? $request->cost[0] : 0;
                    $product->price1 = isset($request->cost[1]) ? $request->cost[1] : 0;
                    $product->price2 = isset($request->cost[2]) ? $request->cost[2] : 0;
                    $pricesAr = [];
                    if (isset($request->cost[0]) && $request->cost[0] > 0) {
                        $pricesAr[] = $request->cost[0];
                    }
                    if (isset($request->cost[1]) && $request->cost[1] > 0) {
                        $pricesAr[] = $request->cost[1];
                    }
                    if (isset($request->cost[2]) && $request->cost[2] > 0) {
                        $pricesAr[] = $request->cost[2];
                    }
                    $minPrice = min($pricesAr) ?? 0;
                    $maxPrice = max($pricesAr) ?? 0;
                    $product->price = $minPrice;
                    $product->minPrice = $minPrice;
                    $product->maxPrice = $maxPrice;
                    $product->save();


                    // extra attributes
                    if (isset($request->buyer_need_detail) && $request->buyer_need_detail != "") {
                        $spacific_name = $request->input('spacific_name');
                        $spacific_value = $request->input('spacific_detail');
                        $extrasAttributes = [];

                        if (is_array($spacific_name) && is_array($spacific_value)) {
                            foreach ($spacific_name as $index => $name) {
                                $extrasAttributes[] = [
                                    'name' => $name,
                                    'value' => $spacific_value[$index] ?? null,
                                ];
                            }
                        }
                        $product->extraAttributes = json_encode($extrasAttributes, JSON_PRETTY_PRINT);
                        $product->save();
                    }
                    // delete old attributes
                    $old_attributes = product_attribute::where('product_id', $product->id)->get();
                    if ($old_attributes) {
                        foreach ($old_attributes as $old_attribute) {
                            $old_attribute->delete();
                        }
                    }

                    // store attributes value
                    if (isset($request->attribute) && isset($request->buyer_need_detail) && $request->buyer_need_detail != "") {

                        foreach ($request->attribute as $key => $value) {
                            if ($value != null && $value != "") {
                                $attributeTable = new product_attribute();
                                $attributeTable->attribute_id = $key;
                                $attributeTable->product_id = $product->id;
                                if (is_array($value)) {
                                    $attributeTable->attribute_value = json_encode($value);
                                } else {

                                    $attributeTable->attribute_value = $value;
                                }
                                $attributeTable->save();
                            }
                        }
                    }

                    $old_setting = productSetting::where('product_id', $product->id)->first();
                    if ($old_setting) {
                        $old_setting->delete();
                    }

                    $setting = new productSetting();
                    $setting->product_id = $product->id;
                    $setting->handling_time = $request->handling_time;
                    $setting->country_id = $request->country_region;
                    $setting->state_id = $request->state_region;
                    $setting->city = $request->city;
                    $setting->pincode = $request->zip;
                    $setting->buyer_pay = $request->buyer_pay == "on" ? 1 : 0;
                    $setting->seller_pay = $request->seller_pay == "on" ? 1 : 0;
                    $setting->return_timeline = $request->return_timeline;
                    $setting->isReturnAccept = $request->isReturnAccept == "on" ? 1 : 0;
                    $setting->refund = $request->refund;
                    $setting->save();


                    // for video
                    if ($request->hasfile('video')) {
                        $video = $request->file('video');
                        $videoName = uniqid() . '_' . time() . '.' . $video->getClientOriginalExtension();
                        $video->move('uploads/products/videos/', $videoName);
                        $productVideo = new product_video();
                        $productVideo->product_id = $product->id;
                        $productVideo->video_url = $videoName;
                        $productVideo->save();
                    }
                    // product gallery
                    if ($request->hasfile('images')) {
                        $images = $request->file('images');
                        foreach ($images as $image) {
                            $productGallery = new product_gallery();
                            $manager = new ImageManager(['driver' => 'gd']);
                            $ext = $image->getClientOriginalExtension();
                            $fileName = uniqid() . '_' . time() . '.' . $ext;
                            $manager->make($image)->resize(400, 400)->save(public_path('uploads/products/gallery/' . $fileName));
                            $productGallery->product_id = $product->id;
                            $productGallery->image = $fileName;
                            $productGallery->save();
                        }
                    }

                    $url = route('seller.success.list.product', [$product->slug, 'edit']);
                    return response()->json(['success' => true, 'message' => 'Product updated successfully', 'url' => $url], 200);
                } else {
                    return response()->json(['success' => false, 'message' => 'Product not found'], 200);
                }
            }
        } else {
            return response()->json(['error' => ['message' => "Unauthrized access this page!"]], 422);
        }
    }
    public function updateProductMultiply(Request $request)
    {
        // dd($request->all());
        if (isset(auth()->user()->id)) {
            $vendor_id = auth()->user()->id;
            $validate = Validator::make(
                $request->all(),
                [
                    'product_id' => 'required|integer|exists:products,id',
                    'item_title' => 'required|string|max:255',
                    'parent_category_id' => 'required|integer|exists:parent_categories,id',
                    'category_id' => 'required|integer|exists:categories,id',
                    'child_category_id' => 'nullable|integer|exists:subcategories,id',
                    'endchild_category_id' => 'nullable|integer|exists:endsubcategories,id',
                    'item_condition' => 'required|string',
                    'listingType' => 'required|string',
                    'buyer_need_detail' => 'nullable|in:on',
                    'combinations' => 'required|array',
                    'attribute' => 'nullable|array',
                    'attribute.*' => 'nullable',
                    'item_description' => 'nullable|string',
                    'main_gallery_images.*' => 'nullable|image',
                    'video' => 'nullable|mimetypes:video/mp4,video/mpeg,video/quicktime',

                    'ispcs' => 'array',
                    'ispcs.*' => 'nullable|in:on',
                    'currency' => 'array',
                    'currency.*' => 'nullable|in:USD,EUR',
                    'pcsmin' => 'nullable|array',
                    'pcsmin.*' => 'nullable',
                    'pcsmax' => 'nullable|array',
                    'pcsmax.*' => 'nullable',
                    'cost' => 'nullable|array',
                    'cost.*' => 'nullable|numeric|min:0',

                    'isLimitedOffer' => 'nullable|in:on',
                    'isDailyDeal' => 'nullable|in:on',
                    'isBulkBuy' => 'nullable|in:on',
                    'isHotProduct' => 'nullable|in:on',

                    // 'duration' => 'required|integer|min:1',
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
                    'seller_pay' => 'nullable|in:on',
                    'return_timeline' => 'required|integer',
                    'isReturnAccept' => 'nullable|in:on',
                ],
                [
                    'combinations.required' => 'Combinations are required. Please add characterstics and values.',
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
                $product = products::where('id', $request->product_id)->first();
                if ($product) {
                    // firt get shipping rate table


                    $rateTableId = null;
                    if ($request->shipping_partner != "") {
                        $newRateTable = new shipping_rate_tables();
                        $newRateTable->shipping_partner = $request->shipping_partner;
                        $newRateTable->shipping_method = $request->shipping_method;
                        $newRateTable->vendor_id = $vendor_id;
                        $newRateTable->save();
                        $rateTableId = $newRateTable->id;

                        foreach ($request->rate_type as $key => $type) {
                            if ($type == 'region') {
                                $newRate = new shipping_rate_cost();
                                $newRate->shipping_rate_id = $rateTableId;
                                $newRate->shipping_type = $type;
                                $newRate->cost = isset($request['shipping_cost'][$key]) ? $request['shipping_cost'][$key] : 0;
                                // dd($request['rate'][$key]);
                                $newRate->save();
                                foreach ($request->rate_regions as $region) {
                                    $regions = isset($region) ? $region : [];
                                    // dd($regions);
                                    if (isset($regions[0]) && $regions[0] == "worldwide") {
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
                                            $newRegion->save();
                                        }
                                    }
                                }
                            } elseif ($type == "country") {
                                $newRate = new shipping_rate_cost();
                                $newRate->shipping_rate_id = $rateTableId;
                                $newRate->shipping_type = $type;
                                $newRate->cost = isset($request['shipping_cost'][$key]) ? $request['shipping_cost'][$key] : 0;
                                // dd($request['rate'][$key]);
                                $newRate->save();

                                $countryId = isset($request->rate_country[$key]) ? $request->rate_country[$key] : 0;
                                // dd($countryId);
                                if ($countryId) {
                                    $newRegion = new shipping_rate_cost_region();
                                    $newRegion->shipping_rate_cost_id = $newRate->id;
                                    $newRegion->country_id = $countryId;
                                    $newRegion->save();
                                }
                            }
                        }
                    }

                    // delete old rate table
                    $old_shipping_rate = shipping_rate_tables::where('id', $product->rate_table_id)->first();
                    if ($old_shipping_rate) {
                        $old_shipping_rate->delete();
                    }

                    $variantsOldJson = json_decode($product->variants);
                    $combinations = $request->combinations;
                    $com_result = [];
                    $pricesAr = [];
                    if ($combinations) {
                        foreach ($combinations as $_variant) {
                            if ($_variant['price'] > 0 && $_variant['quantity'] > 0) {
                                $pricesAr[] = $_variant['price'];
                                $uploadedImages = [];
                                $oldImages = [];
                                if (isset($_variant['gallery']) && is_array($_variant['gallery'])) {
                                    foreach ($_variant['gallery'] as $image) {

                                        if (is_file($image)) {
                                            if ($image instanceof \Illuminate\Http\UploadedFile) {
                                                // Save each uploaded image to storage
                                                $imageName = uniqid('product_') . '_' . $image->getClientOriginalName();
                                                $image->move(public_path('uploads/products'), $imageName);
                                                $uploadedImages[] = $imageName;
                                            }
                                        } else {
                                            $uploadedImages[] = $image;
                                        }
                                    }
                                }

                                // Step 2: Find the old variant that matches the current combination
                                $existingVariant = null;
                                foreach ($variantsOldJson as $oldVariant) {
                                    if ($oldVariant->attributes == $_variant['attributes']) {
                                        $existingVariant = $oldVariant;
                                        break;
                                    }
                                }

                                // Step 3: Handle image deletions for variants where the gallery has changed
                                if ($existingVariant) {
                                    $oldImages = $existingVariant->images;
                                    if (!empty($oldImages)) {
                                        foreach ($oldImages as $oldImage) {
                                            if (!in_array($oldImage, $uploadedImages) && file_exists(public_path('uploads/products/' . $oldImage))) {
                                                unlink(public_path('uploads/products/' . $oldImage));
                                            }
                                        }
                                    }
                                }

                                // Step 4: Add current combination (including images) to the result array
                                $com_result[] = [
                                    'quantity' => $_variant['quantity'],
                                    'price' => $_variant['price'],
                                    'attributes' => $_variant['attributes'],
                                    'images' => $uploadedImages
                                ];
                            }
                        }
                    }
                    $jsonResult = json_encode($com_result, JSON_PRETTY_PRINT);

                    $product->name = $request->item_title;
                    $product->slug = $this->createUniqueSlug($request->item_title);
                    $product->description = $request->item_description;
                    $minPrice = min($pricesAr) ?? 0;
                    $maxPrice = max($pricesAr) ?? 0;
                    $product->price = $minPrice;
                    $product->minPrice = $minPrice;
                    $product->maxPrice = $maxPrice;
                    $product->isListingType =  $request->listingType;
                    $product->item_condition = $request->item_condition;
                    $product->isAttribute = $request->buyer_need_detail == "on" ? 1 : 0;;
                    $product->isSetting = 1;
                    $product->isRate = 1;
                    $product->isList = 1;
                    $product->rate_table_id = $rateTableId ?? null;
                    $product->isMultiple = 1;
                    $product->variants = $jsonResult;
                    $product->vendor_id = $vendor_id;
                    $product->totalQty = 0;
                    $product->parent_category_id = $request->parent_category_id;
                    $product->category_id = $request->category_id;
                    $product->subcategory_id = $request->child_category_id;
                    $product->childcategory_id = $request->endchild_category_id;
                    $product->isLimitedOffer = $request->isLimitedOffer == "on" ? 1 : 0;
                    $product->isDailyDeal = $request->isDailyDeal == "on" ? 1 : 0;
                    $product->isBulkBuy = $request->isBulkBuy == "on" ? 1 : 0;
                    $product->isHotProduct = $request->isHotProduct == "on" ? 1 : 0;
                    $product->duration = 0;
                    $product->save();


                    // extra attributes
                    if (isset($request->buyer_need_detail) && $request->buyer_need_detail != "") {
                        $spacific_name = $request->input('spacific_name');
                        $spacific_value = $request->input('spacific_detail');
                        $extrasAttributes = [];

                        if (is_array($spacific_name) && is_array($spacific_value)) {
                            foreach ($spacific_name as $index => $name) {
                                $extrasAttributes[] = [
                                    'name' => $name,
                                    'value' => $spacific_value[$index] ?? null,
                                ];
                            }
                        }
                        $product->extraAttributes = json_encode($extrasAttributes, JSON_PRETTY_PRINT);
                        $product->save();
                    }
                    // delete old attributes
                    $old_attributes = product_attribute::where('product_id', $product->id)->get();
                    if ($old_attributes) {
                        foreach ($old_attributes as $old_attribute) {
                            $old_attribute->delete();
                        }
                    }

                    // store attributes value
                    if (isset($request->attribute) && isset($request->buyer_need_detail) && $request->buyer_need_detail != "") {

                        foreach ($request->attribute as $key => $value) {
                            if ($value != null && $value != "") {
                                $attributeTable = new product_attribute();
                                $attributeTable->attribute_id = $key;
                                $attributeTable->product_id = $product->id;
                                if (is_array($value)) {
                                    $attributeTable->attribute_value = json_encode($value);
                                } else {

                                    $attributeTable->attribute_value = $value;
                                }
                                $attributeTable->save();
                            }
                        }
                    }

                    $old_setting = productSetting::where('product_id', $product->id)->first();
                    if ($old_setting) {
                        $old_setting->delete();
                    }

                    $setting = new productSetting();
                    $setting->product_id = $product->id;
                    $setting->handling_time = $request->handling_time;
                    $setting->country_id = $request->country_region;
                    $setting->state_id = $request->state_region;
                    $setting->city = $request->city;
                    $setting->pincode = $request->zip;
                    $setting->buyer_pay = $request->buyer_pay == "on" ? 1 : 0;
                    $setting->seller_pay = $request->seller_pay == "on" ? 1 : 0;
                    $setting->return_timeline = $request->return_timeline;
                    $setting->isReturnAccept = $request->isReturnAccept == "on" ? 1 : 0;
                    $setting->refund = $request->refund;
                    $setting->save();


                    // for video
                    if ($request->hasfile('video')) {
                        $video = $request->file('video');
                        $videoName = uniqid() . '_' . time() . '.' . $video->getClientOriginalExtension();
                        $video->move('uploads/products/videos/', $videoName);
                        $productVideo = new product_video();
                        $productVideo->product_id = $product->id;
                        $productVideo->video_url = $videoName;
                        $productVideo->save();
                    }

                    $existingGallery = json_decode($product->mainGallery, true) ?? [];
                    $existingPaths = collect($existingGallery)->pluck('image')->toArray();
                    $newGallery = [];
                    // Solve existing images
                    if ($request->has('existing_images')) {
                        foreach ($request->input('existing_images') as $index => $image) {
                            $newGallery[] = [
                                'index' => $index,
                                'image' => $image,
                            ];
                        }
                    }
                    // Handle new uploads
                    if ($request->hasFile('main_gallery_images')) {
                        foreach ($request->file('main_gallery_images') as $index => $image) {
                            $manager = new ImageManager(['driver' => 'gd']);
                            $ext = $image->getClientOriginalExtension();
                            $fileName = uniqid() . '_' . time() . '.' . $ext;
                            $manager->make($image)->resize(400, 400)->save(public_path('uploads/products/' . $fileName));
                            $newGallery[] = [
                                'index' => $index,
                                'image' => $fileName,
                            ];
                        }
                    }

                    $newPaths = collect($newGallery)->pluck('image')->toArray();
                    $imagesToDelete = array_diff($existingPaths, $newPaths);

                    foreach ($imagesToDelete as $image) {
                        if (File::exists(public_path('uploads/products/', $image))) {
                            File::delete(public_path('uploads/products/', $image));
                        }
                    }
                    $product->mainGallery = json_encode($newGallery);
                    $product->save();

                    $url = route('seller.success.list.product', [$product->slug, 'edit']);
                    return response()->json(['success' => true, 'message' => 'Multiplying Product updated successfully', 'url' => $url], 200);
                } else {
                    return response()->json(['success' => false, 'message' => 'Product not found'], 200);
                }
            }
        } else {
            return response()->json(['error' => ['message' => "Unauthrized access this page!"]], 422);
        }
    }



    public function myProduct()
    {
        if (isset(auth()->user()->id)) {
            $products = products::latest()
                ->where('vendor_id', auth()->user()->id)
                ->where('isMultiple', 0)
                ->with('gallery')
                ->get()
                ->filter(function ($product) {
                    $expiryDate = Carbon::parse($product->created_at)->addDays($product->duration);
                    return now()->lessThan($expiryDate);
                });
            // dd($products);
            if ($products) {
                foreach ($products as $product) {
                    $soldQty = OrderItem::where('product_id', $product->id)
                        ->whereHas('order', function ($query) {
                            $query->where('payment_status', '!=', 'processing');
                        })->sum('quantity');
                        
                    $soldPrice = OrderItem::where('product_id', $product->id)
                        ->whereHas('order', function ($query) {
                            $query->where('payment_status', '!=', 'processing');
                        })->sum('total_price');
                    $product->sold = $soldQty;
                    $product->sold_price = $soldPrice;
                }
            }
            $productIds = $products->pluck('id')->toArray();
            if (!empty($productIds)) {
                Products::whereIn('id', $productIds)->update(['isRead' => 1]);
            }
            
            return view('seller-vendor.product.my-products', compact('products'));
        } else {
            return response()->json(['error' => ['message' => "Unauthrized access this page!"]], 422);
        }
    }
    
    public function myInactiveProduct()
    {
        if (isset(auth()->user()->id)) {
            $products = products::latest()
                ->where('vendor_id', auth()->user()->id)
                ->where('isMultiple', 0)
                ->with('gallery')
                ->get()
                ->filter(function ($product) {
                    $expiryDate = Carbon::parse($product->created_at)->addDays($product->duration);
                    return now()->greaterThanOrEqualTo($expiryDate);
                });
            if ($products) {
                foreach ($products as $product) {
                    $soldQty = OrderItem::where('product_id', $product->id)
                        ->whereHas('order', function ($query) {
                            $query->where('payment_status', '!=', 'processing');
                        })->sum('quantity');
                    $soldPrice = OrderItem::where('product_id', $product->id)
                        ->whereHas('order', function ($query) {
                            $query->where('payment_status', '!=', 'processing');
                        })->sum('total_price');
                    $product->sold = $soldQty;
                    $product->sold_price = $soldPrice;
                    $expiryDate = Carbon::parse($product->created_at)->addDays($product->duration);
                    // Check if expired
                    $product->expired = $expiryDate;
                    $isExpired = now()->greaterThanOrEqualTo($expiryDate);
                }
            }
            return view('seller-vendor.product.my-products', compact('products'));
        } else {
            return response()->json(['error' => ['message' => "Unauthrized access this page!"]], 422);
        }
    }

    public function myMultiplyProduct()
    {
        if (isset(auth()->user()->id)) {
            $products = products::latest()->where('vendor_id', auth()->user()->id)->where('isMultiple', 1)->with('gallery')->get();
            $unReadProducts = products::latest()->where('vendor_id', auth()->user()->id)->where('isMultiple', 1)->where('isRead',0)->get();
            if ($products) {
                foreach ($products as $product) {
                    $soldQty = OrderItem::where('product_id', $product->id)
                        ->whereHas('order', function ($query) {
                            $query->where('payment_status', '!=', 'processing');
                        })->sum('quantity');
                    $soldPrice = OrderItem::where('product_id', $product->id)
                        ->whereHas('order', function ($query) {
                            $query->where('payment_status', '!=', 'processing');
                        })->sum('total_price');
                    $product->sold = $soldQty;
                    $product->sold_price = $soldPrice;
                }
            }
            foreach ($unReadProducts ?? [] as $unProduct){
               $unProduct->isRead=1;
               $unProduct->save();
            }
            return view('seller-vendor.product.my-multiply-products', compact('products'));
        } else {
            return response()->json(['error' => ['message' => "Unauthrized access this page!"]], 422);
        }
    }
    public function updateProductAddon(Request $request)
    {
        $product = products::find($request->product_id);

        if ($product && in_array($request->key, ['isLimitedOffer', 'isDailyDeal', 'isBulkBuy', 'isHotProduct', 'isList'])) {
            $product->{$request->key} = $request->value;
            $product->save();
            return response()->json([
                'success' => true,
                'message' => 'Product attribute updated successfully!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to update product attribute.'
        ]);
    }
    public function deleteProduct(Request $request)
    {
        $product = products::find($request->product_id);
        if ($product) {
            $galleries = product_gallery::where('product_id', $product->id)->get();
            if (isset($galleries)) {
                foreach ($galleries as $gallery) {
                    $imagePath = public_path('uploads/products/gallery/' . $gallery->image);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                    $gallery->delete();
                }
            }

            $videos = product_video::where('product_id', $product->id)->get();
            if (isset($videos)) {
                foreach ($videos as $video) {
                    $videoPath = public_path('uploads/products/videos/' . $gallery->video_url);
                    if (File::exists($videoPath)) {
                        File::delete($videoPath);
                    }
                    $video->delete();
                }
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product and associated files deleted successfully!'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete product.'
        ]);
    }



    public function deleteGalleryImage($image_id)
    {
        $gallery = product_gallery::find($image_id);
        if ($gallery) {
            $imagePath = public_path('uploads/products/gallery/' . $gallery->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $gallery->delete();
            return response()->json([
                'success' => true,
                'message' => 'Gallery image deleted successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete gallery image.'
            ]);
        }
    }

    public function successPage($slug, $what = "add")
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $seller = User::where('id', $id)->first();
            $packageData = seller_package::latest()->where('seller_id', $seller->id)->with('package')->first();
            $product = products::latest()->where('vendor_id', $id)->where('slug', $slug)->with('gallery')->first();

            return view('seller-vendor.product.success-add-edit-product', compact('product', 'seller', 'packageData', 'what'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'You are not authorized!']);
        }
    }


    // my buy products
    public function myBuyProducts()
    {
        $orders = Order::latest()->where('user_id', Auth::user()->id)
            ->whereHas('orderItems')
            ->with('orderItems.product.gallery')
            ->paginate(10);
            
        $unOrders = Order::latest()->where('user_id', Auth::user()->id)
            ->where('isRead',0)
            ->whereHas('orderItems')
            ->get();
        foreach ($unOrders ?? [] as $unOrder){
           $unOrder->isRead=1;
           $unOrder->save(); 
        }    
        // dd($orders);
        return view('seller-vendor.product.purchased-products', compact('orders'));
    }

    public function myBuyProductDetail($order_item_id)
    {
        $item = OrderItem::where('id', $order_item_id)
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->with('order', 'rate', 'product.vendor.payment_info', 'product.gallery')
            ->first();
        // dd($item);
        if ($item) {
            return view('seller-vendor.product.buy-product-details', compact('item'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'You are not authorized!']);
        }
    }

    public function mySoldProducts()
    {
        $vendorId = auth()->user()->id;
        $orders = Order::latest()->whereHas('orderItems', function ($query) use ($vendorId) {
            $query->whereHas('product', function ($productQuery) use ($vendorId) {
                $productQuery->where('vendor_id', $vendorId)->where('isMultiple', 0);
            });
        })
            ->with(['orderItems.product.gallery'])
            ->where('payment_status', '!=', 'processing')
            ->paginate(5);
        // dd($orders);
        return view('seller-vendor.product.sold-products', compact('orders'));
    }
    public function mySoldProductMultiply()
    {
        $vendorId = auth()->user()->id;
        $orders = Order::latest()->whereHas('orderItems', function ($query) use ($vendorId) {
            $query->whereHas('product', function ($productQuery) use ($vendorId) {
                $productQuery->where('vendor_id', $vendorId)->where('isMultiple', 1);
            });
        })
            ->with(['orderItems.product.gallery'])
            ->where('payment_status', '!=', 'processing')
            ->paginate(10);
            
       $orderItemIds = OrderItem::whereHas('product', function ($query) use ($vendorId) {
                      $query->where('vendor_id', $vendorId)
                            ->where('isMultiple', 1);
       })
      ->where('isRead',0)
      ->whereHas('order', function ($query) {
        $query->where('payment_status', '!=', 'processing');
      })
      ->pluck('id');
      
        OrderItem::whereIn('id', $orderItemIds)->update(['isRead' => 1]);
        
        return view('seller-vendor.product.sold-products', compact('orders'));
    }
    public function mySoldProductDetail($order_item_id)
    {
        $item = OrderItem::where('id', $order_item_id)
            ->whereHas('product', function ($query) {
                $query->where('vendor_id', Auth::user()->id);
            })
            ->with('order', 'product.vendor', 'product.gallery')
            ->first();

        if ($item) {
            return view('seller-vendor.product.sold-product-details', compact('item'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'You are not authorized!']);
        }
    }

    public function updatePaymentStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_status' => 'required|in:pending,failed,payment_check,paid',
        ]);

        $order = Order::find($request->order_id);
        $order->payment_status = $request->payment_status;
        $order->save();

        return response()->json(['message' => 'Payment status updated successfully.']);
    }
    public function updateOrderItemStatus(Request $request)
    {
        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'col' => 'required|string',
            'value' => 'required|string',
        ]);
        if ($request->col == "shipment_status" && $request->value=="shipped") {
            if ($request->has('shipping_company') && $request->input('shipping_company')!="" && $request->has('tracking_number') && $request->input('tracking_number')!="") {
                $orderItem = OrderItem::find($request->order_item_id);
                $orderItem[$request->col] = $request->value;
                $orderItem->shippment_company = $request->shipping_company;
                $orderItem->tracking_number = $request->tracking_number;
                $orderItem->save();
                return response()->json(['status' => true, 'message' => 'Status updated successfully!']);
            } else {
                return response()->json(['status' => false, 'message' => 'Shipping company and tracking number are required!']);
            }
        }
        
        $orderItem = OrderItem::find($request->order_item_id);
        $orderItem[$request->col] = $request->value;
        $orderItem->save();
        return response()->json(['status'=>true,'message' => 'Status updated successfully.']);
    }
}
