<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\company_certificate;
use App\Models\seller_package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;

class CompanyCertificateController extends Controller
{
    //
    public function allCertificates()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $seller = User::where('id', $id)->with('company', 'exports')->first();
            $packageData = seller_package::latest()->where('seller_id', $seller->id)->with('package')->first();
            $certificates = company_certificate::where('vendor_id', $id)->get();
            return view('seller-vendor.company-certificates', compact('certificates', 'seller', 'packageData'));
        } else {
            return redirect()->route('login')->with(['alert-type' => 'warning', 'message' => 'Please login before access this page.']);
        }
    }

    public function updateCompanyCertificate(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'certifications' => ['nullable', 'array'],
            'other_certificate' => ['required_if:certifications,Other'],
        ]);
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $company = company::where('vendor_id', $id)->first();
            if (!empty($company)) {
                $company->certifications = json_encode($request->certifications);
                $company->other_certificate = json_encode($request->other_certificate);
                $company->save();
            }
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {

                    $certificate = new company_certificate();
                    $certificate->vendor_id = $id;
                    $manager = new ImageManager(['driver' => 'gd']);
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('profile_banner_' . $certificate->id) . '.' . $ext;
                    $manager->make($file)->resize(500, 500)->save(public_path('uploads/certificates/' . $fileName));

                    $certificate->image = $fileName;
                    $certificate->save();
                }
            }
            session()->flash('success', 'Congratulation, Your certification has updated successfully and is showing online now!');
            return redirect()->route('seller.success.gallery');
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function deleteCertificate($c_id)
    {
        $id = auth()->user()->id;
        $company = company_certificate::where('vendor_id', $id)->where('id', $c_id)->first();
        if ($company->image) {
            $path = public_path('/uploads/certificates/' . $company->image);
            if (File::exists($path)) {
                File::delete($path);
            }
            $company->delete();
        }

        return back()->with(['alert-type' => 'success', 'message' => 'Certificate deleted successfully.']);
    }
}
