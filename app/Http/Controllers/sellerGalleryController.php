<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\seller_package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Mail;
use App\Mail\ImagesUploadedMail;

class sellerGalleryController extends Controller
{
    //
    public function vendorGallery()
    {
        $id = auth()->user()->id;
        $user = User::where('id', $id)->with('company')->first();
        if (!empty($user)) {
            return view('seller-vendor.company-vendor-profile-gallery', compact('user'));
        } else {
            abort(404);
        }
    }
    public function deleteVendorProfile()
    {
        $id = auth()->user()->id;; // Assuming the user is authenticated
        $user = User::where('id', $id)->first();
        if ($user->profile) {
            $path = public_path('/uploads/profile/' . $user->profile);
            if (File::exists($path)) {
                File::delete($path);
            }
            $user->profile = null;
            $user->save();
            Auth::login($user);
        }

        return response()->json(['success' => true, 'message' => 'Profile picture deleted successfully.']);
    }
    public function deleteCompanylogo()
    {
        $id = auth()->user()->id;;
        $company = company::where('vendor_id', $id)->first();
        if ($company->company_logo) {
            $path = public_path('/uploads/profile/' . $company->company_logo);
            if (File::exists($path)) {
                File::delete($path);
            }
            $company->company_logo = null;
            $company->save();
        }

        return response()->json(['success' => true, 'message' => 'Company logo deleted successfully.']);
    }
    public function deleteCompanyBanner()
    {
        $id = auth()->user()->id;;
        $company = company::where('vendor_id', $id)->first();
        if ($company->company_logo) {
            $path = public_path('/uploads/profile/' . $company->profile_banner);
            if (File::exists($path)) {
                File::delete($path);
            }
            $company->profile_banner = null;
            $company->save();
        }

        return response()->json(['success' => true, 'message' => 'Business banner deleted successfully.']);
    }
    public function deleteVendorGallery($col)
    {
        $id = auth()->user()->id;;
        $company = company::where('vendor_id', $id)->first();
        if ($company) {
            $path = public_path('/uploads/profile/' . $company->$col);
            if (File::exists($path)) {
                File::delete($path);
            }
            $company->$col = null;
            $company->save();
            return back()->with(['alert-type' => 'success', 'message' => 'Company gallery image deleted successfully.']);
        } else {
            abort(404, 'Sorry! Company Profile Not Found.');
        }
    }
    public function updateVendorProfile(Request $request)
    {
        $id = auth()->user()->id;;
        $user = User::where('id', $id)->first();
        $company = company::where('vendor_id', $id)->first();
		$uploadedImagesCount = 0;
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $manager = new ImageManager(['driver' => 'gd']);
            $ext = $file->getClientOriginalExtension();
            $fileName = uniqid('seller_' . $user->id) . '.' . $ext;
            $manager->make($file)->resize(200, 200)->save(public_path('uploads/profile/' . $fileName));
            $path = public_path('/uploads/profile/' . $user->profile);
            if (File::exists($path)) {
                File::delete($path);
            }
            $user->profile = $fileName;
            $user->save();
        }

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $manager = new ImageManager(['driver' => 'gd']);
            $ext = $file->getClientOriginalExtension();
            $fileName = uniqid('business_logo_' . $company->id) . '.' . $ext;
            $manager->make($file)->resize(200, 200)->save(public_path('uploads/profile/' . $fileName));
            $path = public_path('/uploads/profile/' . $company->company_logo);
            if (File::exists($path)) {
                File::delete($path);
            }
            $company->company_logo = $fileName;
            $company->save();
        }

        if ($request->hasFile('profile_banner')) {
            $file = $request->file('profile_banner');
            $manager = new ImageManager(['driver' => 'gd']);
            $ext = $file->getClientOriginalExtension();
            $fileName = uniqid('profile_banner_' . $company->id) . '.' . $ext;
            $manager->make($file)->resize(2520, 622)->save(public_path('uploads/profile/' . $fileName));
            $path = public_path('/uploads/profile/' . $company->profile_banner);
            if (File::exists($path)) {
                File::delete($path);
            }
            $company->profile_banner = $fileName;
            $company->save();
        }
        if (isset($request->col)) {
            $cols = $request->col;
            foreach ($cols as $col) {
                if ($request->hasFile($col)) {
                    $file = $request->file($col);
                    $manager = new ImageManager(['driver' => 'gd']);
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('profile_image_' . $company->id) . '.' . $ext;
                    $manager->make($file)->resize(400, 400)->save(public_path('uploads/profile/' . $fileName));
                    $path = public_path('/uploads/profile/' . $company->$col);
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    $company->$col = $fileName;
                    $company->save();
					$uploadedImagesCount++;
                }
            }
        }

