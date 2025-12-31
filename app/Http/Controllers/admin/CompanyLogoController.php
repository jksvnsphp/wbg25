<?php 
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyLogoController extends Controller
{
    public function index()
    {
        $companies = company::with('user')->where('company_logo','!=',NULL)->latest()->paginate(10);
        return view('admin.company-logos.index', compact('companies'));
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('admin.company-logos.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $request->validate([
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        if ($request->hasFile('company_logo')) {
            // Delete old logo if exists
            if ($company->company_logo && Storage::exists('public/company-logos/'.$company->company_logo)) {
                Storage::delete('public/company-logos/'.$company->company_logo);
            }

            $filename = time().'_'.$request->company_logo->getClientOriginalName();
            $request->company_logo->storeAs('public/company-logos', $filename);
            $company->company_logo = $filename;
        }

        $company->save();

        return redirect()->route('admin.company-logos.index')
            ->with('success', 'Company Logo updated successfully.');
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        if ($company->company_logo && Storage::exists('public/company-logos/'.$company->company_logo)) {
            Storage::delete('public/company-logos/'.$company->company_logo);
        }
        //$company->company_logo = null;
        //$company->save();
         $company->delete();
        // Alternatively, if you want to just remove the logo reference without deleting the record:
      ///  $company->update(['company_logo' => null]);

        return redirect()->route('admin.company-logos.index')
            ->with('success', 'Company Logo deleted successfully.');
    }

     public function changeStatus(Request $request)
    {
        // dd($request->all());
        $supplier = Company::where('id', $request->id)->first();
        $supplier->status = $request->status;
        if ($supplier->save()) {
            return response()->json(['success' => 'Status Changed Successfully']);
        } else {
            return response()->json(['error' => 'Something went wrong']);
        }
    }

}
