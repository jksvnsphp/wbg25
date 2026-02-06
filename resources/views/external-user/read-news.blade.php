@extends('external-user.external-frame')
@section('meta_data')
<title>{{ $metaTitle ?? ($news->title ?? 'WBG24') }}</title>
<meta name="description" content="{{ $metaDescription ?? '' }}">
<meta name="keywords" content="{{ $metaKeywords ?? '' }}">
@endsection
@section('external-main-content')
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12 mb-4">
            <!-- Products -->
            <nav aria-label="breadcrumb" class="mb-2 mt-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" onclick="window.history.go(-1); return false;">Back</a></li>
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $news->title }}
                    </li>
                </ol>
            </nav>
            <div class="row mt-5">

                <div class="col-md-12 mb-3">
                    <div class="card bg-white rounded-0 shadow">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-md-2">
                                    <h5 class="fw-bold text-info">
                                        {{ isset($news->vendor->company->name) ? $news->vendor->company->name : '' }}
                                    </h5>
                                    <div class="d-flex mt-2">
                                        @php
                                        $rating = $news->average_rating ?? 0;
                                        $fullStars = floor($rating);
                                        $emptyStars = (5 - $fullStars);
                                        @endphp

                                        @for ($s = 0; $s < $fullStars; $s++)
                                            <i class="fas fa-star text-secondary"></i>
                                            @endfor
                                            @for ($s = 0; $s < $emptyStars; $s++)
                                                <i class="fas fa-star " style="color:gray;"></i>
                                                @endfor
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <span class="fw-bold text-dark">{{ $news->title }}</span>
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <h5 class="fw-bold text-secondary">{{ date('d M Y', strtotime($news->updated_at)) }}
                                    </h5>
                                </div>

                                <div class="col-md-1  d-flex align-items-center">
                                    <img src="https://flagcdn.com/160x120/{{ strtolower($news->country->iso2) }}.png"
                                        style="height:2rem;" alt="">
                                </div>
                                <div style="border-left: 1px solid gray;"
                                    class="col-md-3 d-flex align-items-center justify-content-center">
                                    <a href="{{ route('seller.profile.view', $news->vendor->ref_no) }}"
                                        class="btn btn-primary">View Supplier Profile</a>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-2">
                                    <img src="@if (isset($news->image) && $news->image != null) {{ asset('uploads/news/' . $news->image) }}
                                         @else
                                       https://placehold.co/200 @endif
                                    "
                                        alt="{{ $news->title }}"
                                        class="
                                        img-fluid rounded-3">
                                </div>
                                <div class="col-md-10">
                                    {!! $news->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@include('external-user.inc-parts.listCard')
@endsection