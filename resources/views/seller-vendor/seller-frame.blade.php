<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @yield('meta_data')
    <title>WBG</title>
    <!-- favicon here -->
    <link rel="shortcut icon" href="{{ asset('world-business/images/logos/logo.png') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
    <!-- bootstrap 5 css cdn here -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <!-- custome css file link here -->
    <link rel="stylesheet" href="{{ asset('world-business/assets/styles/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('world-business/richtexteditor/rte_theme_default.css') }}" />
    <script type="text/javascript" src="{{ asset('world-business/richtexteditor/rte.js') }}"></script>
    <!-- font awesome css cdn link here -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.3.2/build/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                    pageLanguage: "en",
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                },
                "google_translate_element"
            );
        }
    </script>

    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
        }


        body {
            top: 0 !important;
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
        .top-4{
            top:-4px !important;
        }
    </style>
</head>

<body>
    <!-- header section start here -->
    @include('seller-vendor.inc-part.header')
    <!-- header section end here -->

    <!-- information section -->
    @yield('seller-main-content')
    <div class="card shadow border-top-0 rounded-0 py-4 mb-4"></div>
    <!-- start of footer section -->
    @include('seller-vendor.inc-part.footer')


    <!-- jquery cdn here -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- bootstrap 5 cdn here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- mega hover menu plugin here -->
    <script src="{{ asset('world-business/assets/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('world-business/assets/plugins/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.3.2/build/js/intlTelInput.js"></script>
    <!-- custome scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.min.js"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    @include('seller-vendor.inc-part.cookie')
    @yield('seller-custome-js')
    <script>
        $(function() {
            $(document).on('click', '#delete', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = link;
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            })
        });
    </script>
</body>

</html>
