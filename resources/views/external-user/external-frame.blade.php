<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @hasSection('meta_data')
    @yield('meta_data')
    @else
    @php
    $seo = $seo ?? [
    'title' => config('app.name'),
    'keywords' => '',
    'description' => '',
    ];
    @endphp

    <title>{{ $seo['title'] }}</title>
    <meta name="keywords" content="{{ $seo['keywords'] }}">
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="author" content="WBG24.com">
    @endif


    <link rel="shortcut icon" href="{{ asset('world-business/images/logos/logo.png') }}" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />

    <link rel="stylesheet" href="{{ asset('world-business/assets/styles/style.css') }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <link rel="stylesheet" href="{{ asset('world-business/assets/plugins/css/dropdown-style.css') }}" />
    <script src="{{ asset('world-business/assets/plugins/js/modernizr.js') }}"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.3.2/build/css/intlTelInput.css">
    <link href="https://vjs.zencdn.net/7.15.4/video-js.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        p,
        h1,
        h2,
        h3,
        h5,
        h6 {
            margin: 0;
            padding: 0;
        }


        body {
            top: 0 !important;
        }

        .video-js {
            background: #000;
            border: 2px solid #fff;
            border-radius: 10px;
        }

        .video-js .vjs-play-control {
            background-color: #f41909;
            /* Custom play button color */
        }

        .video-js .vjs-control-bar {
            background: rgba(0, 0, 0, 0.7);
            /* Semi-transparent background for controls */
        }

        .video-js .vjs-big-play-button {
            font-size: 3em;
            color: #fff;
        }

        .video-js .vjs-big-play-button {
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            width: 2em !important;
        }

        .video-js .vjs-tech {
            border-radius: 10px !important;
        }

        #\:1\.container {
            display: none !important;
        }

        #goog-gt-tt {
            display: none !important;
        }

        font,
        font:focus,
        font:hover {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }

        .goog-te-gadget-simple {
            background-color: #fff;
            border: 1px solid #ddd !important;
            display: inline-block;
            padding-top: 4px !important;
            padding-bottom: 4px !important;
            cursor: pointer;
        }

        .custom-language-item {
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .custom-language-item img {
            width: 24px;
            height: 16px;
            margin-right: 10px;
        }

        .custom-language-selected {
            background-color: #e0f7fa;
            font-weight: bold;
        }

        .custom-selected-language-btn {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .custom-selected-language-btn img {
            width: 24px;
            height: 16px;
        }

        .dropdown-item,
        .dropdown-item:hover {
            padding: 1px 0px !important;
            background: #fff !important;
        }

        .popup-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            max-width: 500px;
            z-index: 9999;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 15px;
            transition: all 0.3s ease;
        }

        .popup-content {
            position: relative;
        }

        .close-popup {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 24px;
            height: 24px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .close-popup:hover {
            background: #f1f1f1;
        }

        #popupImageLink {
            display: block;
            pointer-events: none;
            /* Disabled initially */
        }

        #popupImageLink.active {
            pointer-events: auto;
            /* Enabled after cancel */
        }
    </style>
</head>

<body data-logged-in="{{ auth()->check() ? 1 : 0 }}">
    <!-- header section start here -->
    @include('external-user.inc-parts.header')
    <!-- header section end here -->

    {{-- main content --}}
    @yield('external-main-content')

    <div class="card shadow border-top-0 rounded-0 py-4 mb-4"></div>
    <!-- Right corner popup -->
    @php
    $segment = request()->segment(1);
    @endphp
    @if ( $segment == 'member-packages')
    <div id="loginPopup" class="popup-container" style="display: none;">
        <div class="popup-content">
            <span class="close-popup">&times;</span>
            <a href="#" id="popupImageLink">
                <img src="{{ asset('offer.png') }}" alt="Promotional Content" class="img-fluid">
            </a>
        </div>
    </div>
    @endif
    {{-- footer here --}}
    @include('external-user.inc-parts.footer')

    <!-- jquery cdn here -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- bootstrap 5 cdn here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- mega hover menu plugin here -->
    <script src="{{ asset('world-business/assets/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('world-business/assets/plugins/js/main.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.3.2/build/js/intlTelInput.js"></script>
    <!-- custome scripts -->
    <script src="https://vjs.zencdn.net/7.15.4/video.js"></script>
    <script src="{{ asset('world-business/assets/script/home-slider.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Check if user is logged in (Laravel)
            const isLoggedIn = document.body?.dataset?.loggedIn === '1';
            if (!isLoggedIn) {
                // Show popup if not logged in
                $('#loginPopup').fadeIn();

                // Close popup handler
                $('.close-popup').click(function() {
                    $('#loginPopup').fadeOut();
                    // Enable image click after closing
                    $('#popupImageLink').addClass('active');

                    // Optional: Set a cookie to not show again for X days
                    document.cookie = "popupClosed=true; max-age=86400; path=/"; // 1 day
                });

                // Optional: Check if popup was previously closed
                if (document.cookie.split(';').some((item) => item.trim().startsWith('popupClosed='))) {
                    $('#loginPopup').hide();
                    $('#popupImageLink').addClass('active');
                }
            }

            // Handle image click
            $('#popupImageLink').click(function(e) {
                e.preventDefault();
                console.log('Image was clicked!');

            });
        });
    </script>
    @include('seller-vendor.inc-part.cookie')
    @yield('custom-js-external')
</body>

</html>