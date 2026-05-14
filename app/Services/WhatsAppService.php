<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $phone;
    protected string $apiKey;
    protected bool $enabled;

    public function __construct()
    {
        $this->phone   = config('services.callmebot.phone', '');
        $this->apiKey  = config('services.callmebot.api_key', '');
        $this->enabled = config('services.callmebot.enabled', false);
    }

    /**
     * Send a WhatsApp notification via CallMeBot.
     *
     * @param  string  $message
     * @return array{success: bool, message: string}
     */
    public function send(string $message): array
    {
        if (!$this->enabled) {
            Log::info('WhatsApp (CallMeBot) notifications are disabled.');
            return ['success' => false, 'message' => 'WhatsApp notifications disabled'];
        }

        if (empty($this->phone) || empty($this->apiKey)) {
            Log::warning('CallMeBot phone or API key not configured.');
            return ['success' => false, 'message' => 'CallMeBot credentials not configured'];
        }

        try {
            $response = Http::timeout(15)->get('https://api.callmebot.com/whatsapp.php', [
                'phone'  => $this->phone,
                'text'   => $message,
                'apikey' => $this->apiKey,
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp notification sent via CallMeBot', [
                    'phone' => $this->phone,
                ]);
                return ['success' => true, 'message' => 'WhatsApp notification sent'];
            }

            Log::warning('CallMeBot returned a non-success response', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return ['success' => false, 'message' => 'CallMeBot returned status ' . $response->status()];

        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp notification via CallMeBot', [
                'error' => $e->getMessage(),
            ]);

            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Build a formatted notification message from contact form data.
     *
     * @param  array  $formData
     * @return string
     */
    public function buildContactMessage(array $formData): string
    {
        $name    = $formData['name']    ?? 'N/A';
        $email   = $formData['email']   ?? 'N/A';
        $phone   = $formData['phone']   ?? 'N/A';
        $subject = $formData['subject'] ?? 'N/A';
        $message = $formData['message'] ?? 'N/A';

        return "📬 *New Contact Form Submission*\n\n"
            . "*Name:* {$name}\n"
            . "*Email:* {$email}\n"
            . "*Phone:* {$phone}\n"
            . "*Subject:* {$subject}\n\n"
            . "*Message:*\n{$message}";
    }
}
