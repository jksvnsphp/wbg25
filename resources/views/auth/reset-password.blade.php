@extends('external-user.external-frame')

@section('external-main-content')
<section class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-11 login_forma">
            <div class="row my-3 justify-content-end">
                <div class="col-md-6 mt-3 buyer_rg">
                    <div class="card shadow rounded-0" style="min-height: 25rem">
                        <div class="card-header py-3">
                            <h4 class="fw-bold fs-5 mb-0">Reset Your Password</h4>
                        </div>
                        <div class="card-body p-4 pb-0 pt-3">
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group mb-4">
                                    <label for="email" class="form-label fw-bolder">
                                        Registered Email Address <span class="text-danger">*</span>
                                    </label>
                                    <input type="email"
                                           name="email"
                                           id="email"
                                           class="form-control"
                                           value="{{ old('email', $email) }}"
                                           placeholder="Enter your registered email"
                                           required autofocus>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="password" class="form-label fw-bolder">
                                        New Password <span class="text-danger">*</span>
                                    </label>
                                    <input type="password"
                                           name="password"
                                           id="password"
                                           class="form-control"
                                           placeholder="Enter new password"
                                           required>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="password_confirmation" class="form-label fw-bolder">
                                        Confirm New Password <span class="text-danger">*</span>
                                    </label>
                                    <input type="password"
                                           name="password_confirmation"
                                           id="password_confirmation"
                                           class="form-control"
                                           placeholder="Confirm your new password"
                                           required>
                                </div>

                                <div class="my-4 mb-0">
                                    <button type="submit" class="btn btn-primary w-100">
                                        Reset Password
                                    </button>
                                </div>
                            </form>

                            @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('status'))
                                <div class="alert alert-success mt-3">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
