<?php

namespace App\Services;

class WhatsAppService
{
    /**
     * Send OTP via Meta WhatsApp Cloud API.
     *
     * @param string $phone
     * @param string $otp
     * @return array
     */
    public static function sendOtp(string $phone, string $otp): array
    {
        $token       = env('WHATSAPP_API_TOKEN');
        $phoneId     = env('WHATSAPP_PHONE_NUMBER_ID');
        $template    = env('WHATSAPP_TEMPLATE_NAME', 'verification_code');
        $lang        = env('WHATSAPP_LANGUAGE_CODE', 'en');

        // Check if credentials are set
        if (empty($token) || empty($phoneId)) {
            return [
                'success' => false,
                'error'   => 'WhatsApp API credentials are not configured in .env'
            ];
        }

        // Clean phone number (must be in international format without + or spaces)
        // India country code is 91. If the phone number is 10 digits, prepend 91.
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($cleanPhone) === 10) {
            $cleanPhone = '91' . $cleanPhone;
        }

        $url = "https://graph.facebook.com/v18.0/{$phoneId}/messages";

        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type'    => 'individual',
            'to'                => $cleanPhone,
            'type'              => 'template',
            'template'          => [
                'name'     => $template,
                'language' => [
                    'code' => $lang,
                ],
                'components' => [
                    [
                        'type'       => 'body',
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => $otp,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => json_encode($payload),
                CURLOPT_HTTPHEADER     => [
                    'Authorization: Bearer ' . $token,
                    'Content-Type: application/json',
                ],
                CURLOPT_TIMEOUT        => 15,
                CURLOPT_SSL_VERIFYPEER => false, // For local XAMPP environment compatibility
                CURLOPT_SSL_VERIFYHOST => false,
            ]);

            $response = curl_exec($ch);
            $curlErr  = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            \Log::info("WhatsApp Cloud API raw response [{$httpCode}]: " . $response);

            if ($curlErr) {
                return [
                    'success' => false,
                    'error'   => 'cURL Error: ' . $curlErr
                ];
            }

            $decoded = json_decode($response, true);

            if ($httpCode >= 200 && $httpCode < 300 && isset($decoded['messages'])) {
                return ['success' => true];
            }

            // Parse Meta API errors
            $errMsg = $decoded['error']['message'] ?? 'Unknown WhatsApp API error';
            return [
                'success' => false,
                'error'   => "Meta API Error: {$errMsg} (HTTP {$httpCode})"
            ];

        } catch (\Throwable $e) {
            return [
                'success' => false,
                'error'   => 'Exception: ' . $e->getMessage()
            ];
        }
    }
}
