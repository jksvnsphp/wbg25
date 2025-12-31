<?php

namespace App\Http\Controllers;

use App\Models\social_media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocialMediaController extends Controller
{
    //
    public function allSocialMedia()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $socialMedia = social_media::where('vendor_id', '=', $id)->first();
            return view('seller-vendor.business-socialmedia', compact('socialMedia'));
        } else {
            return redirect()->route('login');
        }
    }
    public function addSocialMedia(Request $request)
    {
        if (isset(auth()->user()->id)) {

            $id = auth()->user()->id;

            $validator = Validator::make(
                $request->all(),
                [
                    'isSkype' => ['nullable'],
                    'skype' => ['required_if:isSkype,on'],
                    'isLinkedIn' => ['nullable'],
                    'linkedin' => ['required_if:isLinkedIn,on'],
                    'isFacebook' => ['nullable'],
                    'facebook' => ['required_if:isFacebook,on'],
                    'isX' => ['nullable'],
                    'x' => ['required_if:isX,on'],
                    'isInstagram' => ['nullable'],
                    'instagram' => ['required_if:isInstagram,on'],
                    'isYoutube' => ['nullable'],
                    'youtube' => ['required_if:isYoutube,on'],
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Please check if you enable any social account than please fill id/url']);
            } else {
                $socialMedia = social_media::where('vendor_id', '=', $id)->first();
                if ($socialMedia) {
                    $socialMedia->isSkype = $request->isSkype == "on" ? 1 : 0;
                    $socialMedia->skype = $request->skype;
                    $socialMedia->isLinkedIn = $request->isLinkedIn == "on" ? 1 : 0;
                    $socialMedia->linkedin = $request->linkedin;
                    $socialMedia->isFacebook = $request->isFacebook == "on" ? 1 : 0;
                    $socialMedia->facebook = $request->facebook;
                    $socialMedia->isX = $request->isX == "on" ? 1 : 0;
                    $socialMedia->x = $request->x;
                    $socialMedia->isInstagram = $request->isInstagram == "on" ? 1 : 0;
                    $socialMedia->instagram = $request->instagram;
                    $socialMedia->isYoutube = $request->isYoutube == "on" ? 1 : 0;
                    $socialMedia->youtube = $request->youtube;
                    $socialMedia->save();
                } else {
                    $socialMedia = new social_media();
                    $socialMedia->vendor_id = $id;
                    $socialMedia->isSkype = $request->isSkype == "on" ? 1 : 0;
                    $socialMedia->skype = $request->skype;
                    $socialMedia->isLinkedIn = $request->isLinkedIn == "on" ? 1 : 0;
                    $socialMedia->linkedin = $request->linkedin;
                    $socialMedia->isFacebook = $request->isFacebook == "on" ? 1 : 0;
                    $socialMedia->facebook = $request->facebook;
                    $socialMedia->isX = $request->isX == "on" ? 1 : 0;
                    $socialMedia->x = $request->x;
                    $socialMedia->isInstagram = $request->isInstagram == "on" ? 1 : 0;
                    $socialMedia->instagram = $request->instagram;
                    $socialMedia->isYoutube = $request->isYoutube == "on" ? 1 : 0;
                    $socialMedia->youtube = $request->youtube;
                    $socialMedia->save();
                }

                session()->flash('success', 'Congratulation, Your social media has updated successfully and is showing online now!');
                return redirect()->route('seller.success.gallery');
            }
        } else {
            return redirect()->route('login');
        }
    }
}
