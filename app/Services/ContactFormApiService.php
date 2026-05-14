<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContactFormApiService
{
    protected $baseUrl;
    protected $apiVersion;
    protected $timeout;
    protected $verifySSL;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.luminii_api.base_url'), '/');
        $this->apiVersion = config('services.luminii_api.version', 'v1');
        $this->timeout = config('services.luminii_api.timeout', 30);
        $this->verifySSL = config('services.luminii_api.verify_ssl', true);
    }

    /**
     * Submit a contact form to the Luminii CRM API
     *
     * @param array $data
     * @return array
     */
    public function submitContactForm(array $data): array
    {
        try {
            $endpoint = "{$this->baseUrl}/api/{$this->apiVersion}/ContactForm/submitContactForm";

            Log::info('Submitting contact form to API', [
                'endpoint' => $endpoint,
                'data' => $this->maskSensitiveData($data)
            ]);

            $response = Http::timeout($this->timeout)
                ->withOptions([
                    'verify' => $this->verifySSL,
                ])
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post($endpoint, $data);

            if ($response->successful()) {
                $responseData = $response->json();

                Log::info('Contact form submitted successfully', [
                    'contact_id' => $responseData['Data']['ContactId'] ?? 'N/A',
                    'status_code' => $response->status()
                ]);

                return [
                    'success' => true,
                    'data' => $responseData['Data'] ?? null,
                    'message' => $responseData['Message'] ?? 'Contact form submitted successfully',
                    'status_code' => $response->status()
                ];
            }

            // Handle API errors
            $errorData = $response->json();
            $errors = $errorData['Errors'] ?? [$response->body()];

            Log::warning('Contact form submission failed', [
                'status_code' => $response->status(),
                'errors' => $errors
            ]);

            return [
                'success' => false,
                'errors' => $errors,
                'message' => is_array($errors) ? implode(', ', $errors) : 'Failed to submit contact form',
                'status_code' => $response->status()
            ];

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('API connection error', [
                'error' => $e->getMessage(),
                'endpoint' => $endpoint ?? 'N/A'
            ]);

            return [
                'success' => false,
                'errors' => ['Unable to connect to CRM API. Please try again later.'],
                'message' => 'Connection error',
                'status_code' => 503
            ];

        } catch (\Exception $e) {
            Log::error('Unexpected error submitting contact form', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'errors' => ['An unexpected error occurred. Please try again later.'],
                'message' => 'System error',
                'status_code' => 500
            ];
        }
    }

    /**
     * Get all contact forms (Admin endpoint)
     *
     * @return array
     */
    public function getAllContactForms(): array
    {
        try {
            $endpoint = "{$this->baseUrl}/api/{$this->apiVersion}/ContactForm/getAllContactForms";

            $response = Http::timeout($this->timeout)
                ->withOptions([
                    'verify' => $this->verifySSL,
                ])
                ->withHeaders([
                    'Accept' => 'application/json',
                ])
                ->get($endpoint);

            if ($response->successful()) {
                $responseData = $response->json();

                return [
                    'success' => true,
                    'data' => $responseData['Data'] ?? [],
                    'count' => $responseData['Count'] ?? 0,
                    'status_code' => $response->status()
                ];
            }

            return [
                'success' => false,
                'errors' => ['Failed to fetch contact forms'],
                'status_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('Error fetching contact forms', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'errors' => ['Failed to fetch contact forms'],
                'status_code' => 500
            ];
        }
    }

    /**
     * Get contact forms by status (Admin endpoint)
     *
     * @param string $status
     * @return array
     */
    public function getContactFormsByStatus(string $status): array
    {
        try {
            $endpoint = "{$this->baseUrl}/api/{$this->apiVersion}/ContactForm/getContactFormsByStatus/{$status}";

            $response = Http::timeout($this->timeout)
                ->withOptions([
                    'verify' => $this->verifySSL,
                ])
                ->withHeaders([
                    'Accept' => 'application/json',
                ])
                ->get($endpoint);

            if ($response->successful()) {
                $responseData = $response->json();

                return [
                    'success' => true,
                    'data' => $responseData['Data'] ?? [],
                    'count' => $responseData['Count'] ?? 0,
                    'status_code' => $response->status()
                ];
            }

            return [
                'success' => false,
                'errors' => ['Failed to fetch contact forms'],
                'status_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('Error fetching contact forms by status', ['error' => $e->getMessage(), 'status' => $status]);

            return [
                'success' => false,
                'errors' => ['Failed to fetch contact forms'],
                'status_code' => 500
            ];
        }
    }

    /**
     * Get a specific contact form by ID (Admin endpoint)
     *
     * @param string $contactId
     * @return array
     */
    public function getContactFormById(string $contactId): array
    {
        try {
            $endpoint = "{$this->baseUrl}/api/{$this->apiVersion}/ContactForm/getContactForm/{$contactId}";

            $response = Http::timeout($this->timeout)
                ->withOptions([
                    'verify' => $this->verifySSL,
                ])
                ->withHeaders([
                    'Accept' => 'application/json',
                ])
                ->get($endpoint);

            if ($response->successful()) {
                $responseData = $response->json();

                return [
                    'success' => true,
                    'data' => $responseData['Data'] ?? null,
                    'status_code' => $response->status()
                ];
            }

            return [
                'success' => false,
                'errors' => ['Contact form not found'],
                'status_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('Error fetching contact form by ID', ['error' => $e->getMessage(), 'contact_id' => $contactId]);

            return [
                'success' => false,
                'errors' => ['Failed to fetch contact form'],
                'status_code' => 500
            ];
        }
    }

    /**
     * Mask sensitive data for logging
     *
     * @param array $data
     * @return array
     */
    protected function maskSensitiveData(array $data): array
    {
        $masked = $data;

        if (isset($masked['Email'])) {
            $parts = explode('@', $masked['Email']);
            if (count($parts) === 2) {
                $masked['Email'] = substr($parts[0], 0, 2) . '***@' . $parts[1];
            }
        }

        if (isset($masked['Phone'])) {
            $masked['Phone'] = substr($masked['Phone'], 0, 3) . '***' . substr($masked['Phone'], -2);
        }

        return $masked;
    }
}
