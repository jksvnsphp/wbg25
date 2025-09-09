<?php

namespace App\Http\Middleware;

use App\Models\packageService;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPackageService
{

    public function handle(Request $request, Closure $next, $requiredService): Response
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with(['alert-type' => 'warning', 'message' => 'Please login first!']);
        }
        $userData = User::where('id', $user->id)->with('sellerPackageOne.package')->first();
        $sellerPackage = $userData->sellerPackageOne;
        if (!$sellerPackage || Carbon::parse($sellerPackage->expire_at)->isPast()) {
            if ($user->account_type == "seller") {
                session()->flash('info-message', 'Your membership package has been expired!');
                session()->flash('info-content', 'If you want to access this page. Please upgrade your membership package!');
                return redirect()->route('seller.upgrade.limit')->with(['alert-type' => 'warning', 'message' => 'Your membership package has been expired!']);
            }
        }
        $service =  packageService::where('serviceName', $requiredService)->first();
        $userServices = $service ?? '';
        $packageType = $sellerPackage->package->type ?? '';
        $isPackageService = $userServices[$packageType] ?? 0;
        // dd($packageType);
        if (!empty($requiredService) && isset($packageType)) {
            if ($isPackageService) {
                return $next($request);
            }
            if ($user->account_type == "seller") {
                session()->flash('info-message', 'Your membership package is not offer this service!');
                session()->flash('info-content', 'If you want to access this service page. Please upgrade your membership package!');
                return redirect()->route('seller.upgrade.limit')->with(['alert-type' => 'warning', 'message' => 'You are not able to access this page!']);
            }
        }

        return $next($request);
    }
}
