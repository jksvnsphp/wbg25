<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\BulkMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BulkMailController extends Controller
{
    public function bulkMail()
    {
        return view('admin.bulk-mail.send-mail');
    }
    public function getEmails($membershipType = 'all')
    {
        $query = DB::table('users')
            ->join('companies', 'users.id', '=', 'companies.vendor_id')
            ->join('seller_packages', 'users.id', '=', 'seller_packages.seller_id')
            ->join('member_packages', 'seller_packages.package_id', '=', 'member_packages.id')
            ->where('users.account_type', 'seller')
            ->where('seller_packages.payment_status', 'confirmed')
            ->where('seller_packages.expire_at', '>', Carbon::now())
            ->select('users.email', 'users.name', 'member_packages.type');
        if ($membershipType !== 'all') {
            $query->where('member_packages.type', $membershipType);
        }

        return $query->pluck('users.email'); // Get emails only
    }
    private function getEmailsBasedOnSelection($recipient, $specificEmail = null)
    {

        if ($recipient === 'all') {
            return User::pluck('email')->toArray();
        }
        if ($recipient === 'all-seller') {
            return User::where('account_type', 'seller')->where('email', '!=', '')->whereHas('company')->pluck('email')->toArray();
        }
        if ($recipient === 'all-buyer') {
            return User::where('account_type', 'buyer')->where('email', '!=', '')->pluck('email')->toArray();
        }

        if ($recipient === 'specific' && $specificEmail) {
            return [$specificEmail];
        }

        // Case: Send to all members in a specific package
        if (in_array($recipient, ['bronce', 'silver', 'gold', 'platinum'])) {
            return User::where('account_type', 'seller')
                ->where('isComplete',1)
                ->whereHas('company') 
                ->whereHas('sellerPackageOne', function ($query) use ($recipient) {
                    $query->where('expire_at', '>=', now())
                        ->whereHas('package', function ($packageQuery) use ($recipient) {
                            $packageQuery->where('type', $recipient);
                        });
                })
                ->pluck('email')
                ->toArray();
        }

        return [];
    }

    public function sendbulkMail(Request $request)
    {
        $request->validate([
            'recipient' => 'required',
            'specific_email' => 'nullable',
            'subject'   => 'required',
            'message'   => 'required',
            'attachment' => 'nullable|file|max:2048',
        ]);

        $emails = [];
        $emails = $this->getEmailsBasedOnSelection($request->recipient, $request->specific_email);
        foreach ($emails as $email) {
            Mail::to($email)->send(new BulkMail($request->subject, $request->message, $request->file('attachment')));
        }
        return back()->with(['alert-type'=>'success','message'=>'Emails sent successfully!']);
    }
}
