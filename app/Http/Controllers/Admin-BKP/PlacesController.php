<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GooglePlacesService;

class PlacesController extends Controller
{
    //
    protected $googlePlacesService;

    public function __construct(GooglePlacesService $googlePlacesService)
    {
        $this->googlePlacesService = $googlePlacesService;
    }

    public function index(Request $request)
    {
        $state=$request->state;
        $places = $this->googlePlacesService->getCitiesTowns($state);
        
        return response()->json($places);
    }
}
