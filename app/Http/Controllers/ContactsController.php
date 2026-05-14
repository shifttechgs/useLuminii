<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Models\Lead;
use App\Models\BusinessService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormNotification;

class ContactsController extends Controller
{
    public function index()
    {
        $services = BusinessService::where('is_active', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get(['service_id', 'name', 'category']);

        return view('contact', compact('services'));
    }

    public function submitForm(ContactFormRequest $request): JsonResponse
    {
        $data      = $request->validated();
        $adminEmail = env('CONTACT_EMAIL', config('mail.from.address'));

        // 1. Save to local CRM database
        try {
            $services   = $data['services'] ?? [];
            $submission = Lead::create([
                'source'              => 'website',
                'name'                => $data['name'],
                'email'               => $data['email'],
                'phone'               => $data['phone'] ?? null,
                'company'             => $data['company'] ?? null,
                'services_interested' => ! empty($services) ? $services : null,
                'message'             => $data['message'],
                'budget'              => $data['budget'] ?? null,
                'status'              => 'New',
                'priority'            => 'Normal',
                'ip_address'          => $request->ip(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to save contact form submission', ['error' => $e->getMessage()]);
        }

        // 2. Send admin email notification
        $emailSent = false;
        try {
            Mail::to($adminEmail)->send(new ContactFormNotification($data, true));
            $emailSent = true;
            if (isset($submission)) {
                $submission->update(['email_sent_to_admin' => true]);
            }
        } catch (\Exception $e) {
            Log::error('Contact form email failed', ['error' => $e->getMessage()]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your message! We will get back to you shortly.',
        ]);
    }
}
