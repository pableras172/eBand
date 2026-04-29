<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class TenantOneSignalService
{
    protected Client $client;

    protected string $appId;

    protected string $apiKey;

    public function __construct()
    {
        $tenant = tenant();

        if ($tenant) {
            $this->appId = $tenant->oneSignalAppId();
            $this->apiKey = $tenant->oneSignalApiKey();
        } else {
            $this->appId = (string) config('services.onesignal.app_id', '');
            $this->apiKey = (string) config('services.onesignal.rest_api_key', '');
        }

        $this->client = new Client([
            'base_uri' => config('services.onesignal.rest_api_url', 'https://api.onesignal.com'),
            'timeout' => config('services.onesignal.guzzle_client_timeout', 60),
        ]);
    }

    /**
     * Send notification to a segment (tenant-aware).
     */
    public function sendNotificationToSegment(
        string $heading,
        string $segment,
        ?string $bigPicture = null,
        ?string $largeIcon = null,
        ?string $iosCategory = null,
        ?string $data = null,
        ?string $subtitle = null,
        ?string $actionText = null
    ): void {
        if (! $this->appId || ! $this->apiKey) {
            Log::warning('OneSignal credentials not configured for tenant');

            return;
        }

        try {
            $payload = [
                'app_id' => $this->appId,
                'included_segments' => [$segment],
                'headings' => ['en' => $heading],
            ];

            if ($subtitle) {
                $payload['subtitle'] = ['en' => $subtitle];
            }

            if ($bigPicture) {
                $payload['big_picture'] = $bigPicture;
            }

            if ($largeIcon) {
                $payload['large_icon'] = $largeIcon;
            }

            if ($data) {
                $payload['url'] = $data;
            }

            if ($iosCategory) {
                $payload['ios_category'] = $iosCategory;
            }

            if ($actionText) {
                $payload['actionText'] = $actionText;
            }

            $this->client->post('/notifications', [
                'headers' => [
                    'Authorization' => 'Basic '.$this->apiKey,
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
                'json' => $payload,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send OneSignal segment notification: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * Send notification to external user (tenant-aware).
     */
    public function sendNotificationToExternalUser(
        string $heading,
        string $userId,
        string $url,
        ?string $bigPicture = null,
        ?string $largeIcon = null,
        ?string $subtitle = null
    ): void {
        if (! $this->appId || ! $this->apiKey) {
            Log::warning('OneSignal credentials not configured for tenant');

            return;
        }

        try {
            $payload = [
                'app_id' => $this->appId,
                'include_external_user_ids' => [$userId],
                'headings' => ['en' => $heading],
                'url' => $url,
            ];

            if ($subtitle) {
                $payload['subtitle'] = ['en' => $subtitle];
            }

            if ($bigPicture) {
                $payload['big_picture'] = $bigPicture;
            }

            if ($largeIcon) {
                $payload['large_icon'] = $largeIcon;
            }

            $this->client->post('/notifications', [
                'headers' => [
                    'Authorization' => 'Basic '.$this->apiKey,
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
                'json' => $payload,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send OneSignal external user notification: '.$e->getMessage());
            throw $e;
        }
    }
}
