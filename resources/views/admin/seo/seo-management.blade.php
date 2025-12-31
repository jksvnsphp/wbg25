@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="d-flex justify-content-between card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        SEO
                        <a href="{{route('admin.seo.add')}}" class="btn btn-sm btn-secondary">Add New</a>
                    </div>
                    <div class="card-body pb-0">
                        <style>
                            td{
                                padding: 4px !important;
                                font-size: 14px !important;
                            }
                            td p{
                                font-size: 14px !important;
                               padding: 0px !important;
                               margin: 0px !important;
                            }

                        </style>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped " id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Keywords</th>
                                        <th>Description</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>@foreach($seo as $index => $item)
<tr>
    <td class="align-middle">{{ $index + 1 }}</td>

    <td class="align-middle">
        {{ ucfirst($item->page) }}
    </td>

    <td class="align-middle">
        <p style="width: 12rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            {{ $item->title }}
        </p>
    </td>

    <td class="align-middle">
        <p style="width: 10rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            {{ $item->keywords }}
        </p>
    </td>

    <td class="align-middle">
        <p style="width: 10rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            {{ $item->description }}
        </p>
    </td>

    <td class="align-middle">
        <a href="{{ route('admin.seo.edit', $item->id) }}" class="btn m-1 btn-sm btn-info">
            <i class="fas fa-edit"></i>
        </a>
		<button class="btn btn-sm btn-danger deleteSeo" data-id="{{ $item->id }}">
                        Delete
                    </button>

        <a href="{{ route('admin.seo.view', $item->id) }}" class="btn m-1 btn-sm btn-secondary">
            <i class="fas fa-eye"></i>
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
    </div>
@endsection
@section('custom-js')
    
	<script>
$(document).on('click', '.deleteSeo', function(){
    let id = $(this).data('id');

    if(confirm('Are you sure to delete this?')) {
		const deleteBaseUrl = "{{ url('admin.seo.delete', '0') }}";
   const finalUrl = deleteBaseUrl.replace('0', id);
        $.ajax({
            url: "/admin/seo/delete/" + id,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(res){
                alert(res.message);
                location.reload();
            }
        });

    }
});
</script>
@endsection
