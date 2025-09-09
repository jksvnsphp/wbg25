<?php

namespace App\Http\Controllers;

use App\Models\cities;
use App\Models\countries;
use App\Models\states;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    //
    public function AllCountries()
    {
        $countries = countries::orderBy('name','ASC')->get();
        return response()->json($countries);
    }
    public function AllStates(Request $request)
    {
        $countryId = $request->input('country_id');

        // Fetch states based on the country ID
        $states = states::where('country_id', $countryId)->orderBy('name','ASC')->get();

        // Return states as JSON response
        return response()->json($states);
    }
    public function AllCities(Request $request)
    {
        $stateId = $request->input('state_id');

        // Fetch states based on the country ID
        $cities = cities::where('state_id', $stateId)->orderBy('name','ASC')->get();

        // Return cities as JSON response
        return response()->json($cities);
    }
}
