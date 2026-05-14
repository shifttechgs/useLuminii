<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    protected $secretKey;
    protected $enabled;

    public function __construct()
    {
        $this->secretKey = config('services.recaptcha.secret_key');
        $this->enabled = config('services.recaptcha.enabled', false);
    }

    /**
     * Verify reCAPTCHA token
     *
     * @param string $token
     * @param string $action
     * @param float $minScore
     * @return array
     */
    public function verify(string $token, string $action = 'contact_form', float $minScore = 0.5): array
    {
        // If reCAPTCHA is disabled, pass validation
        if (!$this->enabled || empty($this->secretKey)) {
            Log::info('reCAPTCHA is disabled - skipping verification');
            return [
                'success' => true,
                'score' => 1.0,
                'action' => $action
            ];
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $this->secretKey,
                'response' => $token,
            ]);

            $result = $response->json();

            if (!$result['success']) {
                Log::warning('reCAPTCHA verification failed', [
                    'errors' => $result['error-codes'] ?? []
                ]);

                return [
                    'success' => false,
                    'score' => 0.0,
                    'errors' => $result['error-codes'] ?? ['unknown-error']
                ];
            }

            // Check score (for v3)
            $score = $result['score'] ?? 1.0;

            if ($score < $minScore) {
                Log::warning('reCAPTCHA score too low', [
                    'score' => $score,
                    'min_score' => $minScore,
                    'action' => $result['action'] ?? 'unknown'
                ]);

                return [
                    'success' => false,
                    'score' => $score,
                    'message' => 'Suspicious activity detected'
                ];
            }

            return [
                'success' => true,
                'score' => $score,
                'action' => $result['action'] ?? $action
            ];

        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification error', [
                'error' => $e->getMessage()
            ]);

            // In case of error, allow submission but log it
            return [
                'success' => true,
                'score' => 0.5,
                'error' => 'Verification service unavailable'
            ];
        }
    }
}
