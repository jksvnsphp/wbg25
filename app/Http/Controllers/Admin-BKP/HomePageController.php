<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use App\Models\HomeInfo;
use Illuminate\Support\Facades\Validator;

class HomePageController extends Controller
{
    public function index()
    {
        $homeBanner = HomeBanner::latest()->first();
        $homeInfos = HomeInfo::get();
        $data = ['banner' => $homeBanner, 'infos' => $homeInfos];
        return view('admin.website-setting.home-setting', $data);
    }

    public function uploadBanners(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'banner1' => ['nullable', 'image'],
                'banner2' => ['nullable', 'image'],
                'banner3' => ['nullable', 'image'],
                'banner4' => ['nullable', 'image'],
                'banner5' => ['nullable', 'image'],
                'banner1_text' => ['nullable', 'string'],
                'banner2_text' => ['nullable', 'string'],
                'banner3_text' => ['nullable', 'string'],
                'banner4_text' => ['nullable', 'string'],
                'banner5_text' => ['nullable', 'string'],
                'banner1_link' => ['nullable', 'url'],
                'banner2_link' => ['nullable', 'url'],
                'banner3_link' => ['nullable', 'url'],
                'banner4_link' => ['nullable', 'url'],
                'banner5_link' => ['nullable', 'url'],
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Validation failed!']);
        } else {
            $homeBanner = HomeBanner::where('id', 1)->first();
            if ($homeBanner) {
                $homeBanner->banner1_text = $request->banner1_text;
                $homeBanner->banner2_text = $request->banner2_text;
                $homeBanner->banner3_text = $request->banner3_text;
                $homeBanner->banner4_text = $request->banner4_text;
                $homeBanner->banner5_text = $request->banner5_text;
                $homeBanner->banner1_link = $request->banner1_link;
                $homeBanner->banner2_link = $request->banner2_link;
                $homeBanner->banner3_link = $request->banner3_link;
                $homeBanner->banner4_link = $request->banner4_link;
                $homeBanner->banner5_link = $request->banner5_link;

                if ($request->hasFile('banner1')) {
                    $file = $request->file('banner1');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('wbg_') . '.' . $ext;
                    $file->move(public_path('/uploads/home_banners'), $fileName);
                    $homeBanner->banner1 = $fileName;
                }
                if ($request->hasFile('banner2')) {
                    $file = $request->file('banner2');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('wbg_') . '.' . $ext;
                    $file->move(public_path('/uploads/home_banners'), $fileName);
                    $homeBanner->banner2 = $fileName;
                }
                if ($request->hasFile('banner3')) {
                    $file = $request->file('banner3');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('wbg_') . '.' . $ext;
                    $file->move(public_path('/uploads/home_banners'), $fileName);
                    $homeBanner->banner3 = $fileName;
                }
                if ($request->hasFile('banner4')) {
                    $file = $request->file('banner4');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('wbg_') . '.' . $ext;
                    $file->move(public_path('/uploads/home_banners'), $fileName);
                    $homeBanner->banner4 = $fileName;
                }
                if ($request->hasFile('banner5')) {
                    $file = $request->file('banner5');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('wbg_') . '.' . $ext;
                    $file->move(public_path('/uploads/home_banners'), $fileName);
                    $homeBanner->banner5 = $fileName;
                }

                $homeBanner->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully save your changes!']);
            } else {
                $homeBanner = new HomeBanner();
                $homeBanner->banner1_text = $request->banner1_text;
                $homeBanner->banner2_text = $request->banner2_text;
                $homeBanner->banner3_text = $request->banner3_text;
                $homeBanner->banner4_text = $request->banner4_text;
                $homeBanner->banner5_text = $request->banner5_text;
                $homeBanner->banner1_link = $request->banner1_link;
                $homeBanner->banner2_link = $request->banner2_link;
                $homeBanner->banner3_link = $request->banner3_link;
                $homeBanner->banner4_link = $request->banner4_link;
                $homeBanner->banner5_link = $request->banner5_link;

                if ($request->hasFile('banner1')) {
                    $file = $request->file('banner1');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('wbg_') . '.' . $ext;
                    $file->move(public_path('/uploads/home_banners'), $fileName);
                    $homeBanner->banner1 = $fileName;
                }
                if ($request->hasFile('banner2')) {
                    $file = $request->file('banner2');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('wbg_') . '.' . $ext;
                    $file->move(public_path('/uploads/home_banners'), $fileName);
                    $homeBanner->banner2 = $fileName;
                }
                if ($request->hasFile('banner3')) {
                    $file = $request->file('banner3');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('wbg_') . '.' . $ext;
                    $file->move(public_path('/uploads/home_banners'), $fileName);
                    $homeBanner->banner3 = $fileName;
                }
                if ($request->hasFile('banner4')) {
                    $file = $request->file('banner4');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('wbg_') . '.' . $ext;
                    $file->move(public_path('/uploads/home_banners'), $fileName);
                    $homeBanner->banner4 = $fileName;
                }
                if ($request->hasFile('banner5')) {
                    $file = $request->file('banner5');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('wbg_') . '.' . $ext;
                    $file->move(public_path('/uploads/home_banners'), $fileName);
                    $homeBanner->banner5 = $fileName;
                }

                $homeBanner->save();


                return back()->with(['alert-type' => 'success', 'message' => 'Successfully save your changes!']);
            }
        }
    }

    public function updateHomeTopInfo(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'image' => 'nullable|image',
                'title' => 'nullable|string',
                'sub_title' => 'nullable|string',
                'detail' => 'nullable|string',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->with(['alert-type' => 'error', 'message' => 'Validation failed!']);
        } else {
            $homeTopInfo = HomeInfo::first();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $fileName = uniqid('wbg_') . '.' . $ext;
                $file->move(public_path('/uploads/home_banners'), $fileName);
                $homeTopInfo->image = $fileName;
            }
            $homeTopInfo->title = $request->title;
            $homeTopInfo->sub_title = $request->sub_title;
            $homeTopInfo->content = $request->detail;
            $homeTopInfo->save();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully save your changes']);
        }
    }
    public function updateHomeInfo(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:home_infos,id',
                'image' => 'nullable|image',
                'title' => 'nullable|string',
                'sub_title' => 'nullable|string',
                'detail' => 'nullable|string',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->with(['alert-type' => 'error', 'message' => 'Validation failed!']);
        } else {
            $homeTopInfo = HomeInfo::where('id', $request->id)->first();
            if ($homeTopInfo) {

                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('wbg_') . '.' . $ext;
                    $file->move(public_path('/uploads/home_banners'), $fileName);
                    $homeTopInfo->image = $fileName;
                }
                $homeTopInfo->title = $request->title;
                $homeTopInfo->sub_title = $request->sub_title;
                $homeTopInfo->content = $request->detail;
                $homeTopInfo->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully save your changes']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Unable to update']);
            }
        }
    }
    public function editHomeInfo($id)
    {
        $info = HomeInfo::find($id);
        if ($info) {
            return view('admin.website-setting.edit_home_info', compact('info'));
        } else {
            return back()->with(['alert-type' => 'warning', 'message' => 'This info is no more.']);
        }
    }
}
