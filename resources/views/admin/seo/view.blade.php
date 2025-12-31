@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0 ">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        SEO Details
                    </div>
                    <div class="card-body pb-0">
                        <div class="row">
						
						

<ul>
    <li><strong>Page:</strong> {{ $seo->page }}</li>
    <li><strong>Title:</strong> {{ $seo->title }}</li>
    <li><strong>Keywords:</strong> {{ $seo->keywords }}</li>
    <li><strong>Description:</strong> {{ $seo->description }}</li>
</ul>
	
						
				
 </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('custom-js')
    
    
@endsection
