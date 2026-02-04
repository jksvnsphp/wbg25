<div class="row">

    @php
    $seoPage = data_get($seo ?? null, 'page');
    $seoPageNormalized = is_string($seoPage) ? trim($seoPage, '/') : $seoPage;
    $seoTitle = data_get($seo ?? null, 'title');
    $seoKeywords = data_get($seo ?? null, 'keywords');
    $seoDescription = data_get($seo ?? null, 'description');
    @endphp

    <div class="col-md-6">
        <div class="form-group">
            <label>Page</label>
            <select class="form-control" name="page">
                <option value="">Select</option>
                <option value="home" {{ $seoPageNormalized == 'home' ? 'selected' : '' }}>Home</option>
                <option value="/login" {{ $seoPageNormalized == 'login' ? 'selected' : '' }}>Login</option>
                <option value="products" {{ $seoPageNormalized == 'products' ? 'selected' : '' }}>Products</option>
                <option value="news" {{ $seoPageNormalized == 'news' ? 'selected' : '' }}>News</option>
                <option value="/product-videos" {{ $seoPageNormalized == 'product-videos' ? 'selected' : '' }}>Product Videos</option>
                <option value="all-categories" {{ $seoPageNormalized == 'all-categories' ? 'selected' : '' }}>All Categories</option>
                <option value="suppliers" {{ $seoPageNormalized == 'suppliers' ? 'selected' : '' }}>Suppliers</option>
                <option value="/supplier-by-region" {{ $seoPageNormalized == 'supplier-by-region' ? 'selected' : '' }}>Supplier By Region</option>
                <option value="tenders" {{ $seoPageNormalized == 'tenders' ? 'selected' : '' }}>Tenders</option>
                <option value="/stores" {{ $seoPageNormalized == 'stores' ? 'selected' : '' }}>Stores</option>
                <option value="get-quote" {{ $seoPageNormalized == 'get-quote' ? 'selected' : '' }}>Get Quote</option>
                <option value="source-pro" {{ $seoPageNormalized == 'source-pro' ? 'selected' : '' }}>Source Pro</option>
                <option value="how-to-buy" {{ $seoPageNormalized == 'how-to-buy' ? 'selected' : '' }}>How To Buy</option>
                <option value="how-to-sell" {{ $seoPageNormalized == 'how-to-sell' ? 'selected' : '' }}>How To Sell</option>
                <option value="user/help-support" {{ $seoPageNormalized == 'user/help-support' ? 'selected' : '' }}>Help & Support</option>
                <option value="user/benefits-for-buyers" {{ $seoPageNormalized == 'user/benefits-for-buyers' ? 'selected' : '' }}>Benefits For Buyers</option>
                <option value="member-packages" {{ $seoPageNormalized == 'member-packages' ? 'selected' : '' }}>Member Packages</option>
                <option value="privacy-and-policy" {{ $seoPageNormalized == 'privacy-and-policy' ? 'selected' : '' }}>Privacy And Policy</option>
                <option value="data-protection" {{ $seoPageNormalized == 'data-protection' ? 'selected' : '' }}>Data Protection</option>
                <option value="imprint" {{ $seoPageNormalized == 'imprint' ? 'selected' : '' }}>Imprint</option>
                <option value="terms-and-conditions" {{ $seoPageNormalized == 'terms-and-conditions' ? 'selected' : '' }}>Terms And Conditions</option>
                <option value="limited-offer/products" {{ $seoPageNormalized == 'limited-offer/products' ? 'selected' : '' }}>Limited Offer Products</option>
                <option value="bulk-buying/products" {{ $seoPageNormalized == 'bulk-buying/products' ? 'selected' : '' }}>Bulk Buying Products</option>
                <option value="daily-deals/products" {{ $seoPageNormalized == 'daily-deals/products' ? 'selected' : '' }}>Daily Deals Products</option>
                <option value="hot/products" {{ $seoPageNormalized == 'hot/products' ? 'selected' : '' }}>Hot Products</option>

            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control" name="title" value="{{ $seoTitle ?? '' }}">
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Keywords</label>
            <input type="text" class="form-control" name="keywords" value="{{ $seoKeywords ?? '' }}">
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="description" rows="6">{{ $seoDescription ?? '' }}</textarea>
        </div>
    </div>

    <div class="col-12">
        <button class="btn btn-primary">Save</button>
    </div>

</div>