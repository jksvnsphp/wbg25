<?php

use App\Models\business_profile_symbol;
use App\Models\company;
use App\Models\CounterOfferQuotation;
use App\Models\CounterOfferTender;
use App\Models\countries;
use App\Models\CustomeCategory;
use App\Models\inbox;
use App\Models\memberPackage;
use App\Models\OfferQuotation;
use App\Models\OfferTender;
use App\Models\Order;
use App\Models\packageService;
use App\Models\Quotation;
use App\Models\seller_package;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\DynamicMail;

if (! function_exists('generateSlug')) {
    function generateSlug($string)
    {
        return Str::slug($string, '-');
    }
}

if (! function_exists('formatDate')) {
    function formatDate($date, $format = 'd-m-Y')
    {
        return \Carbon\Carbon::parse($date)->format($format);
    }
}
if (! function_exists('getBusinessProfileSymbol')) {
    function getBusinessProfileSymbol($id)
    {
        $symbol = business_profile_symbol::find($id);
        return $symbol ? $symbol->symbol : null;
    }
}
if (! function_exists('getCustomCategoryName')) {
    function getCustomCategoryName($id)
    {
        $category = CustomeCategory::find($id);
        return $category ? $category->name : null;
    }
}

if (! function_exists('getPackageServiceName')) {
    function getPackageServiceName($id)
    {
        $service = packageService::find($id);
        return $service ? $service->name : null;
    }
}
if (! function_exists('getSellerPackageName')) {
    function getSellerPackageName($id)
    {
        $package = seller_package::find($id);
        return $package ? $package->package_name : null;
    }
}
if (! function_exists('getMemberPackageName')) {
    function getMemberPackageName($id)
    {
        $package = memberPackage::find($id);
        // echo "<pre>";
        // print_r($package);die;
        return $package ? $package->name : null;
    }
}
if (! function_exists('getCompanyName')) {
    function getCompanyName($id)
    {
        $company = company::find($id);
        return $company ? $company->name : null;
    }
}
if (! function_exists('getCountryName')) {
    function getCountryName($id)
    {
        $country = countries::find($id);
        return $country ? $country->name : null;
    }
}
if (! function_exists('getUserName')) {
    function getUserName($id)
    {
        //echo "ID=>>>".$id; die;
        $user = User::find($id);
        return $user ? $user->first_name . " " . $user->last_name : null;
    }
}

if (! function_exists('getUserEmail')) {
    function getUserEmail($id)
    {
        $user = User::find($id);
        return $user ? $user->email : null;
    }
}
if (! function_exists('getUserDataByEmail')) {
    function getUserDataByEmail($email)
    {
        $user = User::where('email', $email)->first();
        return $user ? $user : null;
    }
}

if (! function_exists('getUserPhone')) {
    function getUserPhone($id)
    {
        $user = User::find($id);
        return $user ? $user->phone : null;
    }
}
if (! function_exists('getUserCountry')) {
    function getUserCountry($id)
    {
        $user = User::find($id);
        if ($user && $user->country) {
            $country = countries::find($user->country);
            return $country ? $country->name : null;
        }
        return null;
    }
}
if (! function_exists('getUserCompany')) {
    function getUserCompany($id)
    {
        $user = User::find($id);
        if ($user && $user->account_type == 'seller') {
            $company = company::where('vendor_id', $user->id)->first();
            return $company ? $company->name : null;
        }
        return null;
    }
}
if (! function_exists('getUserBusinessProfile')) {
    function getUserBusinessProfile($id)
    {
        $user = User::find($id);
        if ($user && $user->business_profile) {
            $profile = business_profile_symbol::find($user->business_profile);
            return $profile ? $profile->symbol : null;
        }
        return null;
    }
}
if (! function_exists('getUserPackage')) {
    function getUserPackage($id)
    {
        $user = User::find($id);
        if ($user && $user->seller_package) {
            $package = seller_package::find($user->seller_package);

            return $package ? $package->name : 'Free';
        }
        return 'Free';
    }
}
if (! function_exists('getPackageServices')) {
    function getPackageServices($id)
    {
        $package = seller_package::find($id);
        if ($package && $package->services) {
            $serviceIds = explode(',', $package->services);
            $services = packageService::whereIn('id', $serviceIds)->pluck('name')->toArray();
            return implode(', ', $services);
        }
        return null;
    }
}

