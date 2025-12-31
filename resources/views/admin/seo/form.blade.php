<div class="row">

    <div class="col-md-6">
        <div class="form-group">
            <label>Page</label>
            <select class="form-control" name="page">
                <option value="">Select</option>
                <option value="home" {{ isset($seo) && $seo->page=='home' ? 'selected' : '' }}>Home</option>
                <option value="product" {{ isset($seo) && $seo->page=='product' ? 'selected' : '' }}>Product</option>
                <option value="news" {{ isset($seo) && $seo->page=='news' ? 'selected' : '' }}>News</option>
                <option value="all-categories	" {{ isset($seo) && $seo->page=='all-categories	' ? 'selected' : '' }}>All Categories</option>
                <option value="supplier" {{ isset($seo) && $seo->page=='supplier' ? 'selected' : '' }}>Supplier</option>
				<option value="suppliers" {{ isset($seo) && $seo->page=='suppliers' ? 'selected' : '' }}>suppliers</option>
				<option value="tenders" {{ isset($seo) && $seo->page=='tenders' ? 'selected' : '' }}>tenders</option>
				<option value="get-quote" {{ isset($seo) && $seo->page=='get-quote' ? 'selected' : '' }}>Get Quote</option>
				<option value="source-pro" {{ isset($seo) && $seo->page=='source-pro' ? 'selected' : '' }}>Source Pro</option>
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control" name="title" value="{{ $seo->title ?? '' }}">
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Keywords</label>
            <input type="text" class="form-control" name="keywords" value="{{ $seo->keywords ?? '' }}">
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="description" rows="6">{{ $seo->description ?? '' }}</textarea>
        </div>
    </div>

    <div class="col-12">
        <button class="btn btn-primary">Save</button>
    </div>

</div>
