@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>All listed FRQ`s</h4>
  
    </div>

    <table class="table table-bordered" id="dataTable">
        <thead class="bg-dark text-light">
            <tr>
                <th>#</th>
                <th>Company Name</th>
                <th>RFQ Title</th>
                <th>Quantity</th>
                <th>Entry Date</th>
                <th>Duration Left Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($quotations as $quotation)
                <tr>
                    <td>
                       @php 
                    //   echo "<pre>";    
                      // print_r($quotation->toArray()); die;
                          $user = \App\Models\User::find($quotation->user_id);
                       @endphp
                        {{ $loop->iteration }}</td>
                    <td>
                    
                    {{ $quotation?->product_service }}  </td>
                     <td>
                    
                    {{ $user?->company?->name }}  </td>
                    <td>
                      {{ $quotation->quantity ?? 'N/A' }}      
                    </td>
                    <td>
                          
                        {{ $quotation->created_at->format('d M Y') }}   
                     
                    </td>
                      <td>
                       

                          @if($quotation->duration)
                                                    @php
                                                        $entryDate = \Carbon\Carbon::parse($quotation->created_at);
                                                        $expiryDate = $entryDate->copy()->addDays($quotation->duration);
                                                        $now = \Carbon\Carbon::now();
                                                        $daysLeft = $now->diffInDays($expiryDate, false);
                                                    @endphp
                                                    @if($daysLeft >= 0)
                                                        {{ $expiryDate->format('d M Y') }} 
                                                    @else
                                                        Expired
                                                    @endif
                                                @else
                                                    N/A
                                                @endif  
                           
                     
                    </td> 
                   
                    <td>
                         <label title="Active/Inactive" class="switch round_switch">
                                                <input type="checkbox" id="id9" checked value="1">
                                                <div class="slider round"></div>
                                            </label>
                       
                        <form action ="#" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No certificates found.</td></tr>
            @endforelse
        </tbody>
    </table>

    
 <div class="d-flex justify-content-center">
                            {{ $quotations->links('pagination::bootstrap-5') }}
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
                var id = $(this).attr('id').replace('id', '');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.status.tender.category') }}',
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