if (! function_exists('timeAgo')) {
    function timeAgo($timestamp)
    {
        return \Carbon\Carbon::parse($timestamp)->diffForHumans();
    }
}
if (! function_exists('getQuotationStatus')) {
    function getQuotationStatus($status)
    {
        switch ($status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Accepted';
            case 2:
                return 'Declined';
            case 3:
                return 'Expired';
            default:
                return 'Unknown';
        }
    }
}
if (! function_exists('getTenderStatus')) {
    function getTenderStatus($status)
    {
        switch ($status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Accepted';
            case 2:
                return 'Declined';
            case 3:
                return 'Expired';
            default:
                return 'Unknown';
        }
    }
}
if (! function_exists('getOrderStatus')) {
    function getOrderStatus($status)
    {
        switch ($status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Processing';
            case 2:
                return 'Completed';
            case 3:
                return 'Cancelled';
            default:
                return 'Unknown';
        }
    }
}
if (! function_exists('getInboxStatus')) {
    function getInboxStatus($status)
    {
        switch ($status) {
            case 0:
                return 'Unread';
            case 1:
                return 'Read';
            default:
                return 'Unknown';
        }
    }
}
if (! function_exists('getPaymentStatus')) {
    function getPaymentStatus($status)
    {
        switch ($status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Completed';
            case 2:
                return 'Failed';
            case 3:
                return 'Cancelled';
            default:
                return 'Unknown';
        }
    }
}
if (! function_exists('getPaymentMethod')) {
    function getPaymentMethod($method)
    {
        switch ($method) {
            case 'paypal':
                return 'PayPal';
            case 'stripe':
                return 'Stripe';
            case 'bank_transfer':
                return 'Bank Transfer';
            case 'cash_on_delivery':
                return 'Cash on Delivery';
            default:
                return ucfirst($method);
        }
    }
}
if (! function_exists('calculateDiscountedPrice')) {
    function calculateDiscountedPrice($price, $discount, $type = 'percentage')
    {
        if ($type === 'percentage') {
            return $price - ($price * ($discount / 100));
        } elseif ($type === 'fixed') {
            return $price - $discount;
        }
        return $price;
    }
}
if (! function_exists('formatPrice')) {
    function formatPrice($amount, $currency = 'USD')
    {
        return number_format($amount, 2) . ' ' . strtoupper($currency);
    }
}
if (! function_exists('getPayPalClient')) {
    function getPayPalClient()
    {
        $paypal = new PayPalClient;
        $paypal->setApiCredentials(config('paypal'));
        $token = $paypal->getAccessToken();
        $paypal->setAccessToken($token);
        return $paypal;
    }
}
if (! function_exists('getStripeClient')) {
    function getStripeClient()
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        return new \Stripe\StripeClient(config('services.stripe.secret'));
    }
}
if (! function_exists('getUnreadMessagesCount')) {
    function getUnreadMessagesCount($userId)
    {
        return \App\Models\Message::where('receiver_id', $userId)
            ->where('status', 0)
            ->count();
    }
}
if (! function_exists('getNotificationsCount')) {
    function getNotificationsCount($userId)
    {
        return \App\Models\Notification::where('user_id', $userId)
            ->where('is_read', 0)
            ->count();
    }
}
if (! function_exists('getActiveUsersCount')) {
    function getActiveUsersCount()
    {
        return \App\Models\User::where('is_active', 1)->count();
    }
}
if (! function_exists('getActiveSellersCount')) {
    function getActiveSellersCount()
    {
        return \App\Models\User::where('is_active', 1)
            ->where('account_type', 'seller')
            ->count();
    }
}
if (! function_exists('getActiveBuyersCount')) {
    function getActiveBuyersCount()
    {
        return \App\Models\User::where('is_active', 1)
            ->where('account_type', 'buyer')
            ->count();
    }
}
if (! function_exists('getTotalOrdersCount')) {
    function getTotalOrdersCount()
    {
        return \App\Models\Order::count();
    }
}
if (! function_exists('getTotalRevenue')) {
    function getTotalRevenue()
    {
        return \App\Models\Order::where('status', 2) // Completed orders
            ->sum('total_amount');
    }
}
if (! function_exists('getTodayOrdersCount')) {
    function getTodayOrdersCount()
    {
        return \App\Models\Order::whereDate('created_at', Carbon::today())->count();
    }
}
if (! function_exists('getTodayRevenue')) {
    function getTodayRevenue()
    {
        return \App\Models\Order::whereDate('created_at', Carbon::today())
            ->where('status', 2) // Completed orders
            ->sum('total_amount');
    }
}
if (! function_exists('getMonthlyRevenue')) {
    function getMonthlyRevenue($month, $year)
    {
        return \App\Models\Order::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 2) // Completed orders
            ->sum('total_amount');
    }
}
if (! function_exists('getYearlyRevenue')) {
    function getYearlyRevenue($year)
    {
        return \App\Models\Order::whereYear('created_at', $year)
            ->where('status', 2) // Completed orders
            ->sum('total_amount');
    }
}
if (! function_exists('getTopSellingProducts')) {
    function getTopSellingProducts($limit = 5)
    {
        return \App\Models\OrderItem::select('product_id', \DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take($limit)
            ->with('product')
            ->get();
    }
}
if (! function_exists('getMostActiveSellers')) {
    function getMostActiveSellers($limit = 5)
    {
        return \App\Models\User::where('account_type', 'seller')
            ->withCount('orders')
            ->orderByDesc('orders_count')
            ->take($limit)
            ->get();
    }
}
if (! function_exists('getMostActiveBuyers')) {
    function getMostActiveBuyers($limit = 5)
    {
        return \App\Models\User::where('account_type', 'buyer')
            ->withCount('orders')
            ->orderByDesc('orders_count')
            ->take($limit)
            ->get();
    }
}
if (! function_exists('getRecentOrders')) {
    function getRecentOrders($limit = 5)
    {
        return \App\Models\Order::with('user')
            ->orderByDesc('created_at')
            ->take($limit)
            ->get();
    }
}
if (! function_exists('getRecentUsers')) {
    function getRecentUsers($limit = 5)
    {
        return \App\Models\User::orderByDesc('created_at')
            ->take($limit)
            ->get();
    }
}
if (! function_exists('getFileUrl')) {
    function getFileUrl($path)
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }
        return asset('storage/' . $path);
    }
}
if (! function_exists('getFilePath')) {
    function getFilePath($file)
    {
        return storage_path('app/public/' . $file);
    }
}
if (! function_exists('deleteFile')) {
    function deleteFile($file)
    {
        $filePath = getFilePath($file);
        if (File::exists($filePath)) {
            File::delete($filePath);
            return true;
        }
        return false;
    }
}
if (! function_exists('uploadFile')) {
    function uploadFile($file, $directory = 'uploads')
    {
        $path = $file->store($directory, 'public');
        return $path;
    }
}
if (! function_exists('resizeImage')) {
    function resizeImage($filePath, $width, $height)
    {
        $imageManager = new ImageManager();
        $image = $imageManager->make($filePath)->resize($width, $height);
        $image->save($filePath);
        return $filePath;
    }
}
if (! function_exists('generateRandomString')) {
    function generateRandomString($length = 10)
    {
        return Str::random($length);
    }
}
if (! function_exists('slugify')) {
    function slugify($text)
    {
        return Str::slug($text, '-');
    }
}
if (! function_exists('truncateString')) {
    function truncateString($string, $length = 100)
    {
        return Str::limit($string, $length);
    }
}
if (! function_exists('convertToJson')) {
    function convertToJson($data)
    {
        return json_encode($data);
    }
}
if (! function_exists('convertFromJson')) {
    function convertFromJson($json)
    {
        return json_decode($json, true);
    }
}
if (! function_exists('isAdmin')) {
    function isAdmin($user)
    {
        return $user && $user->role === 'admin';
    }
}
if (! function_exists('isSeller')) {
    function isSeller($user)
    {
        return $user && $user->account_type === 'seller';
    }
}
if (! function_exists('isBuyer')) {
    function isBuyer($user)
    {
        return $user && $user->account_type === 'buyer';
    }
}
if (! function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
if (! function_exists('getMimeType')) {
    function getMimeType($filePath)
    {
        return mime_content_type($filePath);
    }
}
if (! function_exists('isImage')) {
    function isImage($filePath)
    {
        $mimeType = getMimeType($filePath);
        return Str::startsWith($mimeType, 'image/');
    }
}
if (! function_exists('isVideo')) {
    function isVideo($filePath)
    {
        $mimeType = getMimeType($filePath);
        return Str::startsWith($mimeType, 'video/');
    }
}
if (! function_exists('isDocument')) {
    function isDocument($filePath)
    {
        $mimeType = getMimeType($filePath);
        $documentTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'text/plain'
        ];
        return in_array($mimeType, $documentTypes);
    }
}
if (! function_exists('getFileIcon')) {
    function getFileIcon($filePath)
    {
        if (isImage($filePath)) {
            return 'fa-file-image';
        } elseif (isVideo($filePath)) {
            return 'fa-file-video';
        } elseif (isDocument($filePath)) {
            return 'fa-file-alt';
        } else {
            return 'fa-file';
        }
    }
}
if (! function_exists('getFileExtension')) {
    function getFileExtension($filePath)
    {
        return pathinfo($filePath, PATHINFO_EXTENSION);
    }
}
if (! function_exists('getFileName')) {
    function getFileName($filePath)
    {
        return pathinfo($filePath, PATHINFO_FILENAME);
    }
}
if (! function_exists('getFullFileName')) {
    function getFullFileName($filePath)
    {
        return basename($filePath);
    }
}
if (! function_exists('getFileSize')) {
    function getFileSize($filePath)
    {
        return File::size($filePath);
    }
}
if (! function_exists('getFileLastModified')) {
    function getFileLastModified($filePath)
    {
        return File::lastModified($filePath);
    }
}
if (! function_exists('humanFileSize')) {
    function humanFileSize($filePath)
    {
        $size = getFileSize($filePath);
        return formatBytes($size);
    }
}
if (! function_exists('getFileUrlSafe')) {
    function getFileUrlSafe($path)
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }
        return asset('storage/' . ltrim($path, '/'));
    }
}
if (! function_exists('isValidImage')) {
    function isValidImage($file)
    {
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        return in_array($file->getMimeType(), $allowedMimeTypes);
    }
}
if (! function_exists('isValidVideo')) {
    function isValidVideo($file)
    {
        $allowedMimeTypes = ['video/mp4', 'video/avi', 'video/mov', 'video/wmv', 'video/flv', 'video/webm'];
        return in_array($file->getMimeType(), $allowedMimeTypes);
    }
}
if (! function_exists('isValidDocument')) {
    function isValidDocument($file)
    {
        $allowedMimeTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'text/plain'
        ];
        return in_array($file->getMimeType(), $allowedMimeTypes);
    }
}
if (! function_exists('isValidFile')) {
    function isValidFile($file)
    {
        $allowedMimeTypes = array_merge(
            ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
            ['video/mp4', 'video/avi', 'video/mov', 'video/wmv', 'video/flv', 'video/webm'],
            [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'text/plain'
            ]
        );
        return in_array($file->getMimeType(), $allowedMimeTypes);
    }
}
if (! function_exists('getFileType')) {
    function getFileType($filePath)
    {
        if (isImage($filePath)) {
            return 'image';
        } elseif (isVideo($filePath)) {
            return 'video';
        } elseif (isDocument($filePath)) {
            return 'document';
        } else {
            return 'other';
        }
    }
}
if (! function_exists('getFileTypeLabel')) {
    function getFileTypeLabel($filePath)
    {
        $type = getFileType($filePath);
        switch ($type) {
            case 'image':
                return 'Image';
            case 'video':
                return 'Video';
            case 'document':
                return 'Document';
            default:
                return 'Other';
        }
    }
}
if (! function_exists('getFileTypeBadge')) {
    function getFileTypeBadge($filePath)
    {
        $type = getFileType($filePath);
        switch ($type) {
            case 'image':
                return '<span class="badge badge-primary">Image</span>';
            case 'video':
                return '<span class="badge badge-success">Video</span>';
            case 'document':
                return '<span class="badge badge-info">Document</span>';
            default:
                return '<span class="badge badge-secondary">Other</span>';
        }
    }
}
if (! function_exists('getInitials')) {
    function getInitials($name)
    {
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper($word[0]);
        }
        return $initials;
    }
}
if (! function_exists('getGravatarUrl')) {
    function getGravatarUrl($email, $size = 100)
    {
        $hash = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/$hash?s=$size&d=identicon";
    }
}
if (! function_exists('getUserAvatar')) {
    function getUserAvatar($user)
    {
        if ($user->avatar) {
            return getFileUrlSafe($user->avatar);
        }
        return getGravatarUrl($user->email);
    }
}

