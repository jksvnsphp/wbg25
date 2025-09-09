@extends('seller-vendor.seller-frame')

@section('seller-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12  bg-primary py-2">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fs-5 text-light mb-0 py-2  px-3">My Posted News</h6>
                    <a href="{{ route('seller.add.news') }}" class="btn btn-secondary">+ Add News</a>
                </div>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered align-middle">

                                        <tbody>
                                            @foreach ($news as $newsData)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('read.news', $newsData->slug) }}" class="table-img d-block" style="height:4rem !important; width:4rem !important;">
                                                            <img src="{{ asset('uploads/news/' . $newsData->image) }}"
                                                                style="height: 100%; width: 100%" alt="" />
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <p>{{ $newsData->title }}</p>
                                                    </td>
                                                    <td>
                                                        <h6 class="text-center">
                                                            Posted: {{ date('d M, Y', strtotime($newsData->created_at)) }}
                                                        </h6>
                                                        <h6 class="text-center">
                                                            CET: {{ date('h:i A', strtotime($newsData->created_at)) }}
                                                        </h6>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-switch" title="Publish">
                                                            <input class="form-check-input toggle-publish" type="checkbox"
                                                                id="flexSwitchCheckChecked" data-id="{{ $newsData->id }}"
                                                                data-name="isPublish"
                                                                {{ $newsData->isPublish ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('seller.edit.news',$newsData->slug) }}" class="btn btn-info me-2"><i
                                                                class="fa fs-5 text-white fa-pencil-square"
                                                                aria-hidden="true"></i></a>
                                                        <a href="javascript:void(0);" title="Delete"
                                                            class="btn btn-primary me-2 delete-news"
                                                            data-news-id="{{ $newsData->id }}">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
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
                <div class="mt-3">
                    <button type="button" onclick="window.history.back()" class="btn text-light"><i
                            class="fas fa-arrow-left "></i> Back</button>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('seller-custome-js')
    <script>
        $(document).ready(function() {
            $('.toggle-publish').on('change', function() {

                let checkbox = $(this);
                let newsId = checkbox.data('id');
                let newStatus = checkbox.is(':checked') ? 1 : 0;

                // AJAX request
                $.ajax({
                    url: '{{ route('seller.status.news') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: newsId,
                        status: newStatus
                    },
                    success: function(response) {
                        // Handle success response
                        if (response.success) {
                            toastr.success('Status updated successfully');
                        } else {
                            toastr.error('Failed to update status');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('An error occurred while updating the status');
                        checkbox.prop('checked', !newStatus);
                    }
                });
            });
        });

        $(document).ready(function() {
            $('.delete-news').on('click', function(e) {
                e.preventDefault();

                let newsId = $(this).data('news-id');

                if (confirm("Are you sure you want to delete this news?")) {
                    $.ajax({
                        url: '{{ route('seller.delete.news') }}', 
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', 
                            id: newsId
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $(`a[data-news-id="${newsId}"]`).closest('tr').remove();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            toastr.error('An error occurred. Please try again.');
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
@endsection
