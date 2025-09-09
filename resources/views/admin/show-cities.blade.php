@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <!-- Page Heading -->
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card rounded-0">
                <div class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                    All City
                    <button type="button" onclick="toggleAddCategory()" class="btn btn-secondary">Enter New City</button>
                </div>
                <div class="card-body pb-0">
                    <div class="card my-4 rounded-0 {{ old('isok') ? 'd-block' : 'd-none' }}" id="category_card">
                        <div class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                            Enter New City
                        </div>
                        <form method="post" action="{{route('admin.add.city')}}" enctype="multipart/form-data" class="card-body pb-0">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <input type="text" name="city_name" id="city_name" value="{{old('city_name')}}" class="form-control" placeholder="Enter the city name">
                                    <input type="hidden" name="isok" value="{{ old('isok') ? 1 : 1 }}">
                                    <input type="hidden" name="country_id" value="{{ $country_id }}">
                                    <input type="hidden" name="state_id" value="{{ $state_id }}">
                                    @error('city_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>


                                <div class="col-md-4 form-group">
                                    <input type="file" name="image" id="image">
                                    <small class="d-block">City Image</small>
                                    @error('image')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-4 px-3">
                                    <button type="submit" class="btn btn-sm btn-primary">Add City</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <style>
                        td {
                            padding: 4px !important;
                            font-size: 14px !important;
                        }

                        td p {
                            font-size: 14px !important;
                            padding: 0px !important;
                            margin: 0px !important;
                        }

                        td a {
                            font-weight: 700 !important;
                        }
                    </style>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped " id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Country</th>
                                    <th>Banner</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cities as $key=> $city)
                                    
                                <tr>
                                    <td class="align-middle">{{$key+1}}</td>
                                    <td class="align-middle">
                                        {{$city->state->country->name}}
                                    </td>

                                    <td class="align-middle">
                                        @if ($city->image!='')
                                            
                                        <img src="{{asset('uploads/city_banners/'.$city->image)}}" style="height: 3rem;" alt="">
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        {{$city->state->name}}
                                    </td>
                                    <td class="align-middle">
                                        {{$city->name}}
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{route('admin.edit.city',$city->id)}}" class="btn btn-sm btn-info"><i class="fas fa-edit    "></i></a>
                                        <a id="delete" href="{{route('admin.delete.city',$city->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-trash    "></i></a>
                                    </td>

                                </tr>
                                @endforeach
                                
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
        function toggleAddCategory() {
            $('#category_card').toggleClass('d-none');
        }
    </script>
@endsection
