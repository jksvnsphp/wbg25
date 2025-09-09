<?php

namespace App\Http\Controllers\admin;

use App\Models\cities;
use App\Models\countries;
use App\Models\states;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    //
    public function AllCountries()
    {
        $countries = countries::orderBy('name', 'ASC')->withCount(['states'])->get();

        return view('admin.location-management', compact('countries'));
    }
    public function AllStates($countryId)
    {

        $states = states::where('country_id', $countryId)->with('country')->withCount('cities')->orderBy('name', 'ASC')->get();
        $data = ['states' => $states, 'country_id' => $countryId];

        return view('admin.show-states', $data);
    }
    public function AllCities($stateId)
    {

        $state = states::where('id', $stateId)->first();
        $country_id = $state->country_id;
        $cities = cities::where('state_id', $stateId)->with('state.country')->orderBy('name', 'ASC')->get();
        $data = ['cities' => $cities, 'country_id' => $country_id, 'state_id' => $stateId];
        return view('admin.show-cities', $data);
    }

    public function AddCountry(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'country_name' => ['required', 'string', 'unique:countries,name'],
                'capital' => ['nullable', 'string', 'unique:countries,capital'],
                'currency_symbol' => ['required', 'string'],
                'currency_name' => ['required', 'string'],
                'currency' => ['required', 'string'],
                'image' => ['required', 'image', 'mimes:jpg,jpeg,png,svg'],
                'country_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg'],

            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            $country = new countries();
            $country->name = $request->country_name;
            $country->capital = $request->capital;
            $country->currency_symbol = $request->currency_symbol;
            $country->currency_name = $request->currency_name;
            $country->currency = $request->currency;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $fileName = uniqid('country_') . '.' . $ext;
                $file->move(public_path('/uploads/country_flags'), $fileName);
                $country->image = $fileName;
            }
            if ($request->hasFile('country_image')) {
                $file = $request->file('country_image');
                $ext = $file->getClientOriginalExtension();
                $fileName = uniqid('country_banner_') . '.' . $ext;

                $file->move(public_path('/uploads/country_banners/'), $fileName);
                $country->banner_image = $fileName;
            }
            $country->save();
            return back()->with(['alert-type' => 'success', 'message' => 'Country Added Successfully']);
        }
    }

    public function DeleteCountry($countryId)
    {
        $country = countries::where('id', $countryId)->first();
        if (!empty($country)) {
            if ($country->image != '') {
                $oldfile = public_path('/uploads/country_flags/' . $country->image);
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }
            if ($country->banner_image != '') {
                $oldfile = public_path('/uploads/country_banners/' . $country->banner_image);
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }
            $country->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Country not found!']);
        }
    }
    public function DeleteState($stateid)
    {
        $state = states::where('id', $stateid)->first();
        if (!empty($state)) {
            if ($state->image != '') {
                $oldfile = public_path('/uploads/state_banners/' . $state->image);
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }

            $state->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'State not found!']);
        }
    }
    public function DeleteCity($cityid)
    {
        $city = cities::where('id', $cityid)->first();
        if (!empty($city)) {
            if ($city->image != '') {
                $oldfile = public_path('/uploads/city_banners/' . $city->image);
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }

            $city->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'City not found!']);
        }
    }
    public function EditCountry($countryId)
    {
        $country = countries::where('id', $countryId)->first();
        if (!empty($country)) {
            return view('admin.edit-country', compact('country'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Country not found!']);
        }
    }
    public function EditState($stateid)
    {
        $state = states::where('id', $stateid)->first();
        if (!empty($state)) {
            return view('admin.edit-state', compact('state'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'State not found!']);
        }
    }
    public function EditCity($cityid)
    {
        $city = cities::where('id', $cityid)->first();
        if (!empty($city)) {
            return view('admin.edit-city', compact('city'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'city not found!']);
        }
    }
    public function UpdateCountry(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => ['required', 'numeric', 'exists:countries,id'],
                'country_name' => ['required', 'string', 'unique:countries,name,' . $request->id],
                'capital' => ['nullable', 'string', 'unique:countries,capital,' . $request->id],
                'currency_symbol' => ['required', 'string'],
                'currency_name' => ['required', 'string'],
                'currency' => ['required', 'string'],
                'image' => ['required', 'image', 'mimes:jpg,jpeg,png,svg'],
                'country_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg'],

            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            $country = countries::where('id', $request->id)->first();
            $country->name = $request->country_name;
            $country->capital = $request->capital;
            $country->currency_symbol = $request->currency_symbol;
            $country->currency_name = $request->currency_name;
            $country->currency = $request->currency;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $fileName = uniqid('country_') . '.' . $ext;
                $file->move(public_path('/uploads/country_flags'), $fileName);
                if ($country->image != '') {
                    $oldFile = public_path('/uploads/country_flags/' . $country->image);
                    if (File::exists($oldFile)) {
                        File::delete($oldFile);
                    }
                }
                $country->image = $fileName;
            }
            if ($request->hasFile('country_image')) {
                $file = $request->file('country_image');
                $ext = $file->getClientOriginalExtension();
                $fileName = uniqid('country_banner_') . '.' . $ext;

                $file->move(public_path('/uploads/country_banners/'), $fileName);
                if ($country->banner_image != '') {
                    $oldFile = public_path('/uploads/country_banners/' . $country->banner_image);
                    if (File::exists($oldFile)) {
                        File::delete($oldFile);
                    }
                }
                $country->banner_image = $fileName;
            }
            $country->save();
            return back()->with(['alert-type' => 'success', 'message' => 'Country Added Successfully']);
        }
    }





    // states manage
    public function AddStates(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'state_name' => ['required', 'string', 'unique:states,name'],
                'image' => ['required', 'image', 'mimes:jpg,jpeg,png,svg'],
                'country_id' => ['required', 'numeric', 'exists:countries,id'],
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            $state = new states();
            $state->name = $request->state_name;
            $state->country_id = $request->country_id;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $fileName = uniqid('state_') . '.' . $ext;
                $file->move(public_path('/uploads/state_banners'), $fileName);
                $state->image = $fileName;
            }

            $state->save();
            return back()->with(['alert-type' => 'success', 'message' => 'State Added Successfully']);
        }
    }
    public function AddCity(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'city_name' => ['required', 'string'],
                'image' => ['required', 'image', 'mimes:jpg,jpeg,png,svg'],
                'country_id' => ['required', 'numeric', 'exists:countries,id'],
                'state_id' => ['required', 'numeric', 'exists:states,id'],
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            $city = new cities();
            $city->name = $request->city_name;
            $city->country_id = $request->country_id;
            $city->state_id = $request->state_id;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $fileName = uniqid('city_') . '.' . $ext;
                $file->move(public_path('/uploads/city_banners'), $fileName);
                $city->image = $fileName;
            }

            $city->save();
            return back()->with(['alert-type' => 'success', 'message' => 'City Added Successfully']);
        }
    }
    public function UpdateState(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => ['required', 'numeric', 'exists:states,id'],
                'state_name' => ['required', 'string', 'unique:states,name,' . $request->id],
                'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg']
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            $state = states::where('id', $request->id)->first();
            $state->name = $request->state_name;


            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $fileName = uniqid('state_') . '.' . $ext;
                $file->move(public_path('/uploads/state_banners'), $fileName);
                if ($state->image != '') {
                    $oldFile = public_path('/uploads/state_banners/' . $state->image);
                    if (File::exists($oldFile)) {
                        File::delete($oldFile);
                    }
                }
                $state->image = $fileName;
            }

            $state->save();
            return back()->with(['alert-type' => 'success', 'message' => 'State Updated Successfully']);
        }
    }
    public function UpdateCity(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => ['required', 'numeric', 'exists:cities,id'],
                'city_name' => ['required', 'string'],
                'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg']
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            $city = cities::where('id', $request->id)->first();
            $city->name = $request->city_name;


            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $fileName = uniqid('city_') . '.' . $ext;
                $file->move(public_path('/uploads/city_banners'), $fileName);
                if ($city->image != '') {
                    $oldFile = public_path('/uploads/city_banners/' . $city->image);
                    if (File::exists($oldFile)) {
                        File::delete($oldFile);
                    }
                }
                $city->image = $fileName;
            }

            $city->save();
            return back()->with(['alert-type' => 'success', 'message' => 'City Updated Successfully']);
        }
    }



    public function updateStatus(Request $request)
    {
        $country = countries::findOrFail($request->id);
        $country->status = $request->status;
        $country->save();
        return response()->json(['success' => true]);
    }
}
