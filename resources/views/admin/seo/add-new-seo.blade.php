@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <!-- Page Heading -->
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card rounded-0 ">
                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                    Add New SEO for page
                </div>
                <div class="card-body pb-0">
                    <div class="row">

                        <form method="post" action="{{ route('admin.seo.save') }}">
                            @csrf
                            @include('admin.seo.form', ['seo' => null])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')


@endsection