if (! function_exists('formatPhoneNumber')) {
    function formatPhoneNumber($number, $countryCode = 'US')
    {
        try {
            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
            $phoneNumber = $phoneUtil->parse($number, $countryCode);
            if ($phoneUtil->isValidNumber($phoneNumber)) {
                return $phoneUtil->format($phoneNumber, \libphonenumber\PhoneNumberFormat::INTERNATIONAL);
            }
        } catch (\libphonenumber\NumberParseException $e) {
            return $number;
        }
        return $number;
    }
}
if (! function_exists('sendEmail')) {
    function sendEmail($to, $subject, $view, $data = [])
    {
        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }
}
if (! function_exists('sendSMS')) {
    function sendSMS($to, $message)
    {
        // Implement SMS sending logic using a service like Twilio, Nexmo, etc.
        // This is a placeholder function.
        return true;
    }
}
if (! function_exists('logActivity')) {
    function logActivity($userId, $action, $details = null)
    {
        \App\Models\ActivityLog::create([
            'user_id' => $userId,
            'action' => $action,
            'details' => $details,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);
    }
}
if (! function_exists('getActivityLogs')) {
    function getActivityLogs($userId = null, $limit = 50)
    {
        $query = \App\Models\ActivityLog::query();
        if ($userId) {
            $query->where('user_id', $userId);
        }
        return $query->orderByDesc('created_at')->take($limit)->get();
    }
}
if (! function_exists('clearActivityLogs')) {
    function clearActivityLogs($olderThanDays = 30)
    {
        $date = Carbon::now()->subDays($olderThanDays);
        return \App\Models\ActivityLog::where('created_at', '<', $date)->delete();
    }
}
if (! function_exists('getUserRole')) {
    function getUserRole($user)
    {
        return $user ? $user->role : null;
    }
}
if (! function_exists('hasRole')) {
    function hasRole($user, $role)
    {
        return $user && $user->role === $role;
    }
}
if (! function_exists('canAccess')) {
    function canAccess($user, $permission)
    {
        // Implement permission checking logic
        // This is a placeholder function.
        return true;
    }
}
if (! function_exists('generateRandomPassword')) {
    function generateRandomPassword($length = 10)
    {
        return Str::random($length);
    }
}
if (! function_exists('hashPassword')) {
    function hashPassword($password)
    {
        return bcrypt($password);
    }
}
if (! function_exists('verifyPassword')) {
    function verifyPassword($password, $hashedPassword)
    {
        return \Illuminate\Support\Facades\Hash::check($password, $hashedPassword);
    }
}
if (! function_exists('isDemoMode')) {
    function isDemoMode()
    {
        return config('app.demo_mode', false);
    }
}
if (! function_exists('preventDemoModeAction')) {
    function preventDemoModeAction()
    {
        if (isDemoMode()) {
            abort(403, 'Action not allowed in demo mode.');
        }
    }
}

if (! function_exists('getEnvironment')) {
    function getEnvironment()
    {
        return app()->environment();
    }
}
if (! function_exists('isProduction')) {
    function isProduction()
    {
        return app()->environment('production');
    }
}
if (! function_exists('isLocal')) {
    function isLocal()
    {
        return app()->environment('local');
    }
}
if (! function_exists('isStaging')) {
    function isStaging()
    {
        return app()->environment('staging');
    }
}
if (! function_exists('getAppVersion')) {
    function getAppVersion()
    {
        return config('app.version', '1.0.0');
    }
}
if (! function_exists('setLocale')) {
    function setLocale($locale)
    {
        if (in_array($locale, config('app.supported_locales'))) {
            session(['app_locale' => $locale]);
            app()->setLocale($locale);
        }
    }
}
if (! function_exists('getLocale')) {
    function getLocale()
    {
        return session('app_locale', config('app.locale'));
    }
}
if (! function_exists('translate')) {
    function translate($key, $replace = [], $locale = null)
    {
        return __($key, $replace, $locale);
    }
}
if (! function_exists('getCountriesList')) {
    function getCountriesList()
    {
        return \App\Models\countries::orderBy('name')->pluck('name', 'id')->toArray();
    }
}

if (! function_exists('getCertificatesList')) {
    function getCertificatesList($id)
    {

        return \App\Models\company_certificate::where('vendor_id', $id)->get();
    }
}

if (! function_exists('getStatesList')) {
    function getStatesList($countryId)
    {
        return \App\Models\states::where('country_id', $countryId)->orderBy('name')->pluck('name', 'id')->toArray();
    }
}

if (! function_exists('getStateName')) {
    function getStateName($stateId)
    {
        $state = \App\Models\states::find($stateId);
        return $state ? $state->name : null;
    }
}

if (! function_exists('getCountriesName')) {
    function getCountriesName($countryId)
    {
        $country = \App\Models\countries::find($countryId);
        return $country ? $country->name : null;
    }
}


if (! function_exists('getCitiesList')) {
    function getCitiesList($stateId)
    {
        return \App\Models\cities::where('state_id', $stateId)->orderBy('name')->pluck('name', 'id')->toArray();
    }
}
if (! function_exists('getTimeZonesList')) {
    function getTimeZonesList()
    {
        return \DateTimeZone::listIdentifiers();
    }
}
if (! function_exists('convertToTimeZone')) {
    function convertToTimeZone($dateTime, $timeZone)
    {
        $date = new \DateTime($dateTime, new \DateTimeZone(config('app.timezone')));
        $date->setTimezone(new \DateTimeZone($timeZone));
        return $date->format('Y-m-d H:i:s');
    }
}
if (! function_exists('formatDateTime')) {
    function formatDateTime($dateTime, $format = 'd-m-Y H:i:s')
    {
        return \Carbon\Carbon::parse($dateTime)->format($format);
    }
}
if (! function_exists('formatDateOnly')) {
    function formatDateOnly($dateTime, $format = 'd-m-Y')
    {
        return \Carbon\Carbon::parse($dateTime)->format($format);
    }
}
if (! function_exists('formatTimeOnly')) {
    function formatTimeOnly($dateTime, $format = 'H:i:s')
    {
        return \Carbon\Carbon::parse($dateTime)->format($format);
    }
}
if (! function_exists('getCurrentUser')) {
    function getCurrentUser()
    {
        return auth()->user();
    }
}
if (! function_exists('isUserLoggedIn')) {
    function isUserLoggedIn()
    {
        return auth()->check();
    }
}
if (! function_exists('logoutUser')) {
    function logoutUser()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
    }
}
if (! function_exists('loginUser')) {
    function loginUser($user)
    {
        auth()->login($user);
        session()->regenerate();
    }
}
if (! function_exists('getUserPermissions')) {
    function getUserPermissions($user)
    {
        // Implement permission retrieval logic
        // This is a placeholder function.
        return [];
    }
}

