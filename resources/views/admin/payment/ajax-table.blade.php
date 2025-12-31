<table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Amount</th>
                                        <th>Package Type</th>
                                        <th>Payment Status</th>
                                        <th>Transaction Date</th>
                                        <th>Payment Method</th>
                                        <th>Payment Id</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

<tbody>
@foreach($records as $key => $row)
<tr>
    <td>{{ $records->firstItem() + $key }}</td>
    <td>{{ $row->user->first_name }} {{ $row->user->last_name }}</td>
    <td>{{ $row->user->email }}</td>
    <td>${{ number_format($row->price, 2) }}</td>
    <td>{{ $row->package->name ?? 'N/A' }}</td>
    <td>{{ $row->payment_status == 'paid' ? 'Complete' : 'Pending' }}</td>
    <td>{{ $row->created_at->format('d M Y') }}</td>
    <td>{{ ucfirst($row->payment_method ?? 'paypal') }}</td>
    <td>{{ $row->payment_id }}</td>

    <td>
        <!--<label class="switch">
            <input type="checkbox" class="toggleStatus" data-id="{{ $row->id }}" {{ $row->status ? 'checked' : '' }}>
            <span class="slider round"></span>
        </label>-->

        <a href="javascript:void(0)"  class="btn btn-danger btn-sm deletePayment" data-id="{{ $row->id }}">
            <i class="fa fa-trash"></i>
        </a>
    </td>
</tr>
@endforeach
</tbody>

<tfoot>
<tr>
    <td colspan="10">
        {!! $records->links() !!}
    </td>
</tr>
</tfoot>
</table>
<script>
$(document).on('click', '.deletePayment', function() {
    var id = $(this).data('id');
    if(confirm('Are you sure to delete this payment?')) {
        // Replace placeholder in route with actual ID
        var url = "{{ route('admin.payment.center.delete', ['id' => ':id']) }}";
        url = url.replace(':id', id);

        $.ajax({
            url: url,
            type: 'DELETE',
            data: {_token: '{{ csrf_token() }}'},
            success: function(res) {
                alert(res.message);
                loadPaymentData(); // reload table
            },
            error: function(err) {
                console.error(err);
                alert('Something went wrong. Please try again.');
            }
        });
    }
});

</script>