@extends('external-user.external-frame')

@section('external-main-content')
    <style>
        .cat-list-scroll {
            max-height: 20rem;
            overflow-y: scroll;
            scrollbar-width: thin;
            scrollbar-color: rgb(209, 209, 209) transparent;
        }

        
        .cat-list-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .cat-list-scroll::-webkit-scrollbar-thumb {
            background-color: gray;
            border-radius: 10px;
            
        }

        .cat-list-scroll::-webkit-scrollbar-track {
            background-color: transparent;
           
        }

        .word_carlist {
            margin-bottom: 10px;
        }
    </style>
    <div class=" w-100">
        <div class="bg-primary mt-3 py-4 px-4">
            <h1 class="fs-4 fw-bold">All Categories</h1>
        </div>
        <div class="container-fluid mt-3">
            <div class="row">
                @foreach ($categories as $category)
                    <div class="col-md-6 col-xs-12 box_div_panel mb-3">
                        <div class="card rounded-0 " style="min-height: 25rem">
                            <div class="card-header bg-transparent py-3">
                                <h5> {{ $category->category_name }} </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-5 col-xs-12">
                                        <div class="p-3">
                                            <a href="">
                                                <img class="img-responsive lazyloaded img-fluid"
                                                    src="{{ asset('uploads/category-images/' . $category->classified_image) }}"
                                                    alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-xs-12">
                                        <div class="cat-list-scroll">
                                            @if (isset($category->children) && $category->children != '')
                                                @forelse ($category->children as $child)
                                                    <div class="list-group word_carlist">
                                                        <a href="" class="text-dark d-flex align-items-center">
                                                            <img src="https://www.worldbusinessguide.com/assets/themes/img/arrow_right.png"
                                                                class="me-2">
                                                            {{ $child->category_name }}
                                                        </a>
                                                    </div>
                                                @empty
                                                    <div class="list-group word_carlist">
                                                        Category not found!
                                                    </div>
                                                @endforelse
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('external-user.inc-parts.listCard')
@endsection
