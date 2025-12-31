@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div
                        class="card-header d-flex justify-content-between rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Bulk Mails
                       
                    </div>
                    <div class="card-body pb-0">
                        <form action="{{ route('bulk-mail.send') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="recipient" class="form-label">Select Recipient</label>
                                <select name="recipient" id="recipient" class="form-control" required>
                                    <option value="all">Send Mail to All Members</option>
                                    <option value="all_seller">Send Mail to All Seller</option>
                                    <option value="all_buyer">Send Mail to All Buyer</option>
                                    <option value="specific">Send Mail to Specific Member Only</option>
                                    <option value="bronce">Send Mail to All Bronze Members</option>
                                    <option value="silver">Send Mail to All Silver Members</option>
                                    <option value="gold">Send Mail to All Gold Members</option>
                                    <option value="platinum">Send Mail to All Platinum Members</option>
                                </select>
                            </div>

                            <div class="mb-3 d-none" id="specific-email-div">
                                <label for="specific_email" class="form-label">Enter Email</label>
                                <input type="email" name="specific_email" id="specific_email" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" name="subject" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Email Content</label>
                                <textarea name="message" id="message" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="attachment" class="form-label">Attachment (optional)</label>
                                <input type="file" name="attachment" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary mb-3">Send Mail</button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
@section('custom-js')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

    <script>
        $(document).ready(function() {
            ClassicEditor.create(document.querySelector('#message'))
                .catch(error => console.error(error));

            $('#recipient').on('change', function() {
                if ($(this).val() === 'specific') {
                    $('#specific-email-div').removeClass('d-none');
                    $('#specific_email').prop('required', true);
                } else {
                    $('#specific-email-div').addClass('d-none');
                    $('#specific_email').prop('required', false);
                }
            });
        });
    </script>
@endsection
