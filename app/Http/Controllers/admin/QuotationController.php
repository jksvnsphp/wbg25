<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CustomeCategory;
use App\Models\OfferQuotation;
use App\Models\Quotation;
use App\Models\QuotationCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class QuotationController extends Controller
{
    //
    public function index()
    {
        $items = QuotationCategory::withCount('subCategories')->orderBy('name', 'ASC')->get();
        return view('admin.quotation_management.index', ['items' => $items]);
    }

    public function changeStatus(Request $request)
    {
        // dd($request->all());
        $supplier = QuotationCategory::where('id', $request->id)->first();
        $supplier->status = $request->status;
        if ($supplier->save()) {
            return response()->json(['success' => 'Status Changed Successfully']);
        } else {
            return response()->json(['error' => 'Something went wrong']);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|unique:quotation_categories,name',
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            $slug = Str::slug($request->name);
            //    check slug is exist or not
            $QuotationCategory = QuotationCategory::where('slug', $slug)->first();
            if (!empty($QuotationCategory)) {
                return back()->with(['alert-type' => 'error', 'message' => 'Slug is already taken!']);
            } else {
                $QuotationCategory = new QuotationCategory();
                $QuotationCategory->name = $request->name;
                $QuotationCategory->slug = Str::slug($request->name);
                $QuotationCategory->meta_keyword = $request->meta_keyword;
                $QuotationCategory->meta_description = $request->meta_description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('category_') . '.' . $ext;
                    $file->move(public_path('/uploads/quotation_category/'), $fileName);
                    $QuotationCategory->image = $fileName;
                }
                $QuotationCategory->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Quotation sub Category added successfully']);
            }
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|string|exists:quotation_categories,id',
                'name' => 'required|string|unique:quotation_categories,name,' . $request->id,
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {

            $QuotationCategory = QuotationCategory::where('id', $request->id)->first();
            if (!empty($QuotationCategory)) {

                $QuotationCategory->name = $request->name;
                $QuotationCategory->slug = Str::slug($request->name);
                $QuotationCategory->meta_keyword = $request->meta_keyword;
                $QuotationCategory->meta_description = $request->meta_description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('category_') . '.' . $ext;
                    $file->move(public_path('/uploads/quotation_category/'), $fileName);
                    if ($QuotationCategory->image != '') {
                        $oldfile = public_path('/uploads/quotation_category/' . $QuotationCategory->image);
                        if (File::exists($oldfile)) {
                            File::delete($oldfile);
                        }
                    }
                    $QuotationCategory->image = $fileName;
                }
                $QuotationCategory->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Quotation Category updated successfully']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Quotation Category not found!']);
            }
        }
    }


    public function DeleteCategory($category_id)
    {
        $QuotationCategory = QuotationCategory::where('id', $category_id)->first();
        if (!empty($QuotationCategory)) {
            if ($QuotationCategory->image != '') {
                $oldfile = public_path('/uploads/quotation_category/' . $QuotationCategory->image);
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }

            $QuotationCategory->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
        }
    }
    public function edit($category_id)
    {
        $QuotationCategory = QuotationCategory::where('id', $category_id)->first();
        if (!empty($QuotationCategory)) {

            return view('admin.quotation_management.edit_quotation_category', ['pcat' => $QuotationCategory]);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
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
            return view('buyer-vendor.quotation-management.view-my-quotations', compact('quotations'));
        } else {
            return back()->with(['alert-type' => 'unauth', 'message' => 'You must be logged in to access this page!']);
        }
    }

      public function allQuotations()
    {
        
            $quotations = Quotation::latest()
            ->whereNotNull('image_1')
              ->where('image_1', '!=', '')   
               // ->where('user_id', auth()->user()->id)
                //->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])
                ->with('category')->paginate(10); 
                //echo "<pre/>";
                //print_r($quotations);die;
            return view('admin.action-image.quotations', compact('quotations'));
        
    }

     public function allListedQuotations()
    {
        
            $quotations = Quotation::latest()
               // ->where('user_id', auth()->user()->id)
                //->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])
                ->with('category')->paginate(10); 
                //echo "<pre/>";
                //print_r($quotations);die;
            return view('admin.quotation_management.quotationl', compact('quotations'));
        
    }

      public function allListedDealQuotations()
    {
        
            $quotations = Quotation::latest()
               // ->where('user_id', auth()->user()->id)
                //->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])
                ->with('category')->paginate(10); 
                //echo "<pre/>";
                //print_r($quotations);die;
            return view('admin.quotation_management.quotationlDeal', compact('quotations'));
        
    }


    public function myExpiredQuotations()
    {
        if (isset(auth()->user()->id)) {
            $quotations = Quotation::latest()
                ->where('user_id', auth()->user()->id)
                ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) < ?', [Carbon::now()])
                ->with('category')
                ->get();
            return view('buyer-vendor.quotation-management.view-my-quotations', compact('quotations'));
        } else {
            return back()->with(['alert-type' => 'unauth', 'message' => 'You must be logged in to access this page!']);
        }
    }

    //showQuotations
     public function showQuotations($id)
    {
        
            $inquiry = Quotation::where('id', $id)
                ->with('category','vendor','vendor.company')
                ->first(); 
                
            return view('admin.quotation_management.show_quotation', compact('inquiry'));
        
    }
    public function editQuotation($quotation_id)
    {
        $quotation = Quotation::where('id', $quotation_id)->where('user_id', Auth::user()->id)->first();
        $categories = CustomeCategory::where('status', 1)
            ->where('deleted', '0')
            ->where('parent_id', '0')
            ->orderBy('category_name', 'ASC')
            ->get();
        if (!empty($quotation)) {
            return view('buyer-vendor.quotation-management.edit-quotation', compact('quotation', 'categories'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Quotation not found!']);
        }
    }
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

    public function updateQuotation(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $rules = [
                'id' => 'required|exists:quotations,id',
                'product_service' => 'required|string',
                'requirement_details' => 'required|string',
                'quantity' => 'required',
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
                    $quotation->slug = $this->createUniqueSlug($request->product_service, $request->id);
                    $quotation->requirement_details = $request->input('requirement_details');
                    $quotation->quantity = $request->input('quantity');
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
                            $manager->make($image)->resize(400, 400)->save(public_path('uploads/quotation/' . $fileName));
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

    public function mySubmittedQuotes()
    {
        if (isset(auth()->user()->id)) {
            $user = auth()->user();
            $quotations = OfferQuotation::latest()->where('user_id', $user->id)->where('status', '!=', 'accept')->with('quotation.vendor')->get();
            return view('buyer-vendor.quotation-management.my-submitted-quotes', compact('quotations'));
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

       public function deleteQuotation(Request $request)
    {
        if (isset($request->quotation_id)) {
            $quotation = Quotation::where('id', $request->quotation_id)->first();
            if ($quotation->id == $request->quotation_id) {
                for ($i = 1; $i <= 4; $i++) {
                    $imagePath = public_path('uploads/quotation/' . $quotation->image . '_' . $i);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                }
                $quotation->delete();
                //return response()->json(['success' => true, 'message' => 'Successfully deleted your quotation!']);
                 return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Successfully deleted your quotation!']);
            } else {
                return response()->json(['success' => false, 'message' => 'You are not authorized to delete this quotation!']);
                 return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Successfully deleted your quotation!']);
            }
        } else {
            return response()->json(['success' => false,  'message' => 'You must be logged in to access this page!']);
        }
    }
}
