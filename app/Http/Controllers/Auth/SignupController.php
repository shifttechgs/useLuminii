<?php

namespace App\Http\Controllers\Auth;

use App\Actions\CreateBusiness;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Support\CurrentBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

/**
 * Self-serve sign-up: creates a separate business with its owner on a 14-day trial
 * (no card), signs the owner in and lands them in the CRM.
 */
class SignupController extends Controller
{
    public function show(Request $request)
    {
        $plans = config('plans.plans');
        $plan = array_key_exists($request->query('plan'), $plans) ? $request->query('plan') : 'business';
        $interval = $request->query('interval') === 'annual' ? 'annual' : 'monthly';

        return view('auth.signup', [
            'plans'     => $plans,
            'plan'      => old('plan', $plan),
            'interval'  => old('interval', $interval),
            'trialDays' => (int) config('plans.trial_days', 14),
        ]);
    }

    public function store(Request $request, CreateBusiness $createBusiness)
    {
        // Bots fill every field; people never see this one.
        if (filled($request->input('company_website'))) {
            return redirect()->route('signup');
        }

        $data = $request->validate([
            'name'          => ['required', 'string', 'max:120'],
            'business_name' => ['required', 'string', 'max:160'],
            'email'         => ['required', 'email:rfc', 'max:190', 'unique:users,email'],
            'phone'         => ['nullable', 'string', 'max:30'],
            'password'      => ['required', 'string', Password::min(8)->letters()->numbers()],
            'plan'          => ['required', 'in:' . implode(',', array_keys(config('plans.plans')))],
            'interval'      => ['required', 'in:monthly,annual'],
        ], [
            'email.unique' => 'There is already an account with this email. Sign in instead.',
        ]);

        $result = $createBusiness->handle([
            'name'        => trim($data['business_name']),
            'owner_name'  => trim($data['name']),
            'owner_email' => $data['email'],
            'password'    => $data['password'],
            'phone'       => $data['phone'] ?? null,
        ], ['plan' => $data['plan'], 'interval' => $data['interval']]);

        $user = $result['user'];

        Auth::login($user, true);
        $request->session()->regenerate();

        $this->afterSignup($user, $data);

        return redirect()->route('crm.dashboard')->with(
            'success',
            'Welcome to useLuminii. Your ' . config('plans.trial_days', 14) . '-day trial has started.'
        );
    }

    /** Verification email, and the platform team hears about every new business. */
    private function afterSignup($user, array $data): void
    {
        try {
            $user->sendEmailVerificationNotification();
        } catch (\Throwable $e) {
            Log::warning('Sign-up verification email failed', ['user' => $user->id, 'error' => $e->getMessage()]);
        }

        $planName = config("plans.plans.{$data['plan']}.name", $data['plan']);
        $summary = "Self-serve sign-up: {$planName} trial ({$data['interval']}).";

        try {
            CurrentBusiness::run(CurrentBusiness::platform(), fn () => Lead::create([
                'source'   => 'website',
                'name'     => $data['name'],
                'email'    => $data['email'],
                'phone'    => $data['phone'] ?? null,
                'company'  => $data['business_name'],
                'message'  => $summary . ' Book their onboarding call.',
                'status'   => 'New',
                'priority' => 'High',
            ]));
        } catch (\Throwable $e) {
            Log::warning('Sign-up lead not recorded', ['error' => $e->getMessage()]);
        }

        try {
            Mail::raw(
                "{$summary}\n\nName: {$data['name']}\nBusiness: {$data['business_name']}\nEmail: {$data['email']}\nPhone: " . ($data['phone'] ?? '-'),
                function ($message) use ($data) {
                    $message->to(config('mail.notifications.to'))
                        ->cc(config('mail.notifications.cc', []))
                        ->subject("New sign-up: {$data['business_name']}");
                }
            );
        } catch (\Throwable $e) {
            Log::warning('Sign-up notification email failed', ['error' => $e->getMessage()]);
        }
    }
}
