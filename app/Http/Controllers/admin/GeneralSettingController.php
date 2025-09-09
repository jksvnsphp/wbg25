<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\googleSetting;
use App\Models\PaymentMethods;
use App\Models\SitesDetails;
use App\Models\smtpmail;
use App\Models\WebsiteSocialLink;
use App\Models\websiteStatus;
use Illuminate\Support\Facades\File;
use DateTimeZone;
use Illuminate\Support\Facades\Validator;

class GeneralSettingController extends Controller
{
    //
    public function index()
    {
        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        $website_detail = SitesDetails::latest()->first();
        $paypal = PaymentMethods::latest()->first();
        $google_setting = googleSetting::latest()->first();
        $smtp = smtpmail::latest()->first();
        $social_link = WebsiteSocialLink::latest()->first();
        $website_status = websiteStatus::latest()->first();
        return view('admin.website-setting.general-setting', compact('timezones', 'website_detail', 'paypal', 'google_setting', 'smtp', 'social_link', 'website_status'));
    }

    public function updateWebsiteDetail(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'company_name' => 'required|string',
                'company_address' => 'required|string',
                'phone' => 'required',
                'mobile' => 'nullable',
                'email' => 'required|email',
                'support_email' => 'nullable|email',
                'webmaster_email' => 'nullable|email',
                'page_row' => 'required|numeric|min:10',
                'company_timezone' => 'required|string',
                'auto_approval' => 'required|numeric',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Validation failed!']);
        } else {
            $sites_detail = SitesDetails::where('id', 1)->first();
            if (!empty($sites_detail)) {
                $sites_detail->company_name = $request->company_name;
                $sites_detail->company_address = $request->company_address;
                $sites_detail->phone = $request->phone;
                $sites_detail->mobile = $request->mobile;
                $sites_detail->email = $request->email;
                $sites_detail->support_email = $request->support_email;
                $sites_detail->webmaster_email = $request->webmaster_email;
                $sites_detail->page_row = $request->page_row;
                $sites_detail->timezone = $request->company_timezone;
                $sites_detail->auto_approval = $request->auto_approval;
                $sites_detail->save();

                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update website details']);
            } else {
                $sites_detail = new SitesDetails();
                $sites_detail->company_name = $request->company_name;
                $sites_detail->company_address = $request->company_address;
                $sites_detail->phone = $request->phone;
                $sites_detail->mobile = $request->mobile;
                $sites_detail->email = $request->email;
                $sites_detail->support_email = $request->support_email;
                $sites_detail->webmaster_email = $request->webmaster_email;
                $sites_detail->page_row = $request->page_row;
                $sites_detail->timezone = $request->company_timezone;
                $sites_detail->auto_approval = $request->auto_approval;
                $sites_detail->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update website details']);
            }
        }
    }
    public function updatePayPal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|numeric',
            'email' => 'nullable|email',
            'bank_detail' => 'nullable'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Validation failed!']);
        } else {
            $paymentMethod = PaymentMethods::where('id', 1)->first();
            if (!empty($paymentMethod)) {
                $paymentMethod->status = $request->status;
                $paymentMethod->email = $request->email;
                $paymentMethod->bank_detail = $request->bank_detail;
                $paymentMethod->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update payment detail']);
            } else {
                $paymentMethod = new PaymentMethods();
                $paymentMethod->status = $request->status;
                $paymentMethod->email = $request->email;
                $paymentMethod->bank_detail = $request->bank_detail;
                $paymentMethod->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update payment detail']);
            }
        }
    }
    public function socialLinkSetting(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'facebook_url' => 'nullable|url',
            'isFacebook' => 'required|numeric',
            'twitter_url' => 'nullable|url',
            'isTwitter' => 'required|numeric',
            'google_plus_url' => 'nullable|url',
            'isGoogleplus' => 'required|numeric',
            'pinterest_url' => 'nullable|url',
            'isPinterest' => 'required|numeric',
            'youtube_url' => 'nullable|url',
            'isYoutube' => 'required|numeric',
            'linkedin_url' => 'nullable|url',
            'isLinkedin' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Validation failed']);
        } else {
            $socialLink = WebsiteSocialLink::where('id', 1)->first();
            if (!empty($socialLink)) {
                $socialLink->facebook = $request->facebook_url;
                $socialLink->isFacebook = $request->isFacebook;
                $socialLink->twitter = $request->twitter_url;
                $socialLink->isTwitter = $request->isTwitter;
                $socialLink->googleplus = $request->google_plus_url;
                $socialLink->isGoogleplus = $request->isGoogleplus;
                $socialLink->pinterest = $request->pinterest_url;
                $socialLink->isPinterest = $request->isPinterest;
                $socialLink->youtube = $request->youtube_url;
                $socialLink->isYoutube = $request->isYoutube;
                $socialLink->linkedin = $request->linkedin_url;
                $socialLink->isLinkedin = $request->isLinkedin;
                $socialLink->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update social link']);
            } else {
                $socialLink = new WebsiteSocialLink();
                $socialLink->facebook = $request->facebook_url;
                $socialLink->isFacebook = $request->isFacebook;
                $socialLink->twitter = $request->twitter_url;
                $socialLink->isTwitter = $request->isTwitter;
                $socialLink->googleplus = $request->google_plus_url;
                $socialLink->isGoogleplus = $request->isGoogleplus;
                $socialLink->pinterest = $request->pinterest_url;
                $socialLink->isPinterest = $request->isPinterest;
                $socialLink->youtube = $request->youtube_url;
                $socialLink->isYoutube = $request->isYoutube;
                $socialLink->linkedin = $request->linkedin_url;
                $socialLink->isLinkedin = $request->isLinkedin;
                $socialLink->save();

                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update social link']);
            }
        }
    }

    public function smtpSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'isMail' => 'required|numeric',
            'host' => 'required',
            'port' => 'required|numeric',
            'secure' => 'required|in:ssl,tls',
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            $smtpSetting = smtpmail::where('id', 1)->first();
            if ($smtpSetting) {
                $smtpSetting->status = $request->isMail;
                $smtpSetting->host = $request->host;
                $smtpSetting->port = $request->port;
                $smtpSetting->secure = $request->secure;
                $smtpSetting->username = $request->username;
                $smtpSetting->password = $request->password;
                $smtpSetting->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update smtp setting']);
            } else {
                $smtpSetting = new smtpmail();
                $smtpSetting->status = $request->isMail;
                $smtpSetting->host = $request->host;
                $smtpSetting->port = $request->port;
                $smtpSetting->secure = $request->secure;
                $smtpSetting->username = $request->username;
                $smtpSetting->password = $request->password;
                $smtpSetting->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update smtp setting']);
            }
        }
    }

    public function googleSetting(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'google_map_api_key' => 'required|string',
            'google_webmaster_code' => 'nullable|string',
            'google_analytics_code' => 'nullable|string',
            'google_adsens_id' => 'nullable|string',
            'copyright_info' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            $googleSetting = googleSetting::where('id', 1)->first();
            if ($googleSetting) {
                $googleSetting->google_map_api_key = $request->google_map_api_key;
                $googleSetting->google_webmaster_code = $request->google_webmaster_code;
                $googleSetting->google_analytics_code = $request->google_analytics_code;
                $googleSetting->google_adsens_id = $request->google_adsens_id;
                $googleSetting->copyright_info = $request->copyright_info;
                $googleSetting->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update google setting']);
            } else {
                $googleSetting = new googleSetting();
                $googleSetting->google_map_api_key = $request->google_map_api_key;
                $googleSetting->google_webmaster_code = $request->google_webmaster_code;
                $googleSetting->google_analytics_code = $request->google_analytics_code;
                $googleSetting->google_adsens_id = $request->google_adsens_id;
                $googleSetting->copyright_info = $request->copyright_info;
                $googleSetting->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update google setting']);
            }
        }
    }

    public function webstatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_status' => 'required|in:1,0',
            'message' => 'required_if:site_status,1',
        ]);
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            $webstatus = websiteStatus::where('id', 1)->first();
            if ($webstatus) {
                $webstatus->status = $request->site_status;
                $webstatus->message = $request->message;
                $webstatus->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update website status']);
            } else {
                $webstatus = new websiteStatus();
                $webstatus->status = $request->site_status;
                $webstatus->message = $request->message;
                $webstatus->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update website status']);
            }
        }
    }

    public function emailConfimation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'confirmation_email' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Validation failed!']);
        } else {
            $sites_detail = SitesDetails::where('id', 1)->first();
            if (!empty($sites_detail)) {
                $sites_detail->confirmation_email = $request->confirmation_email;
                $sites_detail->save();

                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update confirmation email status']);
            } else {
                $sites_detail = new SitesDetails();
                $sites_detail->confirmation_email = $request->confirmation_email;
                $sites_detail->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update confirmation email status']);
            }
        }
    }
    public function websiteLogo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logo' => 'required|image'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Validation failed!']);
        } else {
            $sites_detail = SitesDetails::where('id', 1)->first();
            if (!empty($sites_detail)) {
                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('logo_') . '.' . $ext;
                    $file->move(public_path('/uploads/logo'), $fileName);
                    if ($sites_detail->logo != '') {
                        $oldFile = public_path('/uploads/logo/' . $sites_detail->logo);
                        if (File::exists($oldFile)) {
                            File::delete($oldFile);
                        }
                    }
                    $sites_detail->logo = $fileName;
                    $sites_detail->save();
                }

                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update website logo']);
            } else {
                $sites_detail = new SitesDetails();
                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('logo_') . '.' . $ext;
                    $file->move(public_path('/uploads/logo'), $fileName);
                    if ($sites_detail->logo != '') {
                        $oldFile = public_path('/uploads/logo/' . $sites_detail->logo);
                        if (File::exists($oldFile)) {
                            File::delete($oldFile);
                        }
                    }
                    $sites_detail->logo = $fileName;
                    $sites_detail->save();
                }
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update website logo']);
            }
        }
    }
}
