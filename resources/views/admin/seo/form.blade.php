<div class="row">

    <div class="col-md-6">
        <div class="form-group">
            <label>Page</label>
            <select class="form-control" name="page">
                <option value="">Select</option>

                <option value="home" {{ (isset($seo['page']) && $seo['page'] == 'home') || (isset($seo->page) && $seo->page == 'home') ? 'selected' : '' }}>Home</option>

                <option value="product" {{ (isset($seo['page']) && $seo['page'] == 'product') || (isset($seo->page) && $seo->page == 'product') ? 'selected' : '' }}>Product</option>

                <option value="news" {{ (isset($seo['page']) && $seo['page'] == 'news') || (isset($seo->page) && $seo->page == 'news') ? 'selected' : '' }}>News</option>

                <option value="all-categories" {{ (isset($seo['page']) && $seo['page'] == 'all-categories') || (isset($seo->page) && $seo->page == 'all-categories') ? 'selected' : '' }}>All Categories</option>

                <option value="supplier" {{ (isset($seo['page']) && $seo['page'] == 'supplier') || (isset($seo->page) && $seo->page == 'supplier') ? 'selected' : '' }}>Supplier</option>

                <option value="suppliers" {{ (isset($seo['page']) && $seo['page'] == 'suppliers') || (isset($seo->page) && $seo->page == 'suppliers') ? 'selected' : '' }}>Suppliers</option>

                <option value="tenders" {{ (isset($seo['page']) && $seo['page'] == 'tenders') || (isset($seo->page) && $seo->page == 'tenders') ? 'selected' : '' }}>Tenders</option>

                <option value="get-quote" {{ (isset($seo['page']) && $seo['page'] == 'get-quote') || (isset($seo->page) && $seo->page == 'get-quote') ? 'selected' : '' }}>Get Quote</option>

                <option value="source-pro" {{ (isset($seo['page']) && $seo['page'] == 'source-pro') || (isset($seo->page) && $seo->page == 'source-pro') ? 'selected' : '' }}>Source Pro</option>
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control" name="title"
                   value="{{ $seo['title'] ?? $seo->title ?? '' }}">
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Keywords</label>
            <input type="text" class="form-control" name="keywords"
                   value="{{ $seo['keywords'] ?? $seo->keywords ?? '' }}">
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="description" rows="6">{{ $seo['description'] ?? $seo->description ?? '' }}</textarea>
        </div>
    </div>

    <div class="col-12">
        <button class="btn btn-primary">Save</button>
    </div>

</div>