if (! function_exists('getCountryISO2')) {
    function getCountryISO2($id)
    {
        $country = countries::find($id);
        return $country ? $country->iso2 : null;
    }
}

if (! function_exists('getOrderPriceWithoutTax')) {
    function getOrderPriceWithoutTax($orderId)
    {
        $orderPrice = \App\Models\Order::where('id', $orderId)
            // ->where('status', 2) // Completed orders
            ->select('total_amount')
            ->first();
        return $orderPrice ? $orderPrice->total_amount : 0;
    }
}

if (! function_exists('getWalletBalance')) {
    function getWalletBalance($userId)
    {
        $credit = \App\Models\Wallet::where('user_id', $userId)->sum('credit');
        $debit = \App\Models\Wallet::where('user_id', $userId)->sum('debit');
        return $credit - $debit;
    }
}

if (! function_exists('getNewWalletBalance')) {
    function getNewWalletBalance($userId, $walletId)
    {
        $credit = \App\Models\Wallet::where('user_id', $userId)
            ->where('id', '<=', $walletId)
            ->sum('credit');

        $debit = \App\Models\Wallet::where('user_id', $userId)
            ->where('id', '<=', $walletId)
            ->sum('debit');

        return $credit - $debit;
    }
}

if (! function_exists('getProductId')) {
    function getProductId($Id)
    {
        $OrderItem = \App\Models\OrderItem::where('id', $Id)->select('product_id')->first();

        return $OrderItem->product_id ?? 0;
    }
}

