@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div
                        class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Enter country
                        <button type="button" onclick="toggleAddCategory()" class="btn btn-secondary">Enter New
                            Country</button>
                    </div>
                    <div class="card-body pb-0">
                        <div class="card my-4 rounded-0 {{ old('isok') ? 'd-block' : 'd-none' }}" id="category_card">
                            <div
                                class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                Enter New Country
                            </div>
                            <form method="post" action="{{ route('admin.add.country') }}" enctype="multipart/form-data"
                                class="card-body pb-0">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <input type="text" name="country_name" value="{{ old('country_name') }}"
                                            id="name" class="form-control" placeholder="Enter the country name">
                                        <input type="hidden" name="isok" value="{{ old('isok') ? 1 : 1 }}">
                                        @error('country_name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input type="text" name="capital" value="{{ old('capital') }}"
                                            class="form-control" id="capital" placeholder="Enter the capital of country.">
                                        @error('capital')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input type="text" name="currency_symbol" value="{{ old('currency_symbol') }}"
                                            class="form-control" id="currency_symbol"
                                            placeholder="Enter the currency symbol.">
                                        @error('currency_symbol')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input type="text" name="currency_name" value="{{ old('currency_name') }}"
                                            class="form-control" id="currency_name" placeholder="Enter the currency name.">
                                        @error('currency_name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input type="text" name="currency" value="{{ old('currency') }}"
                                            class="form-control" id="currency" placeholder="Enter the currency.">
                                        @error('currency')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input type="file" name="image" id="image">
                                        <small class="d-block">Flag Image</small>
                                        @error('image')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input type="file" name="country_image" id="country_image">
                                        <small class="d-block">Country Image</small>
                                        @error('country_image')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3 px-3">
                                        <button type="submit" class="btn btn-sm btn-primary">Add Country</button>
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
                            <table class="table table-bordered table-striped " id="dataTable" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Country</th>
                                        <th>Flag</th>
                                        <th>Currency</th>
                                        <th>States</th>

                                        <th>Action</th>
                                        <th>Available Home Search</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($countries as $key => $country)
                                        <tr>
                                            <td class="align-middle">{{ $key + 1 }}</td>
                                            <td class="align-middle">
                                                <a
                                                    href="{{ route('admin.all.states', $country->id) }}">{{ $country->name }}</a>
                                            </td>
                                            <td class="align-middle">
                                                @php
                                                 $oldImg=public_path('uploads/country_flags/' . $country->image);
                                                @endphp
                                                @if (file_exists($oldImg) && $country->image!='')
                                                    <img style="height:2rem !important; "
                                                        src="{{ asset('uploads/country_flags/' . $country->image) }}"
                                                        class="h-100" alt="">
                                                        @else
                                                    <img style="height:2rem !important;"
                                                        src="https://flagcdn.com/256x192/{{strtolower($country->iso2)}}.png"
                                                         alt="" >
                                                        
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                {{ $country->currency }} ({{ $country->currency_symbol }})
                                            </td>
                                            <td class="align-middle">
                                                <a
                                                    href="{{ route('admin.all.states', $country->id) }}">{{ $country->states_count }}</a>
                                            </td>

                                            <td class="align-middle">
                                                <a title="Edit" href="{{ route('admin.edit.country', $country->id) }}"
                                                    class="btn btn-sm btn-info"><i class="fas fa-edit    "></i></a>
                                                <a id="delete" title="Delete"
                                                    href="{{ route('admin.delete.country', $country->id) }}"
                                                    class="btn btn-sm btn-primary"><i class="fas fa-trash    "></i></a>
                                            </td>
                                            <td>
                                                <label title="Active/Inactive" class="switch round_switch">
                                                    <input @checked($country->status) type="checkbox"
                                                        id="checkbox{{ $country->id }}">
                                                    <div class="slider round"></div>
                                                </label>

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

    <script>
        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                var status = this.checked ? 1 : 0;
                var countryId = $(this).attr('id').replace('checkbox', '');
                $.ajax({
                    type: 'POST',
                    url: '{{route("admin.update.status.country")}}',
                    data: {
                        id: countryId,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        toastr.success('Status updated successfully');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating status');
                    }
                });
            });
        });
    </script>
@endsection
