<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class ContactFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:20'],
            'company' => ['nullable', 'string', 'max:100'],
            'company_stage' => ['nullable', 'string', 'in:idea,startup,growth,sme,enterprise'],
            'referral_source' => ['nullable', 'string', 'in:google,linkedin,referral,social,portfolio,other'],
            'budget' => ['nullable', 'numeric', 'min:0', 'max:10000000'],
            'message' => ['required', 'string', 'max:2000'],
            'services'   => ['required', 'array', 'min:1'],
            'services.*' => ['required', 'string', 'max:100'],

            // Anti-spam fields
            'honeypot' => ['nullable', 'max:0'], // Must be empty (honeypot)
            'form_start_time' => ['required', 'integer'], // Form timestamp
            'recaptcha_token' => ['nullable', 'string'], // reCAPTCHA v3 token
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please provide your name.',
            'name.max' => 'Name cannot exceed 100 characters.',
            'email.required' => 'Please provide your email address.',
            'email.email' => 'Please provide a valid email address.',
            'message.required' => 'Please tell us about your project.',
            'message.max' => 'Message cannot exceed 2000 characters.',
            'services.required' => 'Please select at least one service.',
            'services.min' => 'Please select at least one service.',
            'budget.numeric' => 'Budget must be a valid number.',
            'budget.min' => 'Budget cannot be negative.',
            'honeypot.max' => 'Invalid form submission.',
            'form_start_time.required' => 'Form submission error. Please refresh and try again.',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Check if honeypot field was filled (bot detection)
            if (!empty($this->input('honeypot'))) {
                Log::warning('Honeypot triggered - possible bot', [
                    'ip' => $this->ip(),
                    'user_agent' => $this->userAgent(),
                    'honeypot_value' => $this->input('honeypot')
                ]);
                $validator->errors()->add('honeypot', 'Spam detection triggered.');
            }

            // Check if form was submitted too quickly (bot detection)
            $formStartTime = $this->input('form_start_time');
            if ($formStartTime) {
                $timeTaken = time() - $formStartTime;

                // Form must take at least 3 seconds to fill (humans can't fill it instantly)
                if ($timeTaken < 3) {
                    Log::warning('Form submitted too quickly - possible bot', [
                        'ip' => $this->ip(),
                        'time_taken' => $timeTaken,
                        'user_agent' => $this->userAgent()
                    ]);
                    $validator->errors()->add('form_start_time', 'Form submitted too quickly. Please try again.');
                }

                // Form shouldn't take more than 1 hour (session likely expired)
                if ($timeTaken > 3600) {
                    $validator->errors()->add('form_start_time', 'Form session expired. Please refresh and try again.');
                }
            }
        });
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure services is an array
        if ($this->has('services') && is_string($this->services)) {
            $this->merge([
                'services' => json_decode($this->services, true) ?? []
            ]);
        }

        // Convert budget to decimal if it's a string
        if ($this->has('budget') && is_string($this->budget)) {
            $this->merge([
                'budget' => (float) str_replace([',', 'R', ' '], '', $this->budget)
            ]);
        }
    }

    /**
     * Get the data formatted for the API
     *
     * @return array
     */
    public function getApiData(): array
    {
        return [
            'Name' => $this->input('name'),
            'Email' => $this->input('email'),
            'Phone' => $this->input('phone'),
            'Company' => $this->input('company'),
            'CompanyStage' => $this->input('company_stage'),
            'ReferralSource' => $this->input('referral_source'),
            'Budget' => $this->input('budget'),
            'Message' => $this->input('message'),
            'Services' => $this->input('services', []),
            'LeadSource' => 'Website',
        ];
    }
}
