@extends('seller-vendor.seller-frame')
@section('seller-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <div class="d-flex flex-wrap">
                    <h6 class="my-0 pb-4 fs-5 pt-2 me-5">My Shipment Methods</h6>
                    <div class="my-2 d-flex ">
                        <div class="input-check me-3">
                            <input onchange="statusShipment(event)" @checked(isset($seller->company->isShipmentMethod) && $seller->company->isShipmentMethod == 1) type="radio" id="active"
                                name="status" value="1" class="form-check-input" />
                            <label for="active">Active</label>
                        </div>
                        <div class="input-check">
                            <input onchange="statusShipment(event)" @checked(isset($seller->company->isShipmentMethod) && $seller->company->isShipmentMethod == 0) type="radio"
                                id="inactive" name="status" value="0" class="form-check-input" />
                            <label for="inactive">Inactive</label>
                        </div>
                    </div>
                </div>

                <div class="tab-content shadow" id="pills-tabContent">
                    <div class="card rounded-0">
                        <div class="row">
                            <div class="col-xl-8">

                                <h6 class="fs-6 fw-bold mb-0 p-2 pb-0 pt-3">
                                    Shipment Methods
                                </h6>
                                <hr />
                                <div class="table-responsive m-2">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td style="width: 45%; font-weight: 600">
                                                    Express Delivery Through
                                                </td>
                                                <td style="width: 55%">DHL / UPS</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 45%; font-weight: 600">
                                                    Package Shipping Through
                                                </td>
                                                <td style="width: 55%">DHL / UPS</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 45%; font-weight: 600">
                                                    Pallet Shipping Through
                                                </td>
                                                <td style="width: 55%">UPS / Shiply.com</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 45%; font-weight: 600">
                                                    Insured Shipping
                                                </td>
                                                <td style="width: 55%">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="insured_shipping" @checked(isset($seller->company->insured_shipping) && $seller->company->insured_shipping == 1) />
                                                        <label class="form-check-label" for="insured_shipping">Yes /
                                                            No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <h6 class="fs-6 fw-bold mb-0 p-2 pb-0 pt-3">
                                    Shipping Processing Time
                                </h6>
                                <hr />
                                <div class="table-responsive m-2">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td style="width: 45%; font-weight: 600">
                                                    Express Delivery
                                                </td>
                                                <td style="width: 55%">
                                                    <div class="form-group">
                                                        <select name="express_delivery" id="express_delivery"
                                                            class="form-select">
                                                            <option value="">Please select</option>
                                                            <option value="1" @selected(isset($seller->company->express_delivery) && $seller->company->express_delivery == 1)>1 Day
                                                            </option>
                                                            <option value="2" @selected(isset($seller->company->express_delivery) && $seller->company->express_delivery == 2)>2 Days
                                                            </option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 45%; font-weight: 600">
                                                    Package Shipping
                                                </td>
                                                <td style="width: 55%">
                                                    <div class="form-group">
                                                        <select name="package_shipping" id="package_shipping"
                                                            class="form-select">
                                                            <option value="">Please select</option>
                                                            <option value="1" @selected(isset($seller->company->package_shipping) && $seller->company->package_shipping == 1)>1 Day
                                                            </option>
                                                            <option value="2" @selected(isset($seller->company->package_shipping) && $seller->company->package_shipping == 2)>2 Days
                                                            </option>
                                                            <option value="3" @selected(isset($seller->company->package_shipping) && $seller->company->package_shipping == 3)>3 Days
                                                            </option>
                                                            <option value="4" @selected(isset($seller->company->package_shipping) && $seller->company->package_shipping == 4)>4 Days
                                                            </option>
                                                            <option value="5" @selected(isset($seller->company->package_shipping) && $seller->company->package_shipping == 5)>5 Days
                                                            </option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 45%; font-weight: 600">
                                                    Pallet Shipping
                                                </td>
                                                <td style="width: 55%">
                                                    <div class="form-group">
                                                        <select name="pallet_shipping" id="pallet_shipping"
                                                            class="form-select">
                                                            <option value="">Please select</option>
                                                            <option value="1" @selected(isset($seller->company->pallet_shipping) && $seller->company->pallet_shipping == 1)>1 Day
                                                            </option>
                                                            <option value="2" @selected(isset($seller->company->pallet_shipping) && $seller->company->pallet_shipping == 2)>2 Days
                                                            </option>
                                                            <option value="3" @selected(isset($seller->company->pallet_shipping) && $seller->company->pallet_shipping == 3)>3 Days
                                                            </option>
                                                            <option value="4" @selected(isset($seller->company->pallet_shipping) && $seller->company->pallet_shipping == 4)>4 Days
                                                            </option>
                                                            <option value="5" @selected(isset($seller->company->pallet_shipping) && $seller->company->pallet_shipping == 5)>5 Days
                                                            </option>
                                                            <option value="6" @selected(isset($seller->company->pallet_shipping) && $seller->company->pallet_shipping == 6)>6 Days
                                                            </option>
                                                            <option value="7" @selected(isset($seller->company->pallet_shipping) && $seller->company->pallet_shipping == 7)>1 Week
                                                            </option>
                                                            <option value="14" @selected(isset($seller->company->pallet_shipping) && $seller->company->pallet_shipping == 14)>2 Weeks
                                                            </option>
                                                            <option value="21" @selected(isset($seller->company->pallet_shipping) && $seller->company->pallet_shipping == 21)>3 Weeks
                                                            </option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 45%; font-weight: 600">
                                                    Shipping Notification with tracking number
                                                </td>
                                                <td style="width: 55%">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="shipping_notify" @checked(isset($seller->company->shipping_notify) && $seller->company->shipping_notify == 1)
                                                            name="shipping_notify" />
                                                        <label class="form-check-label" for="shipping_notify">Yes /
                                                            No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>



                                <h6 class="fs-6 fw-bold mb-0 p-2 pb-0 pt-3">Export Region</h6>
                                <hr />
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive m-2">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    @foreach (['World Wide', 'Africa', 'North Africa', 'Middle East', 'Asia', 'Australia', 'Oceania'] as $region)
                                                        <tr>
                                                            <td style="width: 45%; font-weight: 600">{{ $region }}
                                                            </td>
                                                            <td style="width: 55%">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input isRegion"
                                                                        type="checkbox" role="switch"
                                                                        id="is_{{ str_replace(' ', '', $region) }}"
                                                                        @if (isset($seller->exports->{'is' . str_replace(' ', '', $region)}) &&
                                                                                $seller->exports->{'is' . str_replace(' ', '', $region)} == 1) checked @endif />
                                                                    <label class="form-check-label"
                                                                        for="is_{{ Str::snake($region) }}">Yes /
                                                                        No</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="table-responsive m-2">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    @foreach (['European Union', 'Rest European', 'Russian Federation', 'North America', 'Central America', 'South America'] as $region)
                                                        <tr>
                                                            <td style="width: 45%; font-weight: 600">{{ $region }}
                                                            </td>
                                                            <td style="width: 55%">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input isRegion"
                                                                        type="checkbox" role="switch"
                                                                        id="is_{{ str_replace(' ', '', $region) }}"
                                                                        @if (isset($seller->exports->{'is' . str_replace(' ', '', $region)}) &&
                                                                                $seller->exports->{'is' . str_replace(' ', '', $region)} == 1) checked @endif />
                                                                    <label class="form-check-label"
                                                                        for="is_{{ Str::snake($region) }}">Yes /
                                                                        No</label>
                                                                </div>
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
        function sendData(name, value) {

            $.ajax({
                url: "{{ route('seller.edit.shipping-options') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name,
                    value: value
                },
                success: function(response) {
                    Swal.fire({
                        title: "Congratulation!",
                        text: "Your shipment methods has updated successfully",
                        icon: "success"
                    });
                },
                error: function(xhr) {
                    console.log('Error saving data');
                }
            });
        }
        $(document).ready(function() {
            function sendData(name, value) {

                $.ajax({
                    url: "{{ route('seller.edit.shipping-options') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: name,
                        value: value
                    },
                    success: function(response) {
                        Swal.fire({
                        title: "Congratulation!",
                        text: "Your shipment methods has updated successfully",
                        icon: "success"
                    });
                    },
                    error: function(xhr) {
                        console.log('Error saving data');
                    }
                });
            }

            $('#express_delivery').change(function() {
                sendData('express_delivery', $(this).val());
            });

            $('#package_shipping').change(function() {
                sendData('package_shipping', $(this).val());
            });

            $('#pallet_shipping').change(function() {
                sendData('pallet_shipping', $(this).val());
            });

            $('#shipping_notify').change(function() {
                sendData('shipping_notify', $(this).is(':checked') ? 1 : 0);
            });

            $('#insured_shipping').change(function() {
                sendData('insured_shipping', $(this).is(':checked') ? 1 : 0);
            });
        });

        function statusShipment(e) {
            var statusVal = e.target.value;
            sendData('isShipmentMethod', statusVal);
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.isRegion').on('change', function() {
                const region = $(this).attr('id').split('_')[1];
                const isChecked = $(this).is(':checked');

                $.ajax({
                    url: "{{ route('seller.edit.export-regions') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        region: region,
                        isChecked: isChecked
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                        title: "Congratulation!",
                        text: response.message,
                        icon: "success"
                    });
                           
                        } else {
                            toastr.error(response.message)
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
@endsection
