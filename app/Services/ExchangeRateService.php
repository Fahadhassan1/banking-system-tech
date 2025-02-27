<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExchangeRateService
{
    public function getRate(string $from, string $to)
    {
        if ($from === $to) return 1;

        $apiKey = config('services.exchangeratesapi.key');
        
        $response = Http::get("https://api.exchangeratesapi.io/latest", [
            'access_key' => $apiKey,
            'symbols' => "$from,$to"
        ]);

        if ($response->failed()) {
            // Handle API failure gracefully
            return null;
        }

        $rate = $response->json()['rates'][$to] ?? null;

        return $rate ? $rate * 1.01 : null; // Apply a 1% spread
    }
}