if (! function_exists('sendBronzeWelcomeMail')) {

    function sendBronzeWelcomeMail($userId, $plainPassword = null)
    {
        // Get user
        $user = DB::table('users')->where('id', $userId)->first();

        if (!$user) {
            return;
        }

        // Fetch email template
        $template = DB::table('email_templates')
            ->where('type', 'Welcome Mail - Bronce Package')
            ->first();

        if (!$template) {
            return;
        }

        // Replace placeholders
        $body = str_replace(
            [
                '[User’s Name]',
                'Username:',
                'Password:',
            ],
            [
                $user->name,
                'Username: ' . $user->email,
                $plainPassword ? 'Password: ' . $plainPassword : 'Password: ********',
            ],
            $template->body
        );

        // Send mail
        Mail::to($user->email)->send(
            new DynamicMail($template->subject, $body)
        );
    }
}


if (! function_exists('sendWelcomeMail')) {

    function sendWelcomeMail($userId, $type, $plainPassword = null)
    {
        // Get user
        $user = DB::table('users')->where('id', $userId)->first();

        if (!$user) {
            return;
        }

        // Fetch email template
        $template = DB::table('email_templates')
            ->where('type',  $type)
            ->first();

        if (!$template) {
            return;
        }

        // Replace placeholders
        $body = str_replace(
            [
                '[User’s Name]',
                'Username:',
                'Password:',
            ],
            [
                $user->name,
                'Username: ' . $user->email,
                $plainPassword ? 'Password: ' . $plainPassword : 'Password: ********',
            ],
            $template->body
        );

        // Send mail
        Mail::to($user->email)->send(
            new DynamicMail($template->subject, $body)
        );
    }
}

