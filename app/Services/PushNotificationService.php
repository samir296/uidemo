<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PushNotificationService
{
    public function sendToUser(User $user, string $title, string $body, array $data = []): bool
    {
        Log::info('Push notification send attempt started.', [
            'user_id' => $user->id,
            'title' => $title,
            'has_mobile_token' => filled($user->mobile_token),
            'mobile_token_preview' => filled($user->mobile_token) ? substr($user->mobile_token, 0, 30).'...' : null,
        ]);

        if (! filled($user->mobile_token)) {
            Log::info('Push notification skipped: user mobile token missing.', [
                'user_id' => $user->id,
            ]);

            return false;
        }

        $credentialsPath = config('services.firebase.credentials');
        $projectId = config('services.firebase.project_id');

        Log::info('Push notification Firebase config check.', [
            'user_id' => $user->id,
            'project_id' => $projectId,
            'credentials_path' => $credentialsPath,
            'credentials_path_present' => filled($credentialsPath),
            'credentials_file_exists' => $credentialsPath ? is_file($credentialsPath) : false,
            'credentials_file_readable' => $credentialsPath ? is_readable($credentialsPath) : false,
        ]);

        if (! $credentialsPath || ! is_file($credentialsPath) || ! $projectId) {
            Log::info('Push notification skipped: Firebase credentials missing.', [
                'user_id' => $user->id,
                'title' => $title,
                'project_id' => $projectId,
                'credentials_path' => $credentialsPath,
                'file_exists' => $credentialsPath ? is_file($credentialsPath) : false,
                'file_readable' => $credentialsPath ? is_readable($credentialsPath) : false,
            ]);

            return false;
        }

        $credentials = json_decode((string) file_get_contents($credentialsPath), true);

        if (! is_array($credentials) || empty($credentials['private_key']) || empty($credentials['client_email'])) {
            Log::warning('Push notification skipped: Invalid Firebase service account file.', [
                'user_id' => $user->id,
                'credentials_keys' => is_array($credentials) ? array_keys($credentials) : null,
            ]);

            return false;
        }

        $accessToken = $this->fetchAccessToken($credentials);

        if (! $accessToken) {
            return false;
        }

        $response = Http::withToken($accessToken)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                'message' => [
                    'token' => $user->mobile_token,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => collect($data)
                        ->map(fn ($value) => is_scalar($value) ? (string) $value : json_encode($value))
                        ->all(),
                ],
            ]);

        if ($response->failed()) {
            Log::warning('Push notification failed.', [
                'user_id' => $user->id,
                'status' => $response->status(),
                'response' => $response->json() ?: $response->body(),
            ]);

            return false;
        }

        Log::info('Push notification sent successfully.', [
            'user_id' => $user->id,
            'status' => $response->status(),
            'response' => $response->json() ?: $response->body(),
        ]);

        return true;
    }

    private function fetchAccessToken(array $credentials): ?string
    {
        $issuedAt = time();
        $expiresAt = $issuedAt + 3600;

        $header = $this->base64UrlEncode(json_encode([
            'alg' => 'RS256',
            'typ' => 'JWT',
        ]));

        $payload = $this->base64UrlEncode(json_encode([
            'iss' => $credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $issuedAt,
            'exp' => $expiresAt,
        ]));

        $unsignedToken = "{$header}.{$payload}";

        $signature = '';
        $privateKey = str_replace('\n', "\n", $credentials['private_key']);
        $signed = openssl_sign($unsignedToken, $signature, $privateKey, OPENSSL_ALGO_SHA256);

        if (! $signed) {
            Log::warning('Unable to sign Firebase JWT.');

            return null;
        }

        $jwt = $unsignedToken.'.'.$this->base64UrlEncode($signature);

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        if ($response->failed()) {
            Log::warning('Unable to fetch Firebase access token.', [
                'status' => $response->status(),
                'response' => $response->json() ?: $response->body(),
            ]);

            return null;
        }

        Log::info('Firebase access token fetched successfully.');

        return $response->json('access_token');
    }

    private function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
