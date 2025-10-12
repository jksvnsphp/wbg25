<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = products::with('vendor');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('seller', function ($q) use ($search) {
                    $q->where('company_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
        }

        // Sort
        if ($request->filled('sort') && $request->sort == 'latest') {
            $query->latest();
        } else {
            $query->orderBy('id', 'asc');
        }

        $products = $query->paginate(10)->withQueryString();
       die;
        return view('admin.products.index', compact('products'));
    }
    //productmanagment

    public function productmanagment(Request $request)
    {
      
        // $query = products::with('vendor','gallery');
         $query = products::with('vendor','gallery')->where('totalQty','>', 0);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('seller', function ($q) use ($search) {
                    $q->where('company_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
        }

        // Sort
        if ($request->filled('sort') && $request->sort == 'latest') {
            $query->latest();
        } else {
            $query->orderBy('id', 'asc');
        }

        $products = $query->paginate(10)->withQueryString();
      // die;
        return view('admin.product_managment.product-manager', compact('products'));
    }

       public function productselloutmanagment(Request $request)
    {
      
        // $query = products::with('vendor','gallery');
         $query = products::with('vendor','gallery')->where('totalQty','<=', 0);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('seller', function ($q) use ($search) {
                    $q->where('company_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
        }

        // Sort
        if ($request->filled('sort') && $request->sort == 'latest') {
            $query->latest();
        } else {
            $query->orderBy('id', 'asc');
        }

        $products = $query->paginate(10)->withQueryString();
      // die;
        return view('admin.product_managment.product-manager-sellout', compact('products'));
    }


        public function storeproductmanagment(Request $request)
    {
      
        // $query = products::with('vendor','gallery');
         $query = products::with('vendor','gallery')->where('totalQty','>', 0)
         ->where('isListingType', 'spotlight');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('seller', function ($q) use ($search) {
                    $q->where('company_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
        }

        // Sort
        if ($request->filled('sort') && $request->sort == 'latest') {
            $query->latest();
        } else {
            $query->orderBy('id', 'asc');
        }

        $products = $query->paginate(10)->withQueryString();
        return view('admin.product_managment.product-manager-store', compact('products'));
    }
    
       public function storeselloutproductmanagment(Request $request)
    {
      
        // $query = products::with('vendor','gallery');
         $query = products::with('vendor','gallery')->where('totalQty','<=', 0)
         ->where('isListingType', 'spotlight');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('seller', function ($q) use ($search) {
                    $q->where('company_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
        }

        // Sort
        if ($request->filled('sort') && $request->sort == 'latest') {
            $query->latest();
        } else {
            $query->orderBy('id', 'asc');
        }

        $products = $query->paginate(10)->withQueryString();
        //product-manager-sellout.blade
        return view('admin.product_managment.product-manager-store-multiply', compact('products'));
    }
    // $query = products::with('vendor','gallery')->where('totalQty','<=', 0);
 //product_image
     public function product_image(Request $request)
    {
        $query = products::with('vendor','gallery');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('seller', function ($q) use ($search) {
                    $q->where('company_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
        }

        // Sort
        if ($request->filled('sort') && $request->sort == 'latest') {
            $query->latest();
        } else {
            $query->orderBy('id', 'asc');
        }

        $products = $query->paginate(10)->withQueryString();

        return view('admin.action-image.products', compact('products'));
    }


      public function multiply_product_image(Request $request)
    {
        $query = products::with('vendor','gallery')->where('isMultiple', 1);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('seller', function ($q) use ($search) {
                    $q->where('company_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
        }

        // Sort
        if ($request->filled('sort') && $request->sort == 'latest') {
            $query->latest();
        } else {
            $query->orderBy('id', 'asc');
        }

        $products = $query->paginate(10)->withQueryString();

        return view('admin.action-image.multiple_products', compact('products'));
    }

    /**
     * Show form for creating a new product.
     */
    public function create()
    {
        $sellers = User::where('account_type', 'seller')->get();
        return view('admin.products.create', compact('sellers'));
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

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show details of a product.
     */
    public function show(products $product)
    {
       // echo '<pre>'; print_r($product->toArray()); die;
        return view('admin.products.show', compact('product'));
    }

    /**
     * Edit form.
     */
    public function edit(products $product)
    {
        $sellers = User::where('account_type', 'seller')->get();
        return view('admin.products.edit', compact('product', 'sellers'));
    }

    /**
     * Update a product. isList
     */
    public function update(Request $request, products $product)
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

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Delete a product.
     */
    public function destroy(products $product)
    {
        if ($product->image && file_exists(storage_path('app/public/' . $product->image))) {
            unlink(storage_path('app/public/' . $product->image));
        }
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Toggle approval via AJAX.
     */
    public function toggleApproval(Request $request)
    {
        $product = products::findOrFail($request->id);
        $product->isList = $request->status;
        $product->save();

        return response()->json(['success' => true]);
    }
}