try {
        Mail::to($user->email)->send(new ImagesUploadedMail($user, $uploadedImagesCount));
    } catch (\Exception $e) {
        \Log::error('Failed to send uploaded images email: ' . $e->getMessage());
    }

        session()->flash('success', 'Congratulation, Your profile gallery successfully updated and online now!');
        return redirect()->route('seller.success.gallery');
    }
    public function spotlightGallery(){
        $id = auth()->user()->id;
        $user = User::where('id', $id)->with('company')->first();
        if (!empty($user)) {
            return view('seller-vendor.product.spotlight-store-gallery', compact('user'));
        } else {
            abort(404);
        }
    }
    public function updateSpotlightGallery(Request $request)
    {
        $id = auth()->user()->id;
        $company = company::where('vendor_id', $id)->first();
        if ($request->hasFile('spotlight_banner')) {
            $file = $request->file('spotlight_banner');
            $manager = new ImageManager(['driver' => 'gd']);
            $ext = $file->getClientOriginalExtension();
            $fileName = uniqid('spotlight_banner_' . $company->id) . '.' . $ext;
            $manager->make($file)->resize(2520, 622)->save(public_path('uploads/profile/' . $fileName));
            $path = public_path('/uploads/profile/' . $company->spotlight_banner);
            if (File::exists($path)) {
                File::delete($path);
            }
            $company->spotlight_banner = $fileName;
            $company->save();
            session()->flash('success', 'Congratulation, Your spotlight gallery updated successfully and online now!');
            return redirect()->route('seller.success.gallery');
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please choose image!']);
        }
    }
    public function successPage()
    {
        if (isset(auth()->user()->id) && session()->has('success')) {
            $message = session('success');
            $seller = User::where('id', auth()->user()->id)->first();
            $packageData = seller_package::latest()->where('seller_id', $seller->id)->with('package')->first();
            return view('seller-vendor.success-vendor-profile', compact('seller', 'packageData', 'message'));;
        } else {
            return redirect()->route('seller.dashboard');
        }
    }
    public function updateBusinessLogo(Request $request)
    {
        $id = auth()->user()->id;; // Assuming the user is authenticated
        $company = company::where('vendor_id', $id)->first();
        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $manager = new ImageManager(['driver' => 'gd']);
            $ext = $file->getClientOriginalExtension();
            $fileName = uniqid('business_logo_' . $company->id) . '.' . $ext;
            $manager->make($file)->resize(200, 200)->save(public_path('uploads/profile/' . $fileName));
            $path = public_path('/uploads/profile/' . $company->company_logo);
            if (File::exists($path)) {
                File::delete($path);
            }
            $company->company_logo = $fileName;
            $company->save();
            return back()->with(['alert-type' => 'success', 'message' => 'Your Business profile image updated successfully.']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please choose an profile image.']);
        }
    }
    public function updateBusinessProfileBanner(Request $request)
    {
        $id = auth()->user()->id;; // Assuming the user is authenticated
        $company = company::where('vendor_id', $id)->first();
        if ($request->hasFile('profile_banner')) {
            $file = $request->file('profile_banner');
            $manager = new ImageManager(['driver' => 'gd']);
            $ext = $file->getClientOriginalExtension();
            $fileName = uniqid('profile_banner_' . $company->id) . '.' . $ext;
            $manager->make($file)->resize(2520, 622)->save(public_path('uploads/profile/' . $fileName));
            $path = public_path('/uploads/profile/' . $company->company_logo);
            if (File::exists($path)) {
                File::delete($path);
            }
            $company->profile_banner = $fileName;
            $company->save();
            return back()->with(['alert-type' => 'success', 'message' => 'Your business profile banner updated successfully']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please choose an profile banner image.']);
        }
    }
    public function updateBusinessGallery(Request $request)
    {
        $id = auth()->user()->id;; // Assuming the user is authenticated
        $company = company::where('vendor_id', $id)->first();
        $col = $request->col;
        if ($request->hasFile($col)) {
            $file = $request->file($col);
            $manager = new ImageManager(['driver' => 'gd']);
            $ext = $file->getClientOriginalExtension();
            $fileName = uniqid('profile_image_' . $company->id) . '.' . $ext;
            $manager->make($file)->resize(400, 400)->save(public_path('uploads/profile/' . $fileName));
            $path = public_path('/uploads/profile/' . $company->$col);
            if (File::exists($path)) {
                File::delete($path);
            }
            $company->$col = $fileName;
            $company->save();
            return back()->with(['alert-type' => 'success', 'message' => 'Your Business gallery image add/updated successfully']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please choose an image.']);
        }
    }
}
