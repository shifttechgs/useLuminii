<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /** The signed link from the verification email. */
    public function verify(Request $request, string $id, string $hash)
    {
        $user = $request->user();

        abort_unless(
            hash_equals((string) $user->getKey(), $id)
            && hash_equals(sha1($user->getEmailForVerification()), $hash),
            403
        );

        if (! $user->hasVerifiedEmail() && $user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->route('crm.dashboard')->with('success', 'Thanks, your email is confirmed.');
    }

    public function send(Request $request)
    {
        if (! $request->user()->hasVerifiedEmail()) {
            $request->user()->sendEmailVerificationNotification();
        }

        return back()->with('success', 'We sent a new confirmation link to ' . $request->user()->email . '.');
    }
}
