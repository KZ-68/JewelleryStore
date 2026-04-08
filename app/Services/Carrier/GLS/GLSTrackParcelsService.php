<?php

namespace App\Services\Carrier\GLS;

use Exception;
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

    public function trackParcelIds(array $parcelData): array
    {
        $token = $this->getToken();
        $accessToken = $token['access_token'];
        $headers = [
            "Authorization" => "Bearer $accessToken",
            "Content-Type" => "application/json"
        ];

        $body = [
            'originaldestinationpostalcode' => $parcelData['postal_code']
        ];

        try{
            $response = Http::withHeaders($headers)->withBody($body)->get("/track-and-trace-v1/tracking/simple/trackids/{$parcelData['tracking_number']}");
        } catch (Exception $e){
            return ['error' => $e];
        }
        
        return json_decode($response->body(), true);
    }

    public function trackParcelReferences(array $parcelData): array
    {
        $token = $this->getToken();
        $accessToken = $token['access_token'];
        $headers = [
            "Authorization" => "Bearer $accessToken",
            "Content-Type" => "application/json"
        ];

        $body = [
            'originaldestinationpostalcode' => $parcelData['postal_code']
        ];

        try{
            $response = Http::withHeaders($headers)->withBody($body)->get("/track-and-trace-v1/tracking/simple/trackids/{$parcelData['tracking_number']}");
        } catch (Exception $e){
            return ['error' => $e];
        }

        return json_decode($response->body(), true);
    }
}