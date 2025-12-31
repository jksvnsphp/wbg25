<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\BulkMail;
use App\Mail\AdminBulkMail;
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

     public function sendAdminBulkMail(Request $request)
    {
            $request->validate([
            'recipient' => 'required',
            'subject'   => 'required',
            'mail_body' => 'required',
            ]);

            $emails = $this->getEmailsBasedOnSelection($request->recipient);

            foreach ($emails as $email) {
            Mail::to($email)->send(new AdminBulkMail(
            $request->subject, 
            $request->mail_body
            ));
            }

            return back()->with('success', 'Bulk Emails Sent Successfully!');

        // $emails = [];
        // $emails = $this->getEmailsBasedOnSelection($request->recipient, $request->specific_email);
        // foreach ($emails as $email) {
        //     Mail::to($email)->send(new BulkMail($request->subject, $request->message, $request->file('attachment')));
        // }
        // return back()->with(['alert-type'=>'success','message'=>'Emails sent successfully!']);
    }

    private function getEmailsBasedOnSelection($type)
{
    switch ($type) {

        case 'all_seller':
            return User::where('role', 'seller')->pluck('email')->toArray();

        case 'active_seller':
            return User::where('role', 'seller')->where('status', 1)->pluck('email')->toArray();

        case 'inactive_seller':
            return User::where('role', 'seller')->where('status', 0)->pluck('email')->toArray();

        case 'all_buyer':
            return User::where('role', 'buyer')->pluck('email')->toArray();

        case 'active_buyer':
            return User::where('role', 'buyer')->where('status', 1)->pluck('email')->toArray();

        case 'inactive_buyer':
            return User::where('role', 'buyer')->where('status', 0)->pluck('email')->toArray();

        default:
            return [];
    }
}

}