//member_packages
if (! function_exists('getMemberPackageServices')) {
    function getMemberPackageServices($id)
    {
        $package = memberPackage::find($id);
        if ($package && $package->services) {
            $serviceIds = explode(',', $package->services);
            $services = memberPackageService::whereIn('id', $serviceIds)->pluck('name')->toArray();
            return implode(', ', $services);
        }
        return null;
    }
}
if (! function_exists('getMemberPackageType')) {
    function getMemberPackageType($id)
    {
        $package = memberPackage::find($id);
        return $package ? $package->type : null;
    }
}
if (!function_exists('seo')) {

    function seo($page)
    {
        $page = is_string($page) ? trim($page) : '';
        $path = parse_url($page, PHP_URL_PATH);
        if (is_string($path) && $path !== '') {
            $page = $path;
        }

        $page = trim($page);
        if ($page === '' || $page === '/') {
            $page = 'home';
        }

        $pageNoSlashes = trim($page, '/');
        if ($pageNoSlashes === '') {
            $pageNoSlashes = 'home';
        }

        $candidates = array_values(array_unique([
            $page,
            $pageNoSlashes,
            ltrim($page, '/'),
            '/' . $pageNoSlashes,
        ]));

        $seo = DB::table('seo_meta')
            ->whereIn('page', $candidates)
            ->first();

        return [
            'title'       => $seo->title ?? config('app.name'),
            'keywords'    => $seo->keywords ?? '',
            'description' => $seo->description ?? '',
        ];
    }
}

