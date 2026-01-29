<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\company_certificate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = company_certificate::with('user')
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->orderBy('id', 'desc')
            ->get()
            ->groupBy('vendor_id');

        return view('admin.certifications.index', compact('certificates'));
    }

    public function create()
    {
        $vendors = User::where('account_type', 'seller')->get();
        return view('admin.certificates.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:users,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = $request->file('image')->store('certificates', 'public');

        company_certificate::create([
            'vendor_id' => $request->vendor_id,
            'image' => $path,
        ]);

        return redirect()->route('admin.certificates.index')->with('success', 'Certificate added successfully.');
    }

    public function edit(company_certificate $certificate)
    {
        $vendors = User::where('account_type', 'seller')->get();
        return view('admin.certificates.edit', compact('certificate', 'vendors'));
    }

    public function update(Request $request, company_certificate $certificate)
    {
        $request->validate([
            'vendor_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'vendor_id' => $request->vendor_id,
        ];

        if ($request->hasFile('image')) {
            if ($certificate->image && Storage::disk('public')->exists($certificate->image)) {
                Storage::disk('public')->delete($certificate->image);
            }
            $data['image'] = $request->file('image')->store('certificates', 'public');
        }

        $certificate->update($data);

        return redirect()->route('admin.certificates.index')->with('success', 'Certificate updated successfully.');
    }

    public function destroy(company_certificate $certificate)
    {
        if ($certificate->image && Storage::disk('public')->exists($certificate->image)) {
            Storage::disk('public')->delete($certificate->image);
        }
        $certificate->delete();

        return redirect()->route('admin.certificates.index')->with('success', 'Certificate deleted successfully.');
    }
}
