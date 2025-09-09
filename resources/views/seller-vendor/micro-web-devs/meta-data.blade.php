@extends('seller-vendor.seller-frame')
@section('meta_data')
    <title>{{ $metaData->title ?? '' }}</title>
    <meta name="description" content="{{ $metaData->description ?? '' }}">
    <meta name="keywords" content="{{ $metaData->keywords ?? '' }}">
    <meta name="author" content="WBG24.com">
@endsection
@section('seller-main-content')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.min.css" />
    <style>
        .bootstrap-tagsinput {
            width: 100%;
            min-height: 38px;
            padding: 5px;
            border: 1px solid #ced4da;
            border-radius: 2px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            margin: 2px !important;
        }

        .bootstrap-tagsinput .tag {
            margin-right: 5px;
            color: white;
            background-color: #0a46b5e4;
            padding: 5px;
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
        }

        .bootstrap-tagsinput .tag [data-role="remove"] {
            margin-left: 5px;
            cursor: pointer;
            color: white;
        }
    </style>
    <div id="loadingOverlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999;">
        <div class="spinner-border text-light" role="status"
            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 3rem; height: 3rem;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 bg-primary py-3">
                <h6 class="fs-5 text-light py-3 px-3">Meta Datas</h6>
                <div class="card shadow rounded-0">
                    <div class="card-body">
                        <p>
                            The meta datas option can only be use with a gold and platinum
                            member package.
                        </p>
                        <p>
                            After you have entered and submit your meta datas. It will be
                            used for your spotlight store
                        </p>
                        <form method="post" action="{{ route('seller.update.meta-data') }}" class="row">
                            @csrf
                            <div class="col-md-7">
                                <div class="form-group d-flex mb-2 align-items-center">
                                    <label for="title" class="form-label me-4" style="white-space: nowrap">Meta Title:
                                    </label>
                                    <div class="w-100">
                                        <input type="text" name="title" id="title" class="form-control w-100"
                                            oninput="updateCharacterCount(this.value, 50,'title','charCount1')"
                                            value="{{ $metaData->title ?? '' }}" />
                                        @error('title')
                                            <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group d-flex mb-2 align-items-center">
                                    <label for="description" class="form-label me-4" style="white-space: nowrap">Meta
                                        Description:
                                    </label>
                                    <div class="w-100">
                                        <textarea type="text" name="description" id="description" class="form-control"
                                            oninput="updateCharacterCount2(this.value, 150,'description','charCount2')">{{ $metaData->description ?? '' }}</textarea>
                                        @error('description')
                                            <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group d-flex mb-2 align-items-center">
                                    <label for="keywords" class="form-label me-4" style="white-space: nowrap">Meta Keywords:
                                    </label>
                                    <div class="w-100">
                                        <small>(Max 8, comma separated)</small>
                                        <input type="text" name="keywords" id="keyword-input" class="form-control"
                                            data-role="tagsinput" placeholder="keyword1,Keyword2,..... Max 8"
                                            value="{{ $metaData->keywords ?? '' }}" />
                                        @error('keywords')
                                            <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 text-start">
                                <button type="submit" class="btn btn-secondary">Save & Publish</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" onclick="window.history.back()" class="btn text-light">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('seller-custome-js')
    <script>
        function updateCharacterCount(value, maxLength, inputId, countId) {
            var charCountElement = document.getElementById(countId);
            if (!charCountElement) {
                charCountElement = document.createElement("div");
                charCountElement.id = countId;
                charCountElement.className = "badge bg-success";
                var textarea = document.getElementById(inputId);
                textarea.parentNode.appendChild(charCountElement);
            }
            charCountElement.textContent = value.length + "/" + maxLength;

            if (value.length >= maxLength - 1) {
                document.getElementById(inputId).value = value.substring(
                    0,
                    maxLength - 1
                );
            }
        }

        function updateCharacterCount2(value, maxLength, inputId, countId) {
            var charCountElement = document.getElementById(countId);
            if (!charCountElement) {
                charCountElement = document.createElement("div");
                charCountElement.id = countId;
                charCountElement.className = "badge bg-success";
                var textarea = document.getElementById(inputId);
                textarea.parentNode.appendChild(charCountElement);
            }
            charCountElement.textContent = value.length + "/" + maxLength;

            if (value.length >= maxLength - 1) {
                document.getElementById(inputId).value = value.substring(
                    0,
                    maxLength - 1
                );
            }
        }

        var maxKeywords = 7;
    </script>
    <script>
        $(document).ready(function() {
            $('#keyword-input').tagsinput({
                maxTags: 8,
                trimValue: true,
                confirmKeys: [13, 44] // Enter and comma
            });

            $('#keyword-form').on('submit', function(e) {
                e.preventDefault();
                alert("Form submitted with keywords: " + $('#keyword-input').val());
            });
        });
    </script>
@endsection
