@extends('buyer-vendor.buyer-frame')
@section('buyer-main-content')
    <style>
        .chat-box {
            border-radius: 10px;
            overflow: hidden;
        }

        .bg-orange {
            background-color: #2E2B70 ;
        }

        .btn-orange {
            background-color: #2E2B70;
            color: #fff;
            border: none;
            transition: background-color 0.3s;
        }

        .btn-orange:hover {
            background-color: #0f024f;
        }

        .chat-messages {
            min-height: 400px;
            max-height: 400px;
            overflow-y: auto;
            background-color: #f7f7f7;
            padding: 15px;
            scroll-behavior: smooth;
            box-shadow: inset 0 4px 6px rgba(0, 0, 0, 0.1), inset 0 -4px 6px rgba(0, 0, 0, 0.1);
        }

        .chat-messages::-webkit-scrollbar {
            width: 8px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #190389, #130363);
            border-radius: 4px;
            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        }

        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #1a0292, #130363);
        }

        .chat-message {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .chat-message.sent {
            align-items: flex-end;
            text-transform: capitalize;
        }

        .chat-message.received {
            align-items: flex-start;
            text-transform: capitalize;
        }

        .chat-message .message {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.95rem;
            max-width: 75%;
            word-wrap: break-word;
            text-transform: capitalize;
        }

        .chat-message.sent .message {
            background-color: #2E2B70;
            color: #fff;
        }

        .chat-message.received .message {
            background-color: #f1f1f1;
            color: #333;
        }

        .chat-message .timestamp {
            font-size: 0.75rem;
            color: #999;
            margin-top: 5px;
        }
    </style>

    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <div class="row align-items-center mb-3">
                    <div class="col-md-2">
                        <h6 class="fs-6 text-light py-2 mt-2 px-3">Reply Message</h6>
                    </div>
                </div>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            @if (isset($message->product->id))
                                @php
                                    // Decode variants safely
                                    $variants = is_string($message->product->variants)
                                        ? json_decode($message->product->variants, true)
                                        : $message->product->variants;
                                    $variants = is_array($variants) ? $variants : [];
                                    $allImages = [];
                                    foreach ($variants as $variant) {
                                        if (!empty($variant['images']) && is_array($variant['images'])) {
                                            $allImages = array_merge($allImages, $variant['images']);
                                        }
                                    }
                                    $previewImage = !empty($allImages)
                                        ? asset('uploads/products/' . $allImages[0])
                                        : null;
                                    if (empty($previewImage)) {
                                        $previewImage =
                                            isset($message->product->gallery[0]->image) &&
                                            !empty($message->product->gallery[0]->image)
                                                ? asset(
                                                    'uploads/products/gallery/' . $message->product->gallery[0]->image,
                                                )
                                                : 'https://placehold.co/600x400';
                                    }
                                @endphp
                                <a href="{{ route('product.detail',$message->product->slug)  }}" class="table-img me-3" style="height: 6rem; width:6rem;">
                                    <img src="{{ $previewImage }}" style="height: 100%; width: 100%" alt="" />
                                </a>
                            @elseif (isset($message->tender->id))
                                <div class="table-img me-3" style="height: 6rem; width:6rem;">
                                    <img src="@if (isset($message->tender->image_1) && $message->tender->image_1 != '') {{ asset('uploads/tender/' . $message->tender->image_1) }} @else https://placehold.co/400x400 @endif"
                                        style="height: 100%; width: 100%" alt="" />
                                </div>
                            @elseif (isset($message->quotation->id))
                                <div class="table-img me-3" style="height: 6rem; width:6rem;">
                                    <img src="@if (isset($message->quotation->image_1) && $message->quotation->image_1 != '') {{ asset('uploads/quotation/' . $message->quotation->image_1) }} @else https://placehold.co/400x400 @endif"
                                        style="height: 100%; width: 100%" alt="" />
                                </div>
                            @else
                                <div class="table-img me-3" style="height: 6rem; width:6rem;">
                                    <img src="{{ asset('uploads/envelope.png') }}" style="height: 100%; width: 100%"
                                        alt="" />
                                </div>
                            @endif
                            <div>
                                <h6 class="fw-semibold fs-6">Message Date:
                                    {{ date('d F Y h:i A', strtotime($message->created_at)) }}</h6>
                                <h6 class="fs-6 mt-2 fw-bolder">
                                    {{ $message->subject }}
                                </h6>
                            </div>
                        </div>
                        <p class="mt-2">
                            {{ $message->message }}
                        </p>
                        <div class="row ">
                            <div class="col-md-8">
                                <div class="card shadow chat-box pb-0">
                                    <div
                                        class="card-header text-white bg-orange d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Chat with {{ $message->sender->first_name ?? '' }}</h5>
                                        <button class="btn btn-light btn-sm" onclick="loadMessages()">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                    </div>
                                    <div class="card-body chat-messages" id="chatMessages">
                                        <!-- Messages will be dynamically loaded here -->
                                    </div>
                                    <div class="card-footer p-2 bg-white">
                                        <form id="chatForm" class="d-flex">
                                            @csrf
                                            <input type="hidden" name="receiver_id" id="receiver_id"
                                                value="{{ $message->sender_id==auth()->user()->id ? $message->receiver_id :$message->sender_id}}">
                                            <input type="hidden" name="message_id" id="message_id"
                                                value="{{ $message->id }}">
                                            <input name="message" id="message" class="form-control me-2"
                                                placeholder="Type your message...">
                                            <button type="submit" class="btn btn-orange text-white">
                                                <i class="fa fa-paper-plane"></i>
                                            </button>
                                        </form>
                                        <small class="text-danger mt-2 d-none" id="messageError"></small>
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
@section('buyer-custome-js')
    <script>
        $(document).ready(function() {
            loadMessages();
            $('#chatForm').on('submit', function(e) {
                e.preventDefault();

                const message = $('#message').val();
                const receiver_id = $('#receiver_id').val();
                const message_id = $('#message_id').val();

                if (!message.trim()) {
                    $('#messageError').text('Message cannot be empty.');
                    return;
                }

                $('#messageError').text('');

                $.ajax({
                    url: "{{ route('send.chat.message') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        message: message,
                        receiver_id: receiver_id,
                        message_id: message_id
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#message').val('');
                            loadMessages();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        toastr.error('An error occurred. Please try again.');
                    }
                });
            });

            function loadMessages() {
                const receiver_id = $('#receiver_id').val();
                const message_id = $('#message_id').val();
                $.ajax({
                    url: "{{ route('fetch.chat.messages') }}",
                    type: "GET",
                    data: {
                        receiver_id: receiver_id,
                        message_id: message_id
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            let chatHtml = '';
                            response.messages.forEach(function(msg) {
                                const isSent = msg.sender_id === {{ auth()->id() }};
                                chatHtml += `
                                <div class="chat-message ${isSent ? 'sent' : 'received'}">
                                    <div class="message">${msg.message}</div>
                                    <div class="timestamp">${msg.created_at_human}</div>
                                </div>
                            `;
                            });
                            $('#chatMessages').html(chatHtml);
                            $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight); 
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        toastr.error('Failed to fetch messages.');
                    }
                });
            }

            function scrollToBottom() {
                const chatBox = document.getElementById('chatMessages');
                chatBox.scrollTop = chatBox.scrollHeight;
            }
            setInterval(loadMessages, 5000);
        });
    </script>
@endsection