if (!function_exists('sendDynamicMail')) {

    /**
     * Send dynamic email using template and placeholders
     *
     * @param int    $userId
     * @param string $type          // email_templates.type
     * @param array  $placeholders  // ['[KEY]' => 'value']
     * @return bool
     */
    function sendDynamicMail(int $userId = null, string $type, array $placeholders = []): bool
    {
        // Fetch user
        $user = DB::table('users')->where('id', $userId)->first();
        if (!$user || empty($user->email)) {
            return false;
        }

        // Fetch email template
        $template = DB::table('email_templates')
            ->where('type', $type)
            ->first();

        if (!$template) {
            $template = DB::table('email_templates')
                ->where('slug', $type)
                ->first();

            if (!$template) {
                return false;
            }
        }

        // Replace placeholders dynamically
        $subject = str_replace(
            array_keys($placeholders),
            array_values($placeholders),
            $template->subject
        );

        $body = str_replace(
            array_keys($placeholders),
            array_values($placeholders),
            $template->body
        );
        // Send email

        Mail::to($user->email)->send(
            new DynamicMail($subject, $body)
        );

        return true;
    }
}



if (!function_exists('sendDynamicMailNoLoginIn')) {

    /**
     * Send dynamic email using template and placeholders
     *
     * @param int    $userId
     * @param string $type          // email_templates.type
     * @param array  $placeholders  // ['[KEY]' => 'value']
     * @return bool
     */
    function sendDynamicMailNoLoginIn(string $email, string $type, array $placeholders = []): bool
    {
        // Fetch email template

        $template = DB::table('email_templates')
            ->where('slug', $type)
            ->first();
        if (!$template) {
            return false;
        }

        // Replace placeholders dynamically
        $body = str_replace(
            array_keys($placeholders),
            array_values($placeholders),
            $template->body
        );

        // Send email

        Mail::to($email)->send(
            new DynamicMail($template->subject, $body)
        );
        return true;
    }
}

