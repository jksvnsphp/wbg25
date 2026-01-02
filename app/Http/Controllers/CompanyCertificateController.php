<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\company_certificate;
use App\Models\seller_package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
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
            // dd($certificates->toArray());
            return view('seller-vendor.company-certificates', compact('certificates', 'seller', 'packageData'));
        } else {
            return redirect()->route('login')->with(['alert-type' => 'warning', 'message' => 'Please login before access this page.']);
        }
    }



    public function updateCompanyCertificate(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'certifications'   => ['nullable', 'array'],
            'other_certificate' => ['nullable', 'array'],
            'images'           => ['required', 'array'],
            'images.0'         => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'images.*'         => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'images.required'   => 'Please upload at least one certificate image.',
            'images.0.required' => 'Certificate Image 1 is required.',
            'images.*.image'    => 'Each uploaded file must be a valid image.',
            'images.*.mimes'    => 'Images must be JPG or PNG format.',
            'images.*.max'      => 'Each image must not exceed 2MB.',
        ]);

        $validator->after(function ($validator) use ($request) {
            // Validate "Other" certificate text
            if (
                is_array($request->certifications)
                && in_array('Other', $request->certifications)
                && empty(array_filter($request->other_certificate ?? []))
            ) {
                $validator->errors()->add(
                    'other_certificate',
                    'Please specify at least one certificate name when selecting "Other".'
                );
            }

            // Image dimension validation
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    if (!$file) continue;

                    [$width, $height] = getimagesize($file);

                    if ($width != 480 || $height != 360) {
                        $validator->errors()->add(
                            "images.$index",
                            "Image must be exactly 480px × 360px (4:3 ratio)."
                        );
                    }
                }
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $vendorId = auth()->id();

        // Save certification text
        $company = company::firstOrCreate(['vendor_id' => $vendorId]);
        $company->certifications    = json_encode($request->certifications);
        $company->other_certificate = json_encode($request->other_certificate);
        $company->save();

        // Save images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if (!$file) continue;

                $imageName = uniqid('certificate_') . '.' . $file->getClientOriginalExtension();
                $manager = new ImageManager(['driver' => 'gd']);

                $manager->make($file)
                    ->resize(480, 360)
                    ->save(public_path('uploads/certificates/' . $imageName));

                company_certificate::create([
                    'vendor_id' => $vendorId,
                    'image'     => $imageName,
                ]);
            }
        }

        return redirect()
            ->route('seller.success.gallery')
            ->with('success', 'Congratulation, Your certification has updated successfully and is showing online now!');
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
