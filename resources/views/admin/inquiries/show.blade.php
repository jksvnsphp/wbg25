@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card rounded-0">
                <div class="card-header bg-dark text-light font-weight-bolder">
                    Subjet: {{ $inquiry->subject }}
                </div>
                <div class="card-body pb-0">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Sender Name</th>
                                    <th>Sender Email</th>
                                    <th>Receiver Name</th>
                                    <th>Receiver Email</th>
                                     
                                    <th>Message</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($messages as $index => $message)
                                    <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ getUserName($message->sender_id) ?? 'N/A' }}</td>
                                    <td>{{ getUserEmail($message->sender_id) ?? 'N/A' }}</td>
                                     <td>{{ getUserName($message->receiver_id) ?? 'N/A' }}</td>
                                    <td>{{ getUserEmail($message->receiver_id) ?? 'N/A' }}</td>
                                     
                                    <td>{{ $message->message }}</td>
                                    <td>{{ $message->created_at->format('Y-m-d') }}</td>
                                </tr>
                                 @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No Message found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
