<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\news;
use App\Models\SellerNews;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Intervention\Image\ImageManager;

class NewsBlogController extends Controller
{
    //
    public function allNews()
    {
        
        $newss = SellerNews::latest()->with('vendor')->get();

        return view('admin.news.all-news', compact('newss'));
    }

     public function allNewsImages()
    {
        
        $news = SellerNews::with('vendor')->whereNotNull('image')
              ->where('image', '!=', '')->latest()->paginate(10);

        return view('admin.action-image.news', compact('news'));
    }
    public function addNews()
    {

        return view('admin.news.add-news');
    }
    public function updateStatus(Request $request)
    {

        $news = news::findOrFail($request->id);
        $news->status = $request->status;
        $news->save();
        return response()->json(['status' => true]);
    }
    public function storeNews(Request $request)
    {
        // slug,title,image,content,author_id
        $request->merge([
            'slug' => Str::slug($request->title)
        ]);

        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string|max:255',
                'slug' => 'required|string|unique:news,slug',
                'url' => 'required|url',
                'description' => 'required|string',
                'image' => 'required|image|mimes:jpg,jpeg,png|max:204',
            ]
        );
        // dd($validator->errors());
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Please check your data']);
        } else {
            $news = new news();
            $news->title = $request->title;
            $news->slug = $request->slug;
            $news->url = $request->url;
            $news->content = $request->description;
            $news->author_id = auth()->user()->id;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $manager = new ImageManager(['driver' => 'gd']);
                $ext = $file->getClientOriginalExtension();
                $fileName = uniqid('news_' . $news->id) . '.' . $ext;
                $manager->make($file)->resize(500, 500)->save(public_path('uploads/news/' . $fileName));
                $news->image = $fileName;
            }
            $news->save();
            // $seller = auth()->user();
            
            //     sendDynamicMail(
            //         $seller->id,
            //         'confirmation_of_your_news_listing', // slug from email_templates
            //         [ 
            //             '[User Name]' => $seller->first_name,
            //             '[News]'     => 'News Published',
            //             '[Title of the Listing]'  => $news->title,
            //             '[Listing Link]'    =>  route('seller.my.news' )
            //         ]
            //     );
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully publish your news'])->withErrors($validator->errors());
        }
    }
    public function updateNews(Request $request)
    {
        // slug,title,image,content,author_id
        $request->merge([
            'slug' => Str::slug($request->title)
        ]);

        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:news,id',
                'title' => 'required|string|max:255',
                'slug' => 'required|string|unique:news,slug,' . $request->id,
                'url' => 'required|url',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:204',
            ]
        );
        // dd($validator->errors());
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->with(['alert-type' => 'error', 'message' => 'Please check your data']);
        } else {
            $news = news::where('id', $request->id)->first();
            if (!empty($news)) {

                $news->title = $request->title;
                $news->slug = $request->slug;
                $news->url = $request->url;
                $news->content = $request->description;
                $news->author_id = auth()->user()->id;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $manager = new ImageManager(['driver' => 'gd']);
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('news_' . $news->id) . '.' . $ext;
                    $manager->make($file)->resize(500, 500)->save(public_path('uploads/news/' . $fileName));
                    $news->image = $fileName;
                }
                $news->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update your news'])->withErrors($validator->errors());
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'This news is not found'])->withErrors($validator->errors());
            }
        }
    }

     public function updateVendorNews(Request $request)
    {
        // slug,title,image,content,author_id
        $request->merge([
            'slug' => Str::slug($request->title)
        ]);

        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:seller_news,id',
                'title' => 'required|string|max:255',
                'slug' => 'required|string|unique:seller_news,slug,' . $request->id,
                'url' => 'required|url',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:204',
            ]
        );
         //dd($validator->errors());
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->with(['alert-type' => 'error', 'message' => 'Please check your data']);
        } else {
            $news = SellerNews::where('id', $request->id)->first();
            if (!empty($news)) {

                $news->title = $request->title;
                $news->slug = $request->slug;
                //$news->url = $request->url;
                $news->short_description = $request->description;
                $news->vendor_id = auth()->user()->id;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $manager = new ImageManager(['driver' => 'gd']);
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('news_' . $news->id) . '.' . $ext;
                    $manager->make($file)->resize(500, 500)->save(public_path('uploads/news/' . $fileName));
                    $news->image = $fileName;
                }
                $news->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update your news'])->withErrors($validator->errors());
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'This news is not found'])->withErrors($validator->errors());
            }
        }
    }

    public function deleteNews($id)
    {
        $news = news::findOrFail($id);
        if (!empty($news)) {
            if ($news->image != '') {
                $imagePath = public_path('/uploads/news/' . $news->image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
            $news->delete();
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'This news is not found']);
        }
    }
       public function deleteVendorNews($id)
    {
        $news = SellerNews::findOrFail($id);
        if (!empty($news)) {
            if ($news->image != '') {
                $imagePath = public_path('/uploads/news/' . $news->image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
            $news->delete();
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'This news is not found']);
        }
    }
    public function editNews($id)
    {
       // die('here');
        $news = SellerNews::findOrFail($id);
       // echo "<pre>";
       // print_r($news);
       // echo "</pre>";die;
        if (!empty($news)) {
            return view('admin.news.edit', compact('news'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'This news is not found']);
        }
    }
}
