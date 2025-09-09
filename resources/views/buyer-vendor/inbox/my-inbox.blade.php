@extends('buyer-vendor.buyer-frame')
@section('buyer-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <div class="row align-items-center mb-3">
                    <div class="col-md-1">
                        <h6 class="fs-6 text-light py-2 mt-2 px-3">Inbox</h6>
                    </div>
                    <form method="get" action="{{ route('inbox.show') }}" class="col-md-11">
                        <div class="row">
                            
                            <div class="col-md-3">
                                <select class="form-select" id="message-type" name="message-type">
                                    <option @selected(isset($_GET['message-type']) && $_GET['message-type']=="all") value="all">All View</option>
                                    <option @selected(isset($_GET['message-type']) && $_GET['message-type']=="contact") value="contact">By Contact</option>
                                    <option @selected(isset($_GET['message-type']) && $_GET['message-type']=="product") value="product">By Product</option>
                                    <option @selected(isset($_GET['message-type']) && $_GET['message-type']=="tender") value="tender">By Tender</option>
                                    <option @selected(isset($_GET['message-type']) && $_GET['message-type']=="quotation") value="quotation">By Quotation</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="format-type" name="format-type">
                                    <option @selected(isset($_GET['format-type']) && $_GET['format-type']=="all") value="all">All View</option>
                                    <option @selected(isset($_GET['format-type']) && $_GET['format-type']=="incoming") value="incoming">Incoming</option>
                                    <option @selected(isset($_GET['format-type']) && $_GET['format-type']=="outgoing") value="outgoing">Outgoing</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" value="{{ isset($_GET['date'])?$_GET['date']:'' }}" name="date" id="date">
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-secondary" type="submit">Filter</button>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>
                                            Sender and Receiver
                                        </th>
                                        <th>Message</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($allMessages))
                                        @foreach ($allMessages as $inbox_message)
                                            <tr @if ($inbox_message->receiver_id === auth()->user()->id && !$inbox_message->is_read) style="background-color: #f8d7da;" @endif>
                                                <td width="10%">
                                                    @if (isset($inbox_message->product->id))
                                                        @php
                                                            // Decode variants safely
                                                            $variants = is_string($inbox_message->product->variants)
                                                                ? json_decode($inbox_message->product->variants, true)
                                                                : $inbox_message->product->variants;
                                                            $variants = is_array($variants) ? $variants : [];
                                                            $allImages = [];
                                                            foreach ($variants as $variant) {
                                                                if (
                                                                    !empty($variant['images']) &&
                                                                    is_array($variant['images'])
                                                                ) {
                                                                    $allImages = array_merge(
                                                                        $allImages,
                                                                        $variant['images'],
                                                                    );
                                                                }
                                                            }
                                                            $previewImage = !empty($allImages)
                                                                ? asset('uploads/products/' . $allImages[0])
                                                                : null;
                                                            if (empty($previewImage)) {
                                                                $previewImage =
                                                                    isset($inbox_message->product->gallery[0]->image) &&
                                                                    !empty($inbox_message->product->gallery[0]->image)
                                                                        ? asset(
                                                                            'uploads/products/gallery/' .
                                                                                $inbox_message->product->gallery[0]
                                                                                    ->image,
                                                                        )
                                                                        : 'https://placehold.co/600x400';
                                                            }
                                                        @endphp
                                                        <div class="table-img">
                                                            <img src="{{ $previewImage }}" style="height: 100%; width: 100%"
                                                                alt="" />
                                                        </div>
                                                    @elseif (isset($inbox_message->tender->id))
                                                        <div class="table-img">
                                                            <img src="@if (isset($inbox_message->tender->image_1) && $inbox_message->tender->image_1 != '') {{ asset('uploads/tender/' . $inbox_message->tender->image_1) }} @else https://placehold.co/400x400 @endif"
                                                                style="height: 100%; width: 100%" alt="" />
                                                        </div>
                                                    @elseif (isset($inbox_message->quotation->id))
                                                        <div class="table-img">
                                                            <img src="@if (isset($inbox_message->quotation->image_1) && $inbox_message->quotation->image_1 != '') {{ asset('uploads/quotation/' . $inbox_message->quotation->image_1) }} @else https://placehold.co/400x400 @endif"
                                                                style="height: 100%; width: 100%" alt="" />
                                                        </div>
                                                    @else
                                                        <div class="table-img">
                                                            <img src="{{ asset('uploads/envelope.png') }}"
                                                                style="height: 100%; width: 100%" alt="" />
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <h6>Message Type: {{ isset($inbox_message->message_type)?ucwords(str_replace('_', ' ', $inbox_message->message_type)):"" }}</h6>
                                                    <h6>Sender: {{ $inbox_message->sender->first_name ?? '' }}</h6>
                                                    <h6>Receiver: {{ $inbox_message->receiver->first_name ?? '' }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="fw-bolder fs-6">{{ Str::limit($inbox_message->subject, 30) }}
                                                    </h6>
                                                    {{ Str::limit($inbox_message->message, 150) }}
                                                </td>
                                                <td>
                                                    @if ($inbox_message->type === 'incoming')
                                                        <span class="badge bg-success">Incoming</span>
                                                    @else
                                                        <span class="badge bg-primary">Outgoing</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ date('d F Y h:i A', strtotime($inbox_message->created_at)) }}
                                                </td>

                                                <td>
                                                    <a href="{{ route('reply.message', $inbox_message->id) }}"
                                                        class="btn btn-sm btn-info text-light">Details</a>
                                                    <a href="{{ route('reply.message', $inbox_message->id) }}"
                                                        class="btn btn-secondary btn-sm me-2">
                                                        <i class="fa fa-message"></i>
                                                    </a>
                                                    <a href="{{ route('delete.message', $inbox_message->id) }}"
                                                        id="delete" class="btn btn-primary btn-sm me-2"><i
                                                            class="fa fa-trash" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row ">
                            <div class="col-12">
                                <div class="d-flex justify-content-center ">
                                    {{ $allMessages->links('pagination::bootstrap-5') }}
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
