<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use App\Models\CustomeCategory;
use App\Models\seller_package;
use App\Models\SellerNews;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class SellerNewsController extends Controller
{
    //
    public function addNews()
    {
        $vendor_id = auth()->user()->id;
        $seller = User::where('id', $vendor_id)->first();

        $packageData = seller_package::latest()->where('seller_id', $seller->id)->with('package')->first();
        $listedNews = SellerNews::where('vendor_id', $vendor_id)->count();
        $listingLimit = $packageData->package->sellTenderLimit ?? 0;
        $packageType = $packageData->package->type ?? '';
        $listedLeft = $listingLimit - $listedNews;
        if ($listedLeft <= 0) {
            session()->flash('info-message', 'Your Member Package Upload Credit for news have been used up...');
            session()->flash('info-content', 'If you would Upload more news, please Upgrade your Membership Package first.');
            $vendorEmail = $seller->email;
            $data = [
                'name' => $seller->first_name,
                'heading' => 'Your Member Package Upload Credit for news have been used up...',
                'message_content' => 'If you would Upload more news, please Upgrade your Membership Package first.',
                'url' => route('user.member.package'),
            ];
            Mail::send('mail.seller-listing-expired', $data, function ($message) use ($vendorEmail) {
                $message->to($vendorEmail)
                    ->subject('Your News listing limit has been expired!');
            });
            return redirect()->route('seller.upgrade.limit')->with(['alert-type' => 'warning', 'message' => 'Your product listing limit has been complete!']);
        }
        $categories = CustomeCategory::where('status', "1")->where('deleted', "0")->where('parent_id', "0")->orderBy('category_name', 'ASC')->get();
        return view('seller-vendor.news.add-news', compact('categories','listingLimit', 'listedNews'));
    }
    public function saveNews(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $vendor_id = auth()->user()->id;

            // Validation
            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'nullable|exists:seller_news,id',
                    'title' => 'required|string|max:255',
                    'category' => 'required|exists:category,id',
                    'sub_category' => 'required|exists:category,id',
                    'duration' => 'required|in:7,10,21,28,30',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg',
                    'news' => 'required|string',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator->errors())
                    ->withInput($request->all())
                    ->with(['alert-type' => 'error', 'message' => 'Validation failed.']);
            }


            if ($request->id == '') {
                $sellerNews = new SellerNews;
            } else {
                $sellerNews = SellerNews::find($request->id);
                if (!$sellerNews || $sellerNews->vendor_id != $vendor_id) {
                    return back()->with(['alert-type' => 'error', 'message' => 'News not found or you do not have permission to edit this news.']);
                }
            }

            // Generate a unique slug if it's a new entry or title has changed
            if ($request->id == '' || $sellerNews->title != $request->title) {
                $slug = Str::slug($request->input('title'));
                $originalSlug = $slug;
                $count = 1;

                while (SellerNews::where('slug', $slug)->exists()) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }
                $sellerNews->slug = $slug;
            }

            // Assign fields
            $sellerNews->title = $request->title;
            $sellerNews->category_id = $request->category;
            $sellerNews->subcategory_id = $request->sub_category;
            $sellerNews->duration = $request->duration;
            $shortNewsContent = Str::limit($request->news, 500);
            if (Str::length($shortNewsContent) < 250) {
                $shortNewsContent = Str::limit($request->news, 250);
            }
            $sellerNews->short_description = $shortNewsContent;
            $sellerNews->description = $request->news;
            $sellerNews->vendor_id = $vendor_id;

            // Process and compress the image if uploaded
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $manager = new ImageManager(['driver' => 'gd']);
                $ext = $image->getClientOriginalExtension();
                $fileName = uniqid() . '_' . time() . '.' . $ext;

                // Compress and resize the image
                $manager->make($image)->resize(200, 200)->save(public_path('uploads/news/' . $fileName));
                $sellerNews->image = $fileName;
            }

            $sellerNews->save();
            $what=$request->id?"edit":"add";
            $message = $request->id ? 'Successfully updated the news.' : 'Successfully published your news.';
            return redirect()->route('seller.success.news',[$sellerNews->slug,$what])->with(['alert-type' => 'success', 'message' => $message]);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first before accessing this page']);
        }
    }


    public function mynews()
    {
        $vendor_id = auth()->user()->id;
        $news = SellerNews::where('vendor_id', $vendor_id)->get();
        return view('seller-vendor.news.my-news', compact('news'));
    }
    public function statusChange(Request $request)
    {
        $news = SellerNews::where('id', $request->id)->first();
        if ($news) {
            $news->isPublish = $request->status;
            $news->save();
        }
        return response()->json(['success' => true, 'message' => 'Status changed']);
    }
    public function deleteNews(Request $request)
    {
        $news = SellerNews::where('id', $request->id)->first();
        if ($news) {
            $newsImg = public_path('uploads/news/' . $news->image);
            if (File::exists($newsImg)) {
                File::delete($newsImg);
            }
            $news->delete();
            return response()->json(['success' => true, 'message' => 'News deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'News not found']);
    }


    public function editNews($slug)
    {
        $vendor_id = auth()->user()->id;
        $categories = CustomeCategory::where('status', "1")->where('deleted', "0")->where('parent_id', "0")->orderBy('category_name', 'ASC')->get();

        $news = SellerNews::where('slug', $slug)->where('vendor_id', $vendor_id)->first();
        if (isset($news)) {
            $subCategories = [];
            if (isset($news->category_id)) {
                $subCategories = CustomeCategory::where('status', "1")->where('deleted', "0")->where('parent_id', $news->category_id)->orderBy('category_name', 'ASC')->get();
            }
            // dd($subCategories);
            return view('seller-vendor.news.edit-news', compact('news', 'categories', 'subCategories'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'News not  found']);
        }
    }

    public function successPage($slug,$what="add"){
        if(isset(auth()->user()->id)){
            $seller = User::where('id', auth()->user()->id)->first();
            $packageData = seller_package::latest()->where('seller_id', $seller->id)->with('package')->first();
            $news = SellerNews::where('slug', $slug)->where('vendor_id',auth()->user()->id)->first();
            if($news){
                return view('seller-vendor.news.success-edit-add-news', compact('news','seller','packageData','what'));
            }else{
                abort(404, 'News not found!');
            }
        }else{
            abort(403, 'Forbidden');
        }
    }
}
