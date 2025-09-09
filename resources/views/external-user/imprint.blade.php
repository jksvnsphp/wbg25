@extends('external-user.external-frame')

@section('meta_data')
    <title>Imprint of World Business Guide – WBG24.com</title>
    <meta name="description"
        content="The Imprint of the World Business Guide - WBG24.com - Your international Market - is a Kind of virtual Business Card and serves Customer Transparency.">
    <meta name="keywords" content="Imprint">
    <meta name="author" content="WBG24.com">
@endsection

@section('external-main-content')
    <!-- Imprint Section -->
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
    </style>
    <section class="container my-4">
        <div class="row">
            <div class="col-md-6 py-4 pt-5">
                <h3 class="fs-2 fw-bolder text-primary">Imprint</h3>
                <p class="text-primary mt-4" style="line-height: 1.5">
                    This imprint provides legally required information about the operator of this website.
                </p>
            </div>

        </div>
        <div class="row mt-4">
            <div class="col-4">
                <nav id="navbar-example3" class="navbar navbar-light bg-light flex-column align-items-stretch p-3">
                    <a class="navbar-brand fs-3 fw-bolder" href="#">Imprint</a>
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link" href="#item-1">Company Information</a>
                        <a class="nav-link" href="#item-2">EU dispute settlement</a>
                        <a class="nav-link" href="#item-3">Disclaimer of liability</a>
                        <a class="nav-link" href="#item-4">Copyright</a>
                    </nav>
                </nav>
            </div>
            <div class="col-8">
                <div data-bs-spy="scroll" data-bs-target="#navbar-example3" data-bs-offset="0" tabindex="0">
                    <h4 id="item-1" class="fw-bolder text-primary">Company Information</h4>
                    <p class="linehight mt-3">
                    <h6>According to § 5 TMG</h6>
                    (German Law)
                    </p>

                    <p class="linehight mt-3">
                    <h6> World Business Guide – WBG24</h6>
                    Postfach 19 01 02
                    40111 Düsseldorf
                    West Germany
                    </p>

                    <p class="linehight mt-3">
                    <h6>Owner:</h6>
                    Peter Kowalski
                    </p>
                    <p class="linehight mt-3">
                    <h6>VAT – ID:</h6>
                    DE340488042
                    </p>

                    <p class="linehight mt-3">
                    <h6>Contact</h6>
                    Email: Info@WorldBusinessGuide.com
                    <br>
                    Web: www.WBG24.com
                    </p>

                    <h4 id="item-2" class="fw-bolder text-primary mt-4">EU dispute settlement</h4>
                    <p class="linehight">
                        The European Commission provides a platform for online dispute resolution (OS):
                        https://ec.europa.eu/consumers/odr.
                        You can find our email address in the legal notice above.
                        Consumer dispute settlement / universal arbitration board
                        We are neither willing nor obliged to take part in dispute settlement proceedings before a consumer
                        arbitration board.
                    </p>

                    <h4 id="item-3" class="fw-bolder text-primary mt-4">Disclaimer of liability</h4>
                    <p class="linehight">
                        Liability for content As a service provider, we are responsible for our own content on these pages
                        in accordance with general law in accordance with Section 7, Paragraph 1 of the German Telemedia
                        Act. According to §§ 8 to 10 TMG, as a service provider, we are not obliged to monitor transmitted
                        or stored third-party information or to investigate circumstances that indicate illegal activity.
                        Obligations to remove or block the use of information in accordance with general laws remain
                        unaffected. Liability in this regard is only possible from the point in time at which we become
                        aware of a specific legal violation. As soon as we become aware of such legal violations, we will
                        remove this content immediately.
                        Liability for links Our offer contains links to external third-party websites over whose content we
                        have no influence. Therefore, we cannot accept any liability for this third-party content. The
                        respective provider or operator of the pages is always responsible for the content of the linked
                        pages. The linked pages were for Checked for possible legal violations at the time of linking. No
                        illegal content was found at the time the link was created.
                        However, permanent monitoring of the content of the linked pages is not reasonable without concrete
                        evidence of a violation of the law. If we become aware of legal violations, we will remove such
                        links immediately.
                    </p>

                    <h4 id="item-4" class="fw-bolder text-primary mt-4">Copyright</h4>
                    <p class="linehight">
                        The content and works on these pages created by the website operator are subject to German copyright
                        law. The duplication, processing, distribution and any kind of exploitation outside the limits of
                        copyright law require the written consent of the respective author. Downloads and copies of this
                        website are only permitted for private, non-commercial use. Insofar as the content on this site was
                        not created by the operator, the copyrights of third parties are observed. In particular contents of
                        third parties are marked as such. Should you nevertheless become aware of a copyright infringement,
                        we would ask you to notify us accordingly. If we become aware of any legal violations, we will
                        remove such content immediately.
                    </p>


                </div>
            </div>
        </div>
    </section>
@endsection
