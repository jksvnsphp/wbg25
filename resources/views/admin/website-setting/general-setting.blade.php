@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Site Details
                    </div>
                    <form method="post" action="{{ route('admin.website.detail.update') }}" class="card-body pb-0">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 ">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Company Name: <i
                                        class="fas fa-asterisk fs-1 text-danger"></i></label>
                                <input name="company_name" type="text" class="form-control form-control-user"
                                    placeholder="Company Name" value="{{ $website_detail->company_name }}">
                                @error('company_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Company Address:
                                    <i class="fas fa-asterisk fs-1 text-danger"></i></label>
                                <input name="company_address" type="text" class="form-control form-control-user"
                                    placeholder="Company Address" value="{{ $website_detail->company_address }}">
                                @error('company_address')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Phone: <i
                                        class="fas fa-asterisk fs-1 text-danger"></i></label>
                                <input name="phone" type="tel" class="form-control form-control-user"
                                    placeholder="Company Phone Number" value="{{ $website_detail->phone }}">
                                @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Mobile: <i
                                        class="fas fa-asterisk fs-1 text-danger"></i></label>
                                <input name="mobile" type="tel" class="form-control form-control-user"
                                    placeholder="Company Mobile Number" value="{{ $website_detail->mobile }}">
                                @error('mobile')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Email: <i
                                        class="fas fa-asterisk fs-1 text-danger"></i></label>
                                <input name="email" type="email" class="form-control form-control-user"
                                    placeholder="Company Email" value="{{ $website_detail->email }}">
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Support Email: <i
                                        class="fas fa-asterisk fs-1 text-danger"></i></label>
                                <input name="support_email" type="email" class="form-control form-control-user"
                                    placeholder="Company Support Email" value="{{ $website_detail->support_email }}">
                                @error('support_email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Webmaster Email:
                                    <i class="fas fa-asterisk fs-1 text-danger"></i></label>
                                <input name="webmaster_email" type="email" class="form-control form-control-user"
                                    placeholder="Company Webmaster Email" value="{{ $website_detail->webmaster_email }}">
                                @error('webmaster_email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Page Row: <i
                                        class="fas fa-asterisk fs-1 text-danger"></i></label>
                                <input name="page_row" type="number" class="form-control form-control-user"
                                    placeholder="Page Row" value="{{ $website_detail->page_row }}">
                                @error('page_row')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Set Default
                                    Timzone:</label>
                                <select name="company_timezone" id="company_timezone" class="form-control">
                                    <option value="">Select Timezone</option>
                                    @foreach ($timezones as $timezone)
                                        <option @selected($timezone == $website_detail->timezone) value="{{ $timezone }}">
                                            {{ $timezone }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Auto Approval
                                    ON/OFF: <i class="fas fa-asterisk fs-1 text-danger"></i></label>
                                <div class="input-check">
                                    <input @checked($website_detail->auto_approval == 1) type="radio" name="auto_approval"
                                        id="on" value="1">
                                    <label for="on" class="font-weight-bolder text-dark fs-2 ">ON</label> |
                                    <input @checked($website_detail->auto_approval == 0) type="radio" name="auto_approval"
                                        id="off" value="0">
                                    <label for="off" class="font-weight-bolder fs-2 text-dark">OFF</label>
                                </div>
                                @error('auto_approval')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-3 p-2 pb-0 mb-0">
                                <button class="btn btn-sm btn-primary" type="submit">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card rounded-0 mt-4">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Payment Option
                    </div>
                    <form method="post" action="{{ route('admin.payment.method.update') }}" class="card-body pb-0">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card rounded-0">
                                    <div class="card-header py-2  font-weight-bolder bg_bodyc rounded-0">
                                        Paypal ON/OFF
                                    </div>
                                    <div class="card-body">
                                        <label for="" class="form-label fs-3 font-weight-bolder text-dark">PayPal
                                            ON/OFF: <i class="fas fa-asterisk fs-1 text-danger"></i></label>
                                        <div class="input-check">
                                            <input @checked($paypal->status == 1) type="radio" name="status"
                                                id="isPaypalon" value="1">
                                            <label for="isPaypalon" class="font-weight-bolder text-dark fs-2 ">ON</label>
                                            |
                                            <input @checked($paypal->status == 0) type="radio" name="status"
                                                id="isPaypaloff" value="0">
                                            <label for="isPaypaloff" class="font-weight-bolder fs-2 text-dark">OFF</label>
                                        </div>
                                        @error('status')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <div class="form-group mt-2 mb-0">
                                            <label for="paypalEmail" class="fs-2 font-weight-bolder">PayPal Email: <i
                                                    class="fas fa-asterisk fs-1 text-danger"></i></label>
                                            <input type="email" name="email" id="paypal_email" class="form-control"
                                                placeholder="sales@domain.com" value='{{ $paypal->email }}'>
                                            @error('email')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
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
                                        <textarea name="bank_detail" id="editor" class="form-control" rows="10">{{ $paypal->bank_detail }}</textarea>
                                        @error('bank_detail')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 mb-2 px-3">
                                <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card rounded-0 mt-4">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Social Link Setting
                    </div>
                    <form method="post" action="{{ route('admin.social.links.update') }}" class="card-body pb-0">
                        <div class="row">
                            @csrf
                            <div class="col-sm-4 mb-3">
                                <div class="card rounded-0">
                                    <div class="card-header rounded-0 py-2 bg_bodyc text-dark font-weight-bolder">
                                        Facebook Page Name :
                                    </div>
                                    <div class="card-body">

                                        <div class="form-group">
                                            <input type="url" name="facebook_url" id="facebook_url"
                                                class="form-control" value="{{ $social_link->facebook }}"
                                                placeholder="https://www.facebook.com">
                                            @error('facebook_url')
                                                <p class="text-danger">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <label for=""
                                            class="form-label fs-3 font-weight-bolder text-dark">Facebook ON/OFF:</label>

                                        <div class="input-check">
                                            <input type="radio" @checked($social_link->isFacebook == 1) name="isFacebook"
                                                id="isFacebookon" value="1">
                                            <label for="isFacebookon"
                                                class="font-weight-bolder text-dark fs-2 ">ON</label> |
                                            <input type="radio" @checked($social_link->isFacebook == 0) name="isFacebook"
                                                id="isFacebookoff" value="0">
                                            <label for="isFacebookoff"
                                                class="font-weight-bolder fs-2 text-dark">OFF</label>
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
                                            <input type="url" name="twitter_url" id="twitter_url"
                                                class="form-control" value="{{ $social_link->twitter }}"
                                                placeholder="https://www.twitter.com">
                                            @error('twitter_url')
                                                <p class="text-danger">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <label for="" class="form-label fs-3 font-weight-bolder text-dark">Twitter
                                            ON/OFF:</label>

                                        <div class="input-check">
                                            <input type="radio" @checked($social_link->isTwitter == 1) name="isTwitter"
                                                id="isTwitteron" value="1">
                                            <label for="isTwitteron" class="font-weight-bolder text-dark fs-2 ">ON</label>
                                            |
                                            <input type="radio" @checked($social_link->isTwitter == 0) name="isTwitter"
                                                id="isTwitteroff" value="0">
                                            <label for="isTwitteroff"
                                                class="font-weight-bolder fs-2 text-dark">OFF</label>
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
                                            <input type="url" name="google_plus_url" id="google_plus_url"
                                                class="form-control" value="{{ $social_link->googleplus }}"
                                                placeholder="https://www.googtlepluse.com">
                                            @error('google_plus_url')
                                                <p class="text-danger"> {{ $message }}</p>
                                            @enderror
                                        </div>
                                        <label for="" class="form-label fs-3 font-weight-bolder text-dark">Google+
                                            ON/OFF:</label>

                                        <div class="input-check">
                                            <input type="radio" name="isGoogleplus" id="isGooglePluson" value="1"
                                                @checked($social_link->isGoogleplus == 1)>
                                            <label for="isGooglePluson"
                                                class="font-weight-bolder text-dark fs-2 ">ON</label> |
                                            <input @checked($social_link->isGoogleplus == 0) type="radio" name="isGoogleplus"
                                                id="isGooglePlusoff" value="0">
                                            <label for="isGooglePlusoff"
                                                class="font-weight-bolder fs-2 text-dark">OFF</label>
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
                                            <input type="url" name="pinterest_url" id="pintrest_url"
                                                class="form-control" value="{{ $social_link->pinterest }}"
                                                placeholder="https://www.pinterest.com">
                                            @error('pintrest_url')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <label for=""
                                            class="form-label fs-3 font-weight-bolder text-dark">Pinterest ON/OFF:</label>

                                        <div class="input-check">
                                            <input type="radio" @checked($social_link->isPinterest == 1) name="isPinterest"
                                                id="isPintreston" value="1">
                                            <label for="isPintreston"
                                                class="font-weight-bolder text-dark fs-2 ">ON</label> |
                                            <input @checked($social_link->isPinterest == 0) type="radio" name="isPinterest"
                                                id="isPintrestoff" value="0">
                                            <label for="isPintrestoff"
                                                class="font-weight-bolder fs-2 text-dark">OFF</label>
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
                                            <input type="url" name="youtube_url" id="youtube_url"
                                                class="form-control" value="{{ $social_link->youtube }}"
                                                placeholder="https://www.youtube.com">
                                            @error('youtube_url')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <label for="" class="form-label fs-3 font-weight-bolder text-dark">Youtube
                                            ON/OFF:</label>

                                        <div class="input-check">
                                            <input type="radio" @checked($social_link->isYoutube == 1) name="isYoutube"
                                                id="isYoutubeon" value="1">
                                            <label for="isYoutubeon" class="font-weight-bolder text-dark fs-2 ">ON</label>
                                            |
                                            <input @checked($social_link->isYoutube == 0) type="radio" name="isYoutube"
                                                id="isYoutubeoff" value="0">
                                            <label for="isYoutubeoff"
                                                class="font-weight-bolder fs-2 text-dark">OFF</label>
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
                                            <input type="url" name="linkedin_url" id="linkedin_url"
                                                class="form-control" value="{{ $social_link->linkedin }}"
                                                placeholder="https://www.linkedin.com">
                                            @error('linkedin_url')
                                                <p class="text-danger">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <label for=""
                                            class="form-label fs-3 font-weight-bolder text-dark">LinkedIn ON/OFF:</label>

                                        <div class="input-check">
                                            <input type="radio" @checked($social_link->isLinkedin == 1) name="isLinkedin"
                                                id="isLinkedinon" value="1">
                                            <label for="isLinkedinon"
                                                class="font-weight-bolder text-dark fs-2 ">ON</label> |
                                            <input @checked($social_link->isLinkedin == 0) type="radio" name="isLinkedin"
                                                id="isLinkedinoff" value="0">
                                            <label for="isLinkedinoff"
                                                class="font-weight-bolder fs-2 text-dark">OFF</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 px-3 mb-3">
                                <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card rounded-0 mt-4">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        SMTP Mail Configuration
                    </div>
                    <form method="post" action="{{ route('admin.smtp.setting.update') }}" class="card-body ">
                        @csrf
                        <div class="card rounded-0">
                            <div
                                class="card-header d-flex align-items-center rounded-0 py-2 bg_bodyc text-dark font-weight-bolder">
                                Mail On/Off :
                                <div class="input-check px-2 mb-0 pb-0">
                                    <input type="radio" @checked($smtp->status == 1) name="isMail" id="isMailon"
                                        value="1">
                                    <label for="isMailon" class="pb-0 mb-0 font-weight-bolder text-dark fs-2 ">ON</label>
                                    |
                                    <input type="radio" @checked($smtp->status == 0) name="isMail" id="isMailoff"
                                        value="0">
                                    <label for="isMailoff" class="pb-0 mb-0 font-weight-bolder fs-2 text-dark">OFF</label>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-4 col-sm-3 ">
                                        <h5 class="fs-3 m-0 p-0 font-weight-bold">Port :</h5>
                                    </div>
                                    <div class="col-8 col-sm-9">
                                        <input type="number" name="port" id="port" class="form-control"
                                            value="{{ $smtp->port }}">
                                        @error('port')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <small class="text-dark"> (Sets SMTP Port. Default Port is 25)</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4 col-sm-3 ">
                                        <h5 class="fs-3 m-0 p-0 font-weight-bold">Secure :</h5>
                                    </div>
                                    <div class="col-8 col-sm-9">
                                        <input type="text" name="secure" id="secure" class="form-control"
                                            value="{{ $smtp->secure }}">
                                        @error('secure')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <small class="text-secondary"> (Options are "", "ssl" or "tls")</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4 col-sm-3 ">
                                        <h5 class="fs-3 m-0 p-0 font-weight-bold">Host :</h5>
                                    </div>
                                    <div class="col-8 col-sm-9">
                                        <input type="text" name="host" id="host" class="form-control"
                                            value="{{ $smtp->host }}">
                                        @error('host')
                                            <p class="text-danger"> {{ $message }} </p>
                                        @enderror
                                        <small class="text-secondary">(SMTP server)</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4 col-sm-3 ">
                                        <h5 class="fs-3 m-0 p-0 font-weight-bold">User Name :</h5>
                                    </div>
                                    <div class="col-8 col-sm-9">
                                        <input type="text" name="username" id="username" class="form-control"
                                            value="{{ $smtp->username }}">
                                        @error('username')
                                            <p class="text-danger"> {{ $message }} </p>
                                        @enderror
                                        <small class="text-secondary"> (Sets SMTP username.)</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4 col-sm-3 ">
                                        <h5 class="fs-3 m-0 p-0 font-weight-bold">Password :</h5>
                                    </div>
                                    <div class="col-8 col-sm-9">
                                        <input type="text" name="password" id="smtp_password" class="form-control"
                                            value="{{ $smtp->password }}">
                                        @error('password')
                                            <p class="text-danger"> {{ $message }} </p>
                                        @enderror
                                        <small class="text-secondary"> (Sets SMTP Password.)</small>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
                <div class="card rounded-0 mt-4">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Google Setting
                    </div>
                    <form method="post" action="{{ route('admin.google.setting.update') }}" class="card-body ">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <label for="map_api_key" class="font-weight-bold fs-3  ">Google Map API Key: </label>
                                    <input type="text" name="google_map_api_key" id="map_api_key"
                                        class="form-control" placeholder="Google map api key"
                                        value="{{ $google_setting->google_map_api_key }}">
                                    <a class="fs-2 font-weight-bold mt-2" href="https://code.google.com/apis/console/"
                                        target="_blank">Generate new google map api key here</a>
                                    @error('google_map_api_key')
                                        <p class="text-danger"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <label for="webmaster_code" class="font-weight-bold fs-3  ">Google Webmaster
                                        Verification Code :</label>
                                    <input type="text" name="google_webmaster_code" id="webmaster_code"
                                        class="form-control" value="{{ $google_setting->google_webmaster_code }}">
                                    <a class="fs-2 font-weight-bold mt-2"
                                        href="https://www.google.com/webmasters/tools/home?hl=en" target="_blank">Get Your
                                        Google Webmaster Verification Meta Code Signup Now</a>
                                    @error('google_webmaster_code')
                                        <p class="text-danger"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="google_analytical_code" class="font-weight-bold fs-3  ">Google Analytic's
                                        Code:</label>
                                    <textarea name="google_analytics_code" id="google_analytical_code" class="form-control" rows="10">{{ $google_setting->google_analytics_code }}</textarea>
                                    <a class="fs-2 font-weight-bold mt-2"
                                        href="https://www.google.com/analytics/home/?hl=en" target="_blank">Get Your Get
                                        Your Google Analytical Code Signup Now</a>
                                    @error('google_analytics_code')
                                        <p class="text-danger"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <label for="adsense" class="font-weight-bold fs-3  ">Google Adsense ID : </label>
                                    <input type="text" name="google_adsens_id" id="adsense" class="form-control"
                                        placeholder="Google Adsense Id" value="{{ $google_setting->google_adsens_id }}">
                                    <a class="fs-2 font-weight-bold mt-2" href="https://adsense.google.com/start/"
                                        target="_blank">Get Your Google Google Adsense ID Signup Now</a>

                                    @error('google_adsens_id')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <label for="copyright" class="font-weight-bold fs-3  ">copyright information :</label>
                                    <input type="text" name="copyright_info"
                                        value="{{ $google_setting->copyright_info }}" id="copyright"
                                        class="form-control">
                                    @error('copyright_info')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
                <div class="card rounded-0 mt-4">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Site Status
                    </div>

                    <form method="post" action="{{route('admin.web.status.update')}}" class="card-body ">
                        @csrf
                        <div class="card rounded-0">
                            <div
                                class="card-header d-flex align-items-center rounded-0 py-2 bg_bodyc text-dark font-weight-bolder">
                                Site On/Off :
                                <div class="input-check px-2 mb-0 pb-0">
                                    <input type="radio" @checked($website_status->status==1) name="site_status" id="isSiteon" value="1">
                                    <label for="isSiteon" class="pb-0 mb-0 font-weight-bolder text-dark fs-2 ">ON</label>
                                    |
                                    <input  type="radio" @checked($website_status->status==0) name="site_status" id="isSiteoff" value="0">
                                    <label for="isSiteoff" class="pb-0 mb-0 font-weight-bolder fs-2 text-dark">OFF</label>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="custom_message" class="font-weight-bold fs-3 ">Custom Message: </label>
                                    <textarea name="message" id="custom_message" class="form-control" rows="8">{{$website_status->message}}</textarea>
                                    @error('message')
                                        <p class="text-danger"> {{$message}} </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                        </div>
                    </form>

                </div>
                <div class="card rounded-0 mt-4">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Conformation Email On/Off
                    </div>

                    <form method="post" action="{{route('admin.email.confirm.status.update')}}" class="card-body ">
                        @csrf
                        <div class=" d-flex align-items-center rounded-0 py-2  text-dark font-weight-bolder">
                            Conformation Email On/Off
                            <div class="input-check px-2 mb-0 pb-0">
                                <input @checked($website_detail->confirmation_email==1) type="radio" name="confirmation_email" id="isConfirmationEmailon"
                                    value="1">
                                <label for="isConfirmationEmailon"
                                    class="pb-0 mb-0 font-weight-bolder text-dark fs-2 ">ON</label> |
                                <input @checked($website_detail->confirmation_email==0) type="radio" name="confirmation_email" id="isConfirmationEmailoff"
                                    value="0">
                                <label for="isConfirmationEmailoff"
                                    class="pb-0 mb-0 font-weight-bolder fs-2 text-dark">OFF</label>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                        </div>
                    </form>

                </div>
                <div class="card rounded-0 mt-4">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Change Logo
                    </div>

                    <form method="post" action="{{route('admin.website.logo.update')}}" enctype="multipart/form-data" class="card-body ">
                        @csrf
                        <div class="form-group">
                            <label for="logo" class="font-weight-bold fs-3 ">Logo</label>
                            <input type="file" name="logo" class="form-control-file" id="logo">
                            @error('logo')
                                <p class="text-danger"> {{$message}} </p>
                            @enderror
                        </div>
                        <img src="{{asset('uploads/logo/'.$website_detail->logo)}}" style="height: 5rem;" alt="">
                        <div class="mt-3">
                            <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
@section('custom-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#editor').trumbowyg();;

        })
    </script>
@endsection
