@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>Company Certificates</h4>
        <!-- <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary">+ Add Certificate</a> -->
    </div>

    <table class="table table-bordered" id="dataTable">
        <thead class="bg-dark text-light">
            <tr>
                <th>#</th>
                <th>Company Name</th>
                <th>Image1</th>
                <th>Image2</th>
                <th>Image3</th>
                <th>Image4</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($certificates as $vendor_id => $certGroup)

            @php
            $first = $certGroup->first(); // one certificate row for that vendor
            $companyName = $first->user?->company?->name ?? 'N/A';

            $image1 = $certGroup[0]->image ?? '';
            $image2 = $certGroup[1]->image ?? '';
            $image3 = $certGroup[2]->image ?? '';
            $image4 = $certGroup[3]->image ?? '';
            @endphp

            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $companyName }}</td>

                <td><img src="{{ asset('uploads/certificates/' . $image1) }}" width="100"></td>
                <td>
                    @if($image2)
                    <img src="{{ asset('uploads/certificates/' . $image2) }}" width="100">
                    @endif
                </td>
                <td>
                    @if($image3)
                    <img src="{{ asset('uploads/certificates/' . $image3) }}" width="100">
                    @endif
                </td>
                <td>
                    @if($image4)
                    <img src="{{ asset('uploads/certificates/' . $image4) }}" width="100">
                    @endif
                </td>

                <td>
                    <form action="{{ route('admin.certificates.destroy', $first->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>

            @empty
            <tr>
                <td colspan="7" class="text-center">No certificates found.</td>
            </tr>
            @endforelse

        </tbody>
    </table>





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
            var id = $(this).attr('id').replace('id', '');
            $.ajax({
                type: 'POST',
                url: '{{ route("admin.status.tender.category") }}',
                data: {
                    id: id,
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