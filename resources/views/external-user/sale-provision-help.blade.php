@extends('external-user.external-frame')

@section('external-main-content')
<!-- Header section end here -->
<style>
    .linehight {
        line-height: 1.5 !important;
    }

    .nav-link {
        color: #02368b !important;
    }

    .nav-pills .nav-link.active {
        background-color: #02368b !important;
        color: #fff !important;
    }

    .ulm li {
        list-style: unset !important;
        margin-left: 10px;
    }
</style>
<!-- Data Protection Section -->
<section class="container my-4">
    <div class="row">
        <div class="col-md-12 py-4 pt-5">
            <h3 class="fs-2 fw-bolder text-primary">
                Sale Provision
            </h3>
            <p class="text-primary mt-4" style="line-height: 1.5">

            </p>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-4">
            <nav id="profileNav" class="navbar navbar-light bg-light flex-column align-items-stretch p-3">
                <a class="nav-link text-primary" href="#saleProvisionWallet">Sale Provision Wallet</a>
            </nav>
        </div>
        <div class="col-lg-8">
            <div data-bs-spy="scroll" data-bs-target="#profileNav" data-bs-offset="0" tabindex="0">
                <section id="saleProvisionWallet">
                    <h4 class="fw-bolder text-primary">How work My Sale Provision Wallet?</h4>
                    <p class="linehight">
                        Sign in - Dashboard – New State – Click on Sale Provision Box <span class="text-primary">"More
                            Info"</span> -
                        Then you will be forwarded to the <span class="text-primary">"My Sale Provision Wallet"</span>.
                    </p>
                    <p class="linehight">
                        Here you find an overview of your successful Sales, for which the listed Sale Provision is
                        calculated with <strong>5%</strong>.
                        First, the Sale Provision will be deducted from the Credit of your rental Member Package.
                    </p>
                    <p class="linehight">
                        After using up the Member Package included Sale Provision, the World Business Guide charges an
                        additional <strong>5% Sale Commission</strong> for every Sale,
                        which is billed in monthly cycles on the first of each Calendar Month and is therefore due.
                    </p>
                    <p class="linehight">
                        The costs must be compensated within <strong>10 working days</strong>. If the due payment is not
                        made on time,
                        then the Sale Activities for the affected sales account will be restricted until payment is
                        made.
                    </p>
                    <p class="linehight">
                        If there are any discrepancies with your Sale Commission Wallet, you can contact our Support
                        personally via the <span class="text-primary">Help & Support</span> page.
                    </p>
                </section>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid my-3">
    <a href="{{ url()->previous() }}" class="btn btn-primary">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>
@endsection