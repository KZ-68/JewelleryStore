<?php

namespace App\Services\Carrier\GLS;

use Illuminate\Support\Facades\Http;

class GLSConnectorService
{
    /**
     * @return \Illuminate\Http\Client\Response
     */
    protected function getToken() : array
    {
        $apiKey = env('GLS_API_KEY');
        $apiSecret = env('GLS_API_SECRET');
        $encodedBasicAuth = base64_encode("{$apiKey}:{$apiSecret}");
        $headers = [
            "Authorization" => "Basic $encodedBasicAuth",
            "Content-Type" => "application/x-www-form-urlencoded"
        ];

        $response = Http::withHeaders($headers)
            ->post('https://api-sandbox.gls-group.net/oauth2/v2/token', [
                'grant_type' => 'client_credentials',
            ]);

        return json_decode($response->body(), true);
    }

    public function trackShipment($trackingNumber): array
    {
        $token = $this->getToken();
        $accessToken = $token['access_token'];
        $headers = [
            "Authorization" => "Bearer $accessToken",
            "Content-Type" => "application/json"
        ];

        $response = Http::withHeaders($headers)->get("track/shipment/$trackingNumber");

        return json_decode($response->body(), true);
    }
}