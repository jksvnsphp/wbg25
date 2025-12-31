<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('account_type', 'seller')->with('countryData', 'sellerPackage')->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('company_name', 'like', "%{$request->search}%")
                  ->orWhere('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $sellers = $query->paginate(10)->withQueryString();

        return view('admin.sellers.index', compact('sellers'));
    }

    public function create()
    {
        return view('admin.sellers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_name' => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:6',
        ]);

        $data['account_type'] = 'seller';
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('admin.sellers.index')->with('success', 'Seller created successfully.');
    }

    public function show(User $seller)
    {
        return view('admin.sellers.show', compact('seller'));
    }

    public function edit(User $seller)
    {
        return view('admin.sellers.edit', compact('seller'));
    }

    public function update(Request $request, User $seller)
    {
        $data = $request->validate([
            'company_name' => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $seller->id,
            'password'     => 'nullable|string|min:6',
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $seller->update($data);

        return redirect()->route('admin.sellers.index')->with('success', 'Seller updated successfully.');
    }

    public function destroy(User $seller)
    {
        $seller->delete();
        return redirect()->route('admin.sellers.index')->with('success', 'Seller deleted successfully.');
    }
}
