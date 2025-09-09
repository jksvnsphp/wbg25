@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
               
                <div class="card rounded-0 mt-5">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                       Edit Home Info
                    </div>
                    <style>
                        .table_category table img {
                            height: 100% !important;
                            width: 100% !important;
                        }
                    </style>
                    <div class="card-body pb-0">
                        <div class="table_category">

                            {{-- <small style="color:#F00">Image Size: 590x360PX</small> --}}
                            <form action="{{route('admin.update.home.info')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <table class="table table-striped table-bordered table-responsive table-responsive"
                                    cellpadding="0" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Image</strong>
                                            </td>
                                            <td class="last" width="50%">
                                                <input type="file" class="form-control" accept="image/*"
                                                    name="image" id="banner1">
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
                                                @if ($info->image != '') {{ asset('uploads/home_banners/' . $info->image) }}
                                                    @else
                                                    {{ asset('dashboard/img/banner/1588026484.jpg') }} @endif
                                                "
                                                    id="viewbanner1" class="img-responsive ">
                                            </td>
                                            <td></td>
                                        </tr>

                                        <tr class="bg">
                                            <td class="first" width="30%"><strong class="manten-th">Title</strong>
                                            </td>
                                            <td class="last" width="50%">
                                                <textarea type="text" id="title" class="form-control" name="title"
                                                    >{{$info->title}}</textarea>
                                                    <input type="hidden" name="id" value="{{$info->id}}">
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
                                                <textarea type="text" id="sub_title" class="form-control" name="sub_title"
                                                    >{{$info->sub_title}}</textarea>
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
                                                <textarea name="detail" rows="8" class="form-control" id="editor">{{$info->content}}</textarea>
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
            $('#title').trumbowyg();;
            $('#sub_title').trumbowyg();;

        })
    </script>
@endsection
