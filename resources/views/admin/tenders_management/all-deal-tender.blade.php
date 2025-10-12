@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                         All Tender Deals
                    </div>
                    <div class="card-body pb-0">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                         
                                        <th>Company Name</th>
                                        <th>Tender  Title </th>
                                        <th>Quantity </th> 
                                        <th>Sold on</th>
                                        <th>Selling Price</th>
                                         <th>Status </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tenders as $index => $tender)
                                        <tr>
                                            <td>{{ $tenders->firstItem() + $index }}</td>
                                              <td>{{getUserCompany($tender->vendor->id) ?? 'N/A' }}</td>
                                            <td>{{ $tender->name ?? 'N/A' }}</td>
                                            <td>{{ $tender->quantity ?? 'N/A' }}</td>
                                           
                                            <td>{{ $tender->created_at->format('d M Y') }}</td>
                                            <td>
                                                
                                             {{ $tender->price ?? 'N/A' }} 
                                            </td>

                                            <td>
                                                <label title="Active/Inactive" class="switch round_switch">
                                                    <input @checked($tender->status) type="checkbox"
                                                        id="checkbox{{ $tender->id }}">
                                                    <div class="slider round"></div>
                                                </label>    
                                                </td>
                                            <td>
                                                <a href="{{ route('admin.tenders.show', $tender->id) }}" 
                                                   class="btn btn-sm btn-secondary m-1" title="View">
                                                   <i class="fas fa-eye"></i>
                                                </a>
                                                <!-- <a href="{{ route('admin.tenders.edit', $tender->id) }}" 
                                                   class="btn btn-sm btn-success m-1" title="Edit">
                                                   <i class="fas fa-edit"></i> -->
                                                </a>
                                                <form action="{{ route('admin.tenders.destroy', $tender->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger m-1" 
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="mt-2">
                               <div class="d-flex justify-content-center">
                        {{ $tenders->links('pagination::bootstrap-5') }}
                    </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
<script>
     
</script>
@endsection
