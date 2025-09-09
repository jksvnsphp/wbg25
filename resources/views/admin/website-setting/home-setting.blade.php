@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Home Page Banner
                    </div>
                    <style>
                        .table_banner table img {
                            height: 6rem !important;
                        }
                    </style>
                    <div class="card-body pb-0">
                        <div class="table_banner">
                            <small style="color:#F00">Banner Image Size:1500x300px</small>
                            <form action="{{ route('admin.update.home.banner') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <table class="table table-striped table-bordered table-responsive" cellpadding="0"
                                    cellspacing="0" width="100%">

                                    <tbody>
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Banner
                                                    First</strong>
                                            </td>
                                            <td class="last" width="50%">
                                                <input type="file" class="form-control" name="banner1" id="banner1"
                                                    accept="image/*">
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"></td>
                                            <td class="last" width="50%">
                                                <img src="
                                                @if ($banner->banner1 != '') {{ asset('uploads/home_banners/' . $banner->banner1) }}
                                                @else
                                                {{ asset('dashboard/img/banner/1628148674.jpg') }} @endif"
                                                    id="viewbanner1" class="img-responsive ">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Banner First
                                                    text</strong></td>
                                            <td class="last" width="50%">
                                                <input type="text" class="form-control" name="banner1_text"
                                                    value="{{ $banner->banner1_text }}">
                                                @error('banner1_text')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Banner First
                                                    link</strong></td>
                                            <td class="last" width="50%">
                                                <input type="url" class="form-control" name="banner1_link"
                                                    value="{{ $banner->banner1_link }}">
                                                @error('banner1_link')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td colspan="3">&nbsp;</td>
                                        </tr>

                                        {{-- second banner --}}
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Banner
                                                    Second</strong>
                                            </td>
                                            <td class="last" width="50%">
                                                <input type="file" accept="image/*" id="banner2" class="form-control"
                                                    name="banner2">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"></td>
                                            <td class="last" width="50%">
                                                <img src="@if ($banner->banner2 != '') {{ asset('uploads/home_banners/' . $banner->banner2) }}
                                                @else
                                                {{ asset('dashboard/img/banner/1628148674.jpg') }} @endif"
                                                    id="viewbanner2" class="img-responsive  ">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Banner Second
                                                    Text</strong></td>
                                            <td class="last" width="50%">
                                                <input type="text" class="form-control" name="banner2_text"
                                                    value="{{ $banner->banner2_text }}">
                                                @error('banner2_text')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Banner second
                                                    link</strong></td>
                                            <td class="last" width="50%">
                                                <input type="url" class="form-control" name="banner2_link"
                                                    value="{{ $banner->banner2_link }}">
                                                @error('banner2_link')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td colspan="3">&nbsp;</td>
                                        </tr>

                                        {{-- third banner --}}
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Banner
                                                    Third</strong>
                                            </td>
                                            <td class="last" width="50%">
                                                <input type="file" accept="image/*" id="banner3"
                                                    class="form-control" name="banner3">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"></td>
                                            <td class="last" width="50%">
                                                <img src="@if ($banner->banner3 != '') {{ asset('uploads/home_banners/' . $banner->banner3) }}
                                                @else
                                                {{ asset('dashboard/img/banner/1628148674.jpg') }} @endif"
                                                    id="viewbanner3" class="img-responsive  ">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Banner Third
                                                    Text</strong></td>
                                            <td class="last" width="50%">
                                                <input type="text" class="form-control" name="banner3_text"
                                                    value="{{ $banner->banner3_text }}">
                                                @error('banner3_text')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Banner Third
                                                    Link</strong></td>
                                            <td class="last" width="50%">
                                                <input type="text" class="form-control" name="banner3_link"
                                                    value="{{ $banner->banner3_link }}">
                                                @error('banner3_link')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td colspan="3">&nbsp;</td>
                                        </tr>

                                        {{-- fourth banner --}}
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Banner
                                                    Forth</strong>
                                            </td>
                                            <td class="last" width="50%">
                                                <input type="file" accept="image/*" class="form-control"
                                                    id="banner4" name="banner4">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"></td>
                                            <td class="last" width="50%">
                                                <img src="@if ($banner->banner4 != '') {{ asset('uploads/home_banners/' . $banner->banner4) }}
                                                @else
                                                {{ asset('dashboard/img/banner/1628148674.jpg') }} @endif"
                                                    id="viewbanner4" class="img-responsive  ">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Banner Forth
                                                    text</strong></td>
                                            <td class="last" width="50%">
                                                <input type="text" class="form-control" name="banner4_text"
                                                    value="{{ $banner->banner4_text }}">
                                                @error('banner4_text')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Banner Forth
                                                    link</strong></td>
                                            <td class="last" width="50%">
                                                <input type="text" class="form-control" name="banner4_link"
                                                    value="{{ $banner->banner4_link }}">
                                                @error('banner4_link')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td colspan="3">&nbsp;</td>
                                        </tr>

                                        {{-- fiveth banner --}}
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Banner
                                                    Fiveth</strong></td>
                                            <td class="last" width="50%">
                                                <input type="file" class="form-control" accept="image/*"
                                                    name="banner5" id="banner5">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"></td>
                                            <td class="last" width="50%">
                                                <img src="@if ($banner->banner5 != '') {{ asset('uploads/home_banners/' . $banner->banner5) }}
                                                @else
                                                {{ asset('dashboard/img/banner/1628148674.jpg') }} @endif"
                                                    id="viewbanner5" class="img-responsive  ">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Banner Fiveth
                                                    text</strong></td>
                                            <td class="last" width="50%">
                                                <input type="text" class="form-control" name="banner5_text"
                                                    value="{{ $banner->banner5_text }}">
                                                @error('banner5_text')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Banner Fiveth
                                                    link</strong></td>
                                            <td class="last" width="50%">
                                                <input type="text" class="form-control" name="banner5_link"
                                                    value="{{ $banner->banner5_link }}">
                                                @error('banner5_link')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td colspan="3">&nbsp;</td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"></td>
                                            <td class="last" width="50%">
                                                <button class="btn btn-primary set-btn" type="submit">Save
                                                    Changes</button>
                                            </td>
                                            <td></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card rounded-0 mt-5">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Home Top Categoery
                    </div>
                    <style>
                        .table_category table img {
                            height: 100% !important;
                            width: 100% !important;
                        }
                    </style>
                    <div class="card-body pb-0">
                        <div class="table_category">

                            <small style="color:#F00">Image Size: 590x360PX</small>
                            <form action="{{route('admin.update.home.category.banner')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <table class="table table-striped table-bordered table-responsive table-responsive"
                                    cellpadding="0" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Image</strong>
                                            </td>
                                            <td class="last" width="50%">
                                                <input type="file" class="form-control" accept="image/*"
                                                    name="image" id="banner6">
                                                @error('image')
                                                    <small style="color:#F00">{{ $message }}</small>
                                                @enderror
                                                
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"></td>
                                            <td class="last" width="50%">
                                                <img src="
                                                @if ($infos[0]->image != '') {{ asset('uploads/home_banners/' . $infos[0]->image) }}
                                                    @else
                                                    {{ asset('dashboard/img/banner/1588026484.jpg') }} @endif
                                                "
                                                    id="viewbanner6" class="img-responsive ">
                                            </td>
                                            <td></td>
                                        </tr>

                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Title</strong>
                                            </td>
                                            <td class="last" width="50%">
                                                <input type="text" class="form-control" name="title"
                                                    value="{{$infos[0]->title}}">
                                                @error('title')
                                                    <small style="color:#F00">{{ $message }}</small>
                                                @enderror
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Sub Title</strong>
                                            </td>
                                            <td class="last" width="50%">
                                                <input type="text" class="form-control" name="sub_title"
                                                    value="{{$infos[0]->sub_title}}">
                                                @error('sub_title')
                                                    <small style="color:#F00">{{ $message }}</small>
                                                @enderror
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">
                                                    Detail</strong>
                                            </td>
                                            <td class="last" width="50%">
                                                <textarea name="detail" rows="8" class="form-control" id="editor">{{$infos[0]->content}}</textarea>
                                                @error('detail')
                                                    <small style="color:#F00">{{ $message }}</small>
                                                @enderror
                                            </td>
                                            <td width="300">

                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg">
                                            <td></td>
                                            <td colspan="2">
                                                <button class="btn btn-primary " type="submit">Save Changes</button>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card rounded-0 mt-5">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        RFQ & Featured Brands Panel
                    </div>
                    <style>
                        .table_rfq table td {
                            font-size: 15px !important;
                        }
                    </style>
                    <div class="card-body pb-0">
                        <div class="table_rfq">

                            <table class="table table-striped  table-bordered table-responsive" cellpadding="0"
                                cellspacing="0" border="0" width="100%">
                                <tbody>
                                    <tr>
                                        <th class="first" width="8%"><span class="manten-th">Sr.No.</span></th>
                                        <th><span class="manten-th">Title</span></th>
                                        <th><span class="manten-th">Sub Title</span></th>
                                        <th><span class="manten-th">Content</span></th>
                                        <th><span class="manten-th">Icon</span></th>
                                        <th class="last"><span class="manten-th">Action</span></th>
                                    </tr>
                                    <tr>
                                        <td class="first style3">1</td>
                                        <td>{!! $infos[1]->title !!}</td>
                                        <td>{!! $infos[1]->sub_title !!}</td>
                                        <td>
                                            {!! Str::limit($infos[1]->content,150) !!}
                                        </td>
                                        <td>
                                            <img src="{{asset('uploads/home_banners/'.$infos[1]->image)}}" width="50" height="50">
                                        </td>
                                        <td class="last">
                                            <a href="{{route('admin.edit.home.info',$infos[1]->id)}}" class="btn btn-info btn-sm" title="Edit">
                                                <i class="fa fa-edit"></i>
                                               
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first style3">2</td>
                                        <td>{!! $infos[2]->title !!}</td>
                                        <td>{!! $infos[2]->sub_title !!}</td>
                                        <td>
                                            {!! Str::limit($infos[2]->content,150) !!}
                                        </td>
                                        <td>
                                            <img src="{{asset('uploads/home_banners/'.$infos[2]->image)}}" width="50" height="50">
                                        </td>
                                        <td class="last">
                                            <a href="{{route('admin.edit.home.info',$infos[2]->id)}}" class="btn btn-info btn-sm" title="Edit">
                                                <i class="fa fa-edit"></i>
                                               
                                        </td>
                                    </tr>
                                    

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
@section('custom-js')
    <script>
        // Function to handle file input change and show image preview
        function handleFileSelect(event) {
            const input = event.target;
            const inputId = input.id; // e.g., "banner1"
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewId = '#view' + inputId;
                    const img = document.querySelector(previewId);
                    // console.log(img);
                    img.src = e.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }

        // Attach the event listener to all file inputs
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', handleFileSelect);
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#editor').trumbowyg();;

        })
    </script>
@endsection
