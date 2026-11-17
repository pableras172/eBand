<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class TenantOneSignalService
{
    protected Client $client;

    protected string $appId;

    protected string $apiKey;

    protected ?string $tenantId = null;

    public function __construct()
    {
        $tenant = tenant();

        if ($tenant) {
            $this->appId = $tenant->oneSignalAppId();
            $this->apiKey = $tenant->oneSignalApiKey();
            $this->tenantId = (string) $tenant->getTenantKey();
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
     * Send notification to all members of the tenant/segment.
     * Guaranteed tenant isolation: uses tag filter by tenant_id when in a tenant context.
     */
    public function sendNotificationToSegment(
        string $heading,
        string $segment = 'Active Subscriptions',
        ?string $bigPicture = null,
        ?string $largeIcon = null,
        ?string $iosCategory = null,
        ?string $data = null,
        ?string $subtitle = null,
        ?string $actionText = null,
        ?string $url = null
    ): void {
        if (! $this->appId || ! $this->apiKey) {
            Log::warning('OneSignal credentials not configured for tenant');

            return;
        }

        // Resolve target URL
        $targetUrl = $url ?: $data;
        if (! $targetUrl && $bigPicture && (str_starts_with($bigPicture, 'http://') || str_starts_with($bigPicture, 'https://') || str_starts_with($bigPicture, '/'))) {
            if (! preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', (string) (parse_url($bigPicture, PHP_URL_PATH) ?? ''))) {
                $targetUrl = $bigPicture;
                $bigPicture = null;
            }
        }

        $tenantId = $this->tenantId ?? (tenant()?->getTenantKey() ? (string) tenant()->getTenantKey() : null);

        $payload = [
            'app_id' => $this->appId,
            'headings' => [
                'en' => $heading,
                'es' => $heading,
            ],
            'contents' => [
                'en' => $subtitle ?: $heading,
                'es' => $subtitle ?: $heading,
            ],
        ];

        // Strict Tenant Isolation:
        // When running in a tenant context, filter devices by tag tenant_id.
        // OneSignal prohibits combining filters with included_segments.
        if ($tenantId) {
            $payload['filters'] = [
                [
                    'field' => 'tag',
                    'key' => 'tenant_id',
                    'relation' => '=',
                    'value' => $tenantId,
                ],
            ];
        } else {
            $payload['included_segments'] = [$segment ?: 'Active Subscriptions'];
        }

        if ($subtitle) {
            $payload['subtitle'] = [
                'en' => $subtitle,
                'es' => $subtitle,
            ];
        }

        if ($targetUrl) {
            $payload['url'] = $targetUrl;
        }

        if ($bigPicture) {
            $payload['big_picture'] = $bigPicture;
        }

        if ($largeIcon) {
            $payload['large_icon'] = $largeIcon;
        }

        if ($iosCategory) {
            $payload['ios_category'] = $iosCategory;
        }

        if ($actionText) {
            $payload['buttons'] = [
                ['id' => 'action-btn', 'text' => $actionText],
            ];
        }

        try {
            $this->client->post('/notifications', [
                'headers' => [
                    'Authorization' => 'Basic '.$this->apiKey,
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
                'json' => $payload,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send OneSignal segment notification: '.$e->getMessage(), [
                'tenant_id' => $tenantId,
                'payload' => $payload,
            ]);
            throw $e;
        }
    }

    /**
     * Send notification to an external user (identified by UUID).
     */
    public function sendNotificationToExternalUser(
        string $heading,
        string $userId,
        string $url,
        ?string $bigPicture = null,
        ?string $largeIcon = null,
        ?string $subtitle = null,
        ?string $message = null,
        ?string $actionText = null
    ): void {
        if (! $this->appId || ! $this->apiKey) {
            Log::warning('OneSignal credentials not configured for tenant');

            return;
        }

        $bodyText = $message ?: ($subtitle ?: $heading);

        $payload = [
            'app_id' => $this->appId,
            'include_external_user_ids' => [$userId],
            'headings' => [
                'en' => $heading,
                'es' => $heading,
            ],
            'contents' => [
                'en' => $bodyText,
                'es' => $bodyText,
            ],
            'url' => $url,
        ];

        if ($subtitle) {
            $payload['subtitle'] = [
                'en' => $subtitle,
                'es' => $subtitle,
            ];
        }

        if ($bigPicture) {
            $payload['big_picture'] = $bigPicture;
        }

        if ($largeIcon) {
            $payload['large_icon'] = $largeIcon;
        }

        if ($actionText) {
            $payload['buttons'] = [
                ['id' => 'action-btn', 'text' => $actionText],
            ];
        }

        try {
            $this->client->post('/notifications', [
                'headers' => [
                    'Authorization' => 'Basic '.$this->apiKey,
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
                'json' => $payload,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send OneSignal external user notification: '.$e->getMessage(), [
                'user_id' => $userId,
            ]);
            throw $e;
        }
    }
}