if (!function_exists('checkPlanLimit')) {

    function checkPlanLimit($userId, $type)
    {
        $user = DB::table('users')->where('id', $userId)->first();
        $seller_packages = DB::table('seller_packages')->where('seller_id', $userId)->first();
        $plan = DB::table('member_packages')->where('id', $seller_packages->package_id)->first();


        $plan = DB::table('member_packages')->where('id', $user->member_package_id)->first();

        switch ($type) {
            case 'single_product':
                $used = DB::table('products')
                    ->where('user_id', $userId)
                    ->where('type', 'single')
                    ->count();
                $limit = $plan->single_product_limit;
                break;

            case 'tender':
                $used = DB::table('tenders')->where('user_id', $userId)->count();
                $limit = $plan->tender_limit;
                break;

            case 'news':
                $used = DB::table('news')->where('user_id', $userId)->count();
                $limit = $plan->news_limit;
                break;

            default:
                return true;
        }

        return $used < $limit;
    }
}
if (! function_exists('getTenderType')) {
    function getTenderType($type)
    {
        switch ($type) {
            case 0:
                return 'Open';
            case 1:
                return 'Closed';
            default:
                return 'Unknown';
        }
    }
}

if (!function_exists('sendDynamicMails')) {

    /**
     * Send dynamic email using template and placeholders
     *
     * @param int    $userId
     * @param string $type          // email_templates.type
     * @param array  $placeholders  // ['[KEY]' => 'value']
     * @return bool
     */
    function sendDynamicMails(array $emails, string $type, array $placeholders = []): bool
    {
        // Fetch user


        // Fetch email template
        $template = DB::table('email_templates')
            ->where('type', $type)
            ->first();

        if (!$template) {
            $template = DB::table('email_templates')
                ->where('slug', $type)
                ->first();

            if (!$template) {
                return false;
            }
        }

        // Replace placeholders dynamically
        $subject = str_replace(
            array_keys($placeholders),
            array_values($placeholders),
            $template->subject
        );

        $body = str_replace(
            array_keys($placeholders),
            array_values($placeholders),
            $template->body
        );
        // Send email

        Mail::to($emails)->send(
            new DynamicMail($subject, $body)
        );

        return true;
    }
}
