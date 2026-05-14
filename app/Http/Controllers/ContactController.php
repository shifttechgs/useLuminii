<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Models\ContactFormSubmission;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function submitForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'package' => 'required|string|max:255',
            'message' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/contact')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        $contactEmail = env('CONTACT_EMAIL');

        try {
            Mail::to($contactEmail)->send(new ContactFormMail($data));
        } catch (\Exception $e) {
            return redirect('/contact')->with('error', 'An error occurred while sending your message. Please try again later.');
        }

        return redirect('/contact')->with('success', 'Your message has been sent successfully. Our team will contact you shortly!');
    }

    public function bookDemo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'business_type' => 'required|string|max:100',
            'team_size' => 'required|string|max:100',
            'pain_point' => 'required|string|max:255',
            'current_tools' => 'nullable|string|max:500',
        ]);

        $redirectTarget = $request->input('redirect_to');
        if (!is_string($redirectTarget) || !str_starts_with($redirectTarget, url('/'))) {
            $redirectTarget = url('/');
        }

        $redirectWithAnchor = $redirectTarget . '#booking';

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Please check the highlighted fields.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return redirect($redirectWithAnchor)
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        $data['subject'] = 'New Demo Booking - ' . $data['business_type'] . ' (' . $data['team_size'] . ')';
        $data['message'] = trim(
            $data['pain_point'] .
            (!empty($data['current_tools']) ? "\n\nCurrent tools: " . $data['current_tools'] : '')
        );

        $submission = null;
        try {
            $submission = ContactFormSubmission::create([
                'name' => $data['fullname'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'message' => $data['message'],
                'service_interest' => $data['business_type'],
                'lead_source' => 'website',
                'status' => 'New',
                'ip_address' => $request->ip(),
                'email_sent_to_admin' => false,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to save demo booking submission', [
                'error' => $e->getMessage(),
                'email' => $data['email'] ?? null,
            ]);
        }

        $contactEmail = env('CONTACT_EMAIL');
        try {
            Mail::to($contactEmail)->send(new ContactFormMail($data));

            if ($submission) {
                $submission->update(['email_sent_to_admin' => true]);
            }

            $message = $submission
                ? 'Your demo request was saved and emailed successfully.'
                : 'Your demo request was sent successfully.';

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                    'saved' => (bool) $submission,
                    'email_sent' => true,
                ]);
            }

            return redirect($redirectWithAnchor)
                ->with('demo_success', true)
                ->with('demo_message', $message);
        } catch (\Exception $e) {
            Log::warning('Demo booking email failed', [
                'error' => $e->getMessage(),
                'submission_id' => $submission?->submission_id,
            ]);

            if ($submission) {
                $message = 'Your demo request was saved. We will follow up manually.';

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => $message,
                        'saved' => true,
                        'email_sent' => false,
                    ]);
                }

                return redirect($redirectWithAnchor)
                    ->with('demo_success', true)
                    ->with('demo_message', $message);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Something went wrong. Please try again.',
                ], 500);
            }

            return redirect($redirectWithAnchor)
                ->with('demo_error', true)
                ->withInput();
        }
    }
}
