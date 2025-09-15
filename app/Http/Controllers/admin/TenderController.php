<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use App\Models\User;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
         $tenders = Tender::with(['vendor']) // eager load seller/buyer
           // ->where('type', 'buy') // assuming you have a type column ('buy'/'sell')
            ->latest()
            ->paginate(10);

        return view('admin.approval-center.buy-tender-approval',compact('tenders'));
    }

    

    /**
     * Show form for creating a new product.
     */
    public function create()
    {
        $sellers = Tender::where('account_type', 'seller')->get();
        return view('admin.tenders.create', compact('sellers'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'user_id'    => 'required|exists:users,id',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_approved'=> 'nullable|boolean'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        products::create($data);

        return redirect()->route('admin.tenders.index')
            ->with('success', 'Tender created successfully.');
    }

    /**
     * Show details of a product.
     */
    public function show(Tender $product)
    {
        return view('admin.tenders.show', compact('tender'));
    }

    /**
     * Edit form.
     */
    public function edit(Tender $tender)
    {
        $sellers = User::where('account_type', 'seller')->get();
        return view('admin.products.edit', compact('tender', 'sellers'));
    }

    /**
     * Update a product.
     */
    public function update(Request $request, Tender $tender)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'user_id'    => 'required|exists:users,id',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_approved'=> 'nullable|boolean'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.tenders.index')
            ->with('success', 'Tender updated successfully.');
    }

    /**
     * Delete a product.
     */
    public function destroy(Tender $tender)
    {
        if ($product->image && file_exists(storage_path('app/public/' . $product->image))) {
            unlink(storage_path('app/public/' . $product->image));
        }
        $tender->delete();

        return redirect()->route('admin.tenders.index')
            ->with('success', 'Tender deleted successfully.');
    }

    /**
     * Toggle approval via AJAX.
     */
    public function toggleApproval(Request $request)
    {
        $product = Tender::findOrFail($request->id);
        $product->is_approved = $request->approved;
        $product->save();

        return response()->json(['success' => true]);
    }
}
