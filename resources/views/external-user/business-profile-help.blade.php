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
            <div class="col-md-6 py-4 pt-5">
                <h3 class="fs-2 fw-bolder text-primary">
                    {{ $heading }}
                </h3>
            </div>

        </div>
        <div class="row mt-4">
            <div class="col-lg-4">
                <nav id="profileNav" class="navbar navbar-light bg-light flex-column align-items-stretch p-3">
                    <a class="navbar-brand fs-4 fw-bolder text-primary" href="#">Business Profile</a>
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link text-primary" href="#updateProfile">Update Profile</a>
                        <a class="nav-link text-primary" href="#uploadCertifications">Upload Certifications</a>
                        <a class="nav-link text-primary" href="#uploadBankDetails">Upload Bank Details</a>
                        <a class="nav-link text-primary" href="#uploadSocialMedia">Upload Social Media</a>
                        <a class="nav-link text-primary" href="#uploadProfileImages">Upload Profile Images</a>
                        <a class="nav-link text-primary" href="#uploadSearchKeys">Upload Profile Search Keys</a>
                        <a class="nav-link text-primary" href="#uploadMetaDatas">Upload Profile Meta Datas</a>
                        <a class="nav-link text-primary" href="#activeProfileSymbols">Active Profile Symbols</a>
                        <a class="nav-link text-primary" href="#viewBusinessProfile">View Business Profile</a>
                    </nav>
                </nav>
            </div>
            <div class="col-lg-8">
                <div data-bs-spy="scroll" data-bs-target="#profileNav" data-bs-offset="0" tabindex="0">
                    <!-- Update Profile -->
                    <section id="updateProfile">
                        <h4 class="fw-bolder text-primary">How to update my Business Profile?</h4>
                        <iframe style="width: 100%;height:15rem;" class="mb-5" src="https://www.youtube.com/embed/P4_4stNvZDI?si=m0YTAcmPFmZTH1gs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        <p class="linehight">
                            Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Profile &amp;
                                Management"</span> - Option <span class="text-primary">"Update Profile"</span>
                        </p>
                        <p class="linehight">
                            Here you will find the Update Profile Form, on which you can update your following stored data:
                            Contact Person, Phone Number, Email Address, Company Details, Company Description, Company
                            Address, and the Business Profile Categories.
                            After making changes, just click on <span class="text-primary">"Update &amp; Publish"</span>.
                        </p>
                    </section>
                    <hr>

                    <!-- Upload Certifications -->
                    <section id="uploadCertifications">
                        <h4 class="fw-bolder text-primary">How to upload my Certifications?</h4>
                        <p class="linehight">
                            Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Profile &amp;
                                Management"</span> - Option <span class="text-primary">"My Certifications"</span>
                        </p>
                        <p class="linehight">
                            If you don't have any Certifications, then just click on <span
                                class="text-primary">"Inactive"</span> and then, without any other input, click on <span
                                class="text-primary">"Save &amp; Publish"</span>.
                        </p>
                        <p class="linehight">
                            If you have Certifications, set the status to <span class="text-primary">"Active"</span>. You
                            can select one or more listed types; if your Certification isn’t listed, select <span
                                class="text-primary">"Other"</span> and enter your individual Certification.
                            If you have images of your Certifications, choose the file and click on <span
                                class="text-primary">"Upload"</span> to preview the image, then click on <span
                                class="text-primary">"Save &amp; Publish"</span>.
                        </p>
                    </section>
                    <hr>

                    <!-- Upload Bank Details -->
                    <section id="uploadBankDetails">
                        <h4 class="fw-bolder text-primary">How to upload my Bank Details?</h4>
                        <p class="linehight">
                            Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Profile &amp;
                                Management"</span> - Option <span class="text-primary">"My Bank Details"</span>
                        </p>
                        <p class="linehight">
                            Before you can start to sell, you need to provide your accepted Payment Methods for your Buyers.
                            Activate one or more Payment Methods, enter the required data, and click on <span
                                class="text-primary">"Save"</span>.
                        </p>
                    </section>
                    <hr>

                    <!-- Upload Social Media -->
                    <section id="uploadSocialMedia">
                        <h4 class="fw-bolder text-primary">How to upload my Social Media?</h4>
                        <p class="linehight">
                            Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Profile &amp;
                                Management"</span> - Option <span class="text-primary">"My Social Media"</span>
                        </p>
                        <p class="linehight">
                            Here you can set your Social Media Settings to connect them with your Business Profile.
                            Set the desired fields to <span class="text-primary">"On"</span> and enter the ID or URL.
                            Click on <span class="text-primary">"Save &amp; Publish"</span>.
                        </p>
                    </section>
                    <hr>

                    <!-- Upload Profile Images -->
                    <section id="uploadProfileImages">
                        <h4 class="fw-bolder text-primary">How to Upload Profile Images?</h4>
                        <p class="linehight">
                            Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Profile &amp;
                                Management"</span> - Option <span class="text-primary">"Profile Images"</span>
                        </p>
                        <p class="linehight">
                            Here you can upload your Profile Picture (max. 200 x 200 pixels), Company Logo (max. 200 x 200
                            pixels),
                            Business Profile Banner (max. 2520 x 620 pixels), and 4 Business Profile Gallery Images (each
                            max. 400 x 400 pixels).
                            Choose a file, click on <span class="text-primary">"Upload"</span> to preview the image, then
                            click on <span class="text-primary">"Save &amp; Publish"</span>.
                        </p>
                    </section>
                    <hr>

                    <!-- Upload Profile Search Keys -->
                    <section id="uploadSearchKeys">
                        <h4 class="fw-bolder text-primary">How to Upload Profile Search Keys?</h4>
                        <p class="linehight">
                            Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Profile &amp;
                                Management"</span> - Option <span class="text-primary">"Profile Search Keys"</span>
                        </p>
                        <p class="linehight">
                            Here you can enter up to 10 individual Profile Search Keys, which help list your Business
                            Profile under <span class="text-primary">"Suppliers"</span> via the Main Search Bar.
                            After entering your Business Profile Search Keys, click on <span class="text-primary">"Save
                                &amp; Publish"</span>.
                        </p>
                    </section>
                    <hr>

                    <!-- Upload Profile Meta Datas -->
                    <section id="uploadMetaDatas">
                        <h4 class="fw-bolder text-primary">How to Upload Profile Meta Datas?</h4>
                        <p class="linehight">
                            Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Profile &amp;
                                Management"</span> - Option <span class="text-primary">"Profile Meta Datas"</span>
                        </p>
                        <p class="linehight">
                            (Note: This option is available for Gold or Platinum Members only.)<br />
                            Here you can enter your individual Business Profile Meta Title (max. 60 characters), Meta
                            Description (max. 160 characters), and Meta Keywords (max. 8 words).
                            Click on <span class="text-primary">"Save &amp; Publish"</span>. The entered Meta Datas will be
                            used for your Company SEO.
                        </p>
                    </section>
                    <hr>

                    <!-- Active Profile Symbols -->
                    <section id="activeProfileSymbols">
                        <h4 class="fw-bolder text-primary">How to active Profile Symbols?</h4>
                        <p class="linehight">
                            Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Profile &amp;
                                Management"</span> - Option <span class="text-primary">"Profile Symbols"</span>
                        </p>
                        <p class="linehight">
                            Here you will find an overview of the Business Profile Icons. Some symbols depend on your
                            Membership or require you to fulfill certain requirements.
                            The respective requirements of each icon are shown in the "Info" below the <span
                                class="text-primary">On/Off</span> button.
                            Icons included in your Membership can be switched to <span class="text-primary">"On"</span> so
                            they are visible on your Business Profile and your listed Products.
                            If you would like to use symbols not included in your Membership, first meet the requirements
                            and, once confirmed, switch them on.
                            When finished, click on <span class="text-primary">"Save &amp; Publish"</span>.
                        </p>
                    </section>
                    <hr>

                    <!-- View Business Profile -->
                    <section id="viewBusinessProfile">
                        <h4 class="fw-bolder text-primary">How to view my Business Profile?</h4>
                        <p class="linehight">
                            Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Profile &amp;
                                Management"</span> - Option <span class="text-primary">"View Profile"</span>
                        </p>
                        <p class="linehight">
                            Here you will find an overview of your published Business Profile, including your uploaded
                            Profile Images,
                            Business Description, Company Information, listed Products, Tenders, News, and (if connected)
                            your Social Media Links.
                            You will also see an overview of your Average User Rating and its breakdown.
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection
