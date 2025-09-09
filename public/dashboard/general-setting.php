<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>WBG24 Dashboar General Settings</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css" />

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php require_once './part/sidebar.php' ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php require_once './part/topbar.php' ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="card rounded-0">
                                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    Site Details
                                </div>
                                <div class="card-body pb-0">
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 ">
                                            <label for="" class="form-label fs-3 font-weight-bolder text-dark">Company Name: <i class="fas fa-asterisk fs-1 text-danger"></i></label>
                                            <input name="company_name" type="text" class="form-control form-control-user" placeholder="Company Name">
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label for="" class="form-label fs-3 font-weight-bolder text-dark">Company Address: <i class="fas fa-asterisk fs-1 text-danger"></i></label>
                                            <input name="company_address" type="text" class="form-control form-control-user" placeholder="Company Address">
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label for="" class="form-label fs-3 font-weight-bolder text-dark">Phone: <i class="fas fa-asterisk fs-1 text-danger"></i></label>
                                            <input name="company_phone" type="tel" class="form-control form-control-user" placeholder="Company Phone Number">
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label for="" class="form-label fs-3 font-weight-bolder text-dark">Mobile: <i class="fas fa-asterisk fs-1 text-danger"></i></label>
                                            <input name="company_mobile" type="tel" class="form-control form-control-user" placeholder="Company Mobile Number">
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label for="" class="form-label fs-3 font-weight-bolder text-dark">Email: <i class="fas fa-asterisk fs-1 text-danger"></i></label>
                                            <input name="company_email" type="email" class="form-control form-control-user" placeholder="Company Email">
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label for="" class="form-label fs-3 font-weight-bolder text-dark">Support Email: <i class="fas fa-asterisk fs-1 text-danger"></i></label>
                                            <input name="company_support_email" type="email" class="form-control form-control-user" placeholder="Company Support Email">
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label for="" class="form-label fs-3 font-weight-bolder text-dark">Webmaster Email: <i class="fas fa-asterisk fs-1 text-danger"></i></label>
                                            <input name="company_webmaster_email" type="email" class="form-control form-control-user" placeholder="Company Webmaster Email">
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label for="" class="form-label fs-3 font-weight-bolder text-dark">Page Row: <i class="fas fa-asterisk fs-1 text-danger"></i></label>
                                            <input name="page_row" type="number" class="form-control form-control-user" placeholder="Page Row" value="15">
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label for="" class="form-label fs-3 font-weight-bolder text-dark">Set Default Timzone:</label>
                                            <select name="company_timezone" id="company_timezone" class="form-control">
                                                <option value="">Select Timezone</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label for="" class="form-label fs-3 font-weight-bolder text-dark">Auto Approval ON/OFF: <i class="fas fa-asterisk fs-1 text-danger"></i></label>
                                            <div class="input-check">
                                                <input type="radio" name="isAutoApproval" id="on" value="1">
                                                <label for="on" class="font-weight-bolder text-dark fs-2 ">ON</label> |
                                                <input checked type="radio" name="isAutoApproval" id="off" value="0">
                                                <label for="off" class="font-weight-bolder fs-2 text-dark">OFF</label>
                                            </div>
                                        </div>
                                        <div class="mt-3 p-2 pb-0 mb-0">
                                            <button class="btn btn-sm btn-primary">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card rounded-0 mt-4">
                                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    Payment Option
                                </div>
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="card rounded-0">
                                                <div class="card-header py-2  font-weight-bolder bg_bodyc rounded-0">
                                                    Paypal ON/OFF
                                                </div>
                                                <div class="card-body">
                                                    <label for="" class="form-label fs-3 font-weight-bolder text-dark">PayPal ON/OFF: <i class="fas fa-asterisk fs-1 text-danger"></i></label>
                                                    <div class="input-check">
                                                        <input type="radio" name="isPaypal" id="isPaypalon" value="1">
                                                        <label for="isPaypalon" class="font-weight-bolder text-dark fs-2 ">ON</label> |
                                                        <input checked type="radio" name="isPaypal" id="isPaypaloff" value="0">
                                                        <label for="isPaypaloff" class="font-weight-bolder fs-2 text-dark">OFF</label>
                                                    </div>
                                                    <div class="form-group mt-2 mb-0">
                                                        <label for="paypalEmail" class="fs-2 font-weight-bolder">PayPal Email: <i class="fas fa-asterisk fs-1 text-danger"></i></label>
                                                        <input type="email" name="paypal_email" id="paypal_email" class="form-control" placeholder="sales@domain.com">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3 mb-3">
                                            <div class="card rounded-0">
                                                <div class="card-header py-2  font-weight-bolder bg_bodyc rounded-0">
                                                    Update Your Bank Details:
                                                </div>
                                                <div class="card-body pt-5">
                                                    <textarea name="bank_detail" id="editor" class="form-control" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 mb-2 px-3">
                                            <button class="btn btn-primary btn-sm">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card rounded-0 mt-4">
                                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    Social Link Setting
                                </div>
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-sm-4 mb-3">
                                            <div class="card rounded-0">
                                                <div class="card-header rounded-0 py-2 bg_bodyc text-dark font-weight-bolder">
                                                    Facebook Page Name :
                                                </div>
                                                <div class="card-body">

                                                    <div class="form-group">
                                                        <input type="url" name="facebook_url" id="facebook_url" class="form-control" placeholder="https://www.facebook.com">
                                                    </div>
                                                    <label for="" class="form-label fs-3 font-weight-bolder text-dark">Facebook ON/OFF:</label>

                                                    <div class="input-check">
                                                        <input type="radio" name="isFacebook" id="isFacebookon" value="1">
                                                        <label for="isFacebookon" class="font-weight-bolder text-dark fs-2 ">ON</label> |
                                                        <input checked type="radio" name="isFacebook" id="isFacebookoff" value="0">
                                                        <label for="isFacebookoff" class="font-weight-bolder fs-2 text-dark">OFF</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mb-3">
                                            <div class="card rounded-0">
                                                <div class="card-header rounded-0 py-2 bg_bodyc text-dark font-weight-bolder">
                                                    Twitter Page Name :
                                                </div>
                                                <div class="card-body">

                                                    <div class="form-group">
                                                        <input type="url" name="twitter_url" id="twitter_url" class="form-control" placeholder="https://www.twitter.com">
                                                    </div>
                                                    <label for="" class="form-label fs-3 font-weight-bolder text-dark">Twitter ON/OFF:</label>

                                                    <div class="input-check">
                                                        <input type="radio" name="isTwitter" id="isTwitteron" value="1">
                                                        <label for="isTwitteron" class="font-weight-bolder text-dark fs-2 ">ON</label> |
                                                        <input checked type="radio" name="isTwitter" id="isTwitteroff" value="0">
                                                        <label for="isTwitteroff" class="font-weight-bolder fs-2 text-dark">OFF</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mb-3">
                                            <div class="card rounded-0">
                                                <div class="card-header rounded-0 py-2 bg_bodyc text-dark font-weight-bolder">
                                                    Google+ Name :
                                                </div>
                                                <div class="card-body">

                                                    <div class="form-group">
                                                        <input type="url" name="google_plus_url" id="google_plus_url" class="form-control" placeholder="https://www.googtlepluse.com">
                                                    </div>
                                                    <label for="" class="form-label fs-3 font-weight-bolder text-dark">Google+ ON/OFF:</label>

                                                    <div class="input-check">
                                                        <input type="radio" name="isGooglePlus" id="isGooglePluson" value="1">
                                                        <label for="isGooglePluson" class="font-weight-bolder text-dark fs-2 ">ON</label> |
                                                        <input checked type="radio" name="isGooglePlus" id="isGooglePlusoff" value="0">
                                                        <label for="isGooglePlusoff" class="font-weight-bolder fs-2 text-dark">OFF</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mb-3">
                                            <div class="card rounded-0">
                                                <div class="card-header rounded-0 py-2 bg_bodyc text-dark font-weight-bolder">
                                                    Pinterest Name :
                                                </div>
                                                <div class="card-body">

                                                    <div class="form-group">
                                                        <input type="url" name="pintrest_url" id="pintrest_url" class="form-control" placeholder="https://www.pinterest.com">
                                                    </div>
                                                    <label for="" class="form-label fs-3 font-weight-bolder text-dark">Pinterest ON/OFF:</label>

                                                    <div class="input-check">
                                                        <input type="radio" name="isPintrest" id="isPintreston" value="1">
                                                        <label for="isPintreston" class="font-weight-bolder text-dark fs-2 ">ON</label> |
                                                        <input checked type="radio" name="isPintrest" id="isPintrestoff" value="0">
                                                        <label for="isPintrestoff" class="font-weight-bolder fs-2 text-dark">OFF</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mb-3">
                                            <div class="card rounded-0">
                                                <div class="card-header rounded-0 py-2 bg_bodyc text-dark font-weight-bolder">
                                                    Youtube Page Name :
                                                </div>
                                                <div class="card-body">

                                                    <div class="form-group">
                                                        <input type="url" name="youtube_url" id="youtube_url" class="form-control" placeholder="https://www.youtube.com">
                                                    </div>
                                                    <label for="" class="form-label fs-3 font-weight-bolder text-dark">Youtube ON/OFF:</label>

                                                    <div class="input-check">
                                                        <input type="radio" name="isYoutube" id="isYoutubeon" value="1">
                                                        <label for="isYoutubeon" class="font-weight-bolder text-dark fs-2 ">ON</label> |
                                                        <input checked type="radio" name="isYoutube" id="isYoutubeoff" value="0">
                                                        <label for="isYoutubeoff" class="font-weight-bolder fs-2 text-dark">OFF</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mb-3">
                                            <div class="card rounded-0">
                                                <div class="card-header rounded-0 py-2 bg_bodyc text-dark font-weight-bolder">
                                                    Linkedin Page Name :
                                                </div>
                                                <div class="card-body">

                                                    <div class="form-group">
                                                        <input type="url" name="linkedin_url" id="linkedin_url" class="form-control" placeholder="https://www.linkedin.com">
                                                    </div>
                                                    <label for="" class="form-label fs-3 font-weight-bolder text-dark">LinkedIn ON/OFF:</label>

                                                    <div class="input-check">
                                                        <input type="radio" name="isLinkedin" id="isLinkedinon" value="1">
                                                        <label for="isLinkedinon" class="font-weight-bolder text-dark fs-2 ">ON</label> |
                                                        <input checked type="radio" name="isLinkedin" id="isLinkedinoff" value="0">
                                                        <label for="isLinkedinoff" class="font-weight-bolder fs-2 text-dark">OFF</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 px-3 mb-3">
                                            <button class="btn btn-sm btn-primary">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card rounded-0 mt-4">
                                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    SMTP Mail Configuration
                                </div>
                                <div class="card-body ">
                                    <div class="card rounded-0">
                                        <div class="card-header d-flex align-items-center rounded-0 py-2 bg_bodyc text-dark font-weight-bolder">
                                            Mail On/Off :
                                            <div class="input-check px-2 mb-0 pb-0">
                                                <input type="radio" name="isMail" id="isMailon" value="1">
                                                <label for="isMailon" class="pb-0 mb-0 font-weight-bolder text-dark fs-2 ">ON</label> |
                                                <input checked type="radio" name="isMail" id="isMailoff" value="0">
                                                <label for="isMailoff" class="pb-0 mb-0 font-weight-bolder fs-2 text-dark">OFF</label>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-4 col-sm-3 ">
                                                    <h5 class="fs-3 m-0 p-0 font-weight-bold">Port :</h5>
                                                </div>
                                                <div class="col-8 col-sm-9">
                                                    <input type="number" name="port" id="port" class="form-control" value="587">
                                                    <small class="text-secondary"> (Sets SMTP Port. Default Port is 25)</small>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-4 col-sm-3 ">
                                                    <h5 class="fs-3 m-0 p-0 font-weight-bold">Secure :</h5>
                                                </div>
                                                <div class="col-8 col-sm-9">
                                                    <input type="text" name="secure" id="secure" class="form-control" value="tls">
                                                    <small class="text-secondary"> (Options are "", "ssl" or "tls")</small>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-4 col-sm-3 ">
                                                    <h5 class="fs-3 m-0 p-0 font-weight-bold">Host :</h5>
                                                </div>
                                                <div class="col-8 col-sm-9">
                                                    <input type="text" name="host" id="host" class="form-control" value="smtp.gmail.com">
                                                    <small class="text-secondary">(SMTP server)</small>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-4 col-sm-3 ">
                                                    <h5 class="fs-3 m-0 p-0 font-weight-bold">User Name :</h5>
                                                </div>
                                                <div class="col-8 col-sm-9">
                                                    <input type="text" name="username" id="username" class="form-control" value="abcd@gmail.com">
                                                    <small class="text-secondary"> (Sets SMTP username.)</small>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-4 col-sm-3 ">
                                                    <h5 class="fs-3 m-0 p-0 font-weight-bold">Password :</h5>
                                                </div>
                                                <div class="col-8 col-sm-9">
                                                    <input type="text" name="smtp_password" id="smtp_password" class="form-control" value="dsgsbg@435%%">
                                                    <small class="text-secondary"> (Sets SMTP Password.)</small>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-sm btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card rounded-0 mt-4">
                                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    Google Setting
                                </div>
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <div class="form-group">
                                                <label for="map_api_key" class="font-weight-bold fs-3  ">Google Map API Key: </label>
                                                <input type="text" name="map_api_key" id="map_api_key" class="form-control" placeholder="Google map api key" value="AIzaSyAwEf466NysuHU-1vEbeiAiRVebYtPiAGY">
                                                <a class="fs-2 font-weight-bold mt-2" href="https://code.google.com/apis/console/" target="_blank">Generate new google map api key here</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <div class="form-group">
                                                <label for="webmaster_code" class="font-weight-bold fs-3  ">Google Webmaster Verification Code :</label>
                                                <input type="text" name="webmaster_code" id="webmaster_code" class="form-control">
                                                <a class="fs-2 font-weight-bold mt-2" href="https://www.google.com/webmasters/tools/home?hl=en" target="_blank">Get Your Google Webmaster Verification Meta Code Signup Now</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <div class="form-group">
                                                <label for="google_analytical_code" class="font-weight-bold fs-3  ">Google Analytic's Code:</label>
                                                <textarea name="google_analytical_code" id="google_analytical_code" class="form-control" rows="10"></textarea>
                                                <a class="fs-2 font-weight-bold mt-2" href="https://www.google.com/analytics/home/?hl=en" target="_blank">Get Your Get Your Google Analytical Code Signup Now</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <div class="form-group">
                                                <label for="adsense" class="font-weight-bold fs-3  ">Google Adsense ID : </label>
                                                <input type="text" name="adsense" id="adsense" class="form-control" placeholder="Google Adsense Id" value="ca-pub-699423236866028889">
                                                <a class="fs-2 font-weight-bold mt-2" href="https://adsense.google.com/start/" target="_blank">Get Your Google Google Adsense ID Signup Now</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <div class="form-group">
                                                <label for="copyright" class="font-weight-bold fs-3  ">copyright information :</label>
                                                <input type="text" name="copyright" id="copyright" class="form-control">

                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card rounded-0 mt-4">
                                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    Site Status
                                </div>

                                <div class="card-body ">
                                    <div class="card rounded-0">
                                        <div class="card-header d-flex align-items-center rounded-0 py-2 bg_bodyc text-dark font-weight-bolder">
                                            Site On/Off :
                                            <div class="input-check px-2 mb-0 pb-0">
                                                <input type="radio" name="isSite" id="isSiteon" value="1">
                                                <label for="isSiteon" class="pb-0 mb-0 font-weight-bolder text-dark fs-2 ">ON</label> |
                                                <input checked type="radio" name="isSite" id="isSiteoff" value="0">
                                                <label for="isSiteoff" class="pb-0 mb-0 font-weight-bolder fs-2 text-dark">OFF</label>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="custom_message" class="font-weight-bold fs-3 ">Custom Message: </label>
                                                <textarea name="custom_message" id="custom_message" class="form-control" rows="8"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn btn-sm btn-primary">Save Changes</button>
                                    </div>
                                </div>

                            </div>
                            <div class="card rounded-0 mt-4">
                                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    Conformation Email On/Off
                                </div>

                                <div class="card-body ">
                                    <div class=" d-flex align-items-center rounded-0 py-2  text-dark font-weight-bolder">
                                        Conformation Email On/Off
                                        <div class="input-check px-2 mb-0 pb-0">
                                            <input type="radio" name="isConfirmationEmail" id="isConfirmationEmailon" value="1">
                                            <label for="isConfirmationEmailon" class="pb-0 mb-0 font-weight-bolder text-dark fs-2 ">ON</label> |
                                            <input checked type="radio" name="isConfirmationEmail" id="isConfirmationEmailoff" value="0">
                                            <label for="isConfirmationEmailoff" class="pb-0 mb-0 font-weight-bolder fs-2 text-dark">OFF</label>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn btn-sm btn-primary">Save Changes</button>
                                    </div>
                                </div>

                            </div>
                            <div class="card rounded-0 mt-4">
                                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    Change Logo
                                </div>

                                <div class="card-body ">
                                    <div class="form-group">
                                        <label for="logo" class="font-weight-bold fs-3 ">Logo</label>
                                        <input type="file" name="logo" class="form-control-file" id="logo">
                                    </div>
                                    <img src="./img/logo.png" style="height: 5rem;" alt="">
                                    <div class="mt-3">
                                        <button class="btn btn-sm btn-primary">Save Changes</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>


                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php require_once './part/footer.php' ?>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Select "Logout" below if you are ready to end your current session.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        Cancel
                    </button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#editor').trumbowyg();;

        })
    </script>
</body>

</html>