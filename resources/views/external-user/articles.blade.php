@extends('external-user.external-frame')

@section('external-main-content')
    <style>
        .category-section {
            margin-bottom: 2rem;
        }

        .category-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 1rem;
        }

        .card-custom {
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
            height: 100%;
        }

        .card-custom:hover {
            transform: translateY(-5px);
        }

        .card-body {
            text-align: left;
        }

        .card-equal-height {
            min-height: 12rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding-bottom: 10px;
        }

        .short-text {
            overflow: hidden;
            text-align: justify !important;
            text-overflow: ellipsis;
        }

        .owl-dots {
            display: flex !important;
            justify-content: center;
            align-items: center;
            margin-top: 1rem !important;
            height: 20px !important;
        }

        .owl-dot {
            height: 12px !important;
            width: 12px !important;
            margin: 0 5px !important;
            background-color: #fff !important;
            border-radius: 50% !important;
            display: inline-block !important;
        }

        .owl-dot.active {
            background-color: orangered !important;
        }
    </style>
    <div class="container my-5">
        <!-- User Icon & Business Profile Title -->
        <div class="text-center mb-4">
            <i class="{{ $icon }} fa-3x text-primary"></i>
            <h2 class="fw-bold mt-2">{{ $heading }}</h2>
        </div>

    </div>
    <section class="bg-primary py-5">
        <div class="container">
            <div class="owl-carousel help-slider">
                @foreach ($helpTopics as $topic)
                    <div class="card shadow-sm p-3 pb-0 border-0 text-center card-equal-height">
                        <h5 class="fw-bold text-primary">{{ $topic['title'] }}</h5>
                        <p class="text-muted text-justify short-text">{{ $topic['content'] }}</p>
                        <a href="#" class="read-more text-primary fw-bold" style="display: none;">Read More</a>
                        <div class="card-footer d-none bg-white text-muted small fw-bold">{{ $topic['reading_time'] }} min read
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="container my-5 mt-5">
        @foreach ($categories as $categoryIndex => $category)
            <div class="category-section">
                <h3 class="category-title fs-5 text-primary fw-bold mb-4">{{ $category['name'] }}</h3>
                <div class="row">
                    @foreach ($category['articles'] as $articleIndex => $article)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card card-custom category-{{ $categoryIndex }}-article-{{ $articleIndex }} h-100">
                                <div class="card-body">
                                    <h5 class="fw-bold">{{ $article['title'] }}</h5>
                                    <p class="text-muted short-text">{{ $article['content'] }}</p>
                                    <a href="#" class="read-more text-primary fw-bold" style="display: none;">Read
                                        More</a>
                                </div>
                                <div class="card-footer d-none bg-white text-muted small fw-bold">
                                    {{ $article['reading_time'] }} min read
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary" type="button" onclick="history.back()">
                    <i class="fa fa-arrow-left"></i> Back
                </button>
            </div>
        </div>
    </div>
    
    @include('external-user.inc-parts.listCard')
@endsection
@section('custom-js-external')
    <script>
        $(document).ready(function() {
            $(".help-slider").owlCarousel({
                loop: true,
                margin: 15,
                nav: true,
                dots: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                }
            });

            $(".short-text").each(function() {
                let fullText = $(this).text().trim();
                if (fullText.length > 100) {
                    let shortText = fullText.substring(0, 100) + '...';
                    $(this).text(shortText);
                    $(this).siblings(".read-more").show().click(function(e) {
                        e.preventDefault();
                        $(".short-text").each(function() {
                            $(this).text($(this).text().substring(0, 100) + '...');
                            $(this).siblings(".read-more").show();
                        });

                        $(this).siblings(".short-text").text(fullText);
                        $(this).hide();
                    });
                }
            });
        });
    </script>
@endsection
