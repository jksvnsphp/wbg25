@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card rounded-0">
                <div class="card-header bg-dark text-light font-weight-bolder">
                    Buyer Inquiry`s Deatails
                </div>
                <div class="card-body pb-0">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Buyer Name</th>
                                    <th>Buyer Email</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>{{ $inquiry->sender->name ?? $inquiry->name }}</td>
                                    <td>{{ $inquiry->sender->email ?? 'N/A' }}</td>
                                    <td>{{ $inquiry->subject }}</td>
                                    <td>{{ $inquiry->message }}</td>
                                    <td>{{ $inquiry->created_at->format('Y-m-d') }}</td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
