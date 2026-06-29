<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MarketDataService
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.twelvedata.base_url');
        $this->apiKey  = config('services.twelvedata.api_key');
    }

    /** Get current real-time price for a symbol, e.g. "GBP/USD" or "XAU/USD" */
    public function getPrice(string $symbol): ?float
    {
        $response = $this->http()->get("{$this->baseUrl}/price", [
            'symbol' => $symbol,
            'apikey' => $this->apiKey,
        ]);

        $data = $response->json();

        Log::channel('telegram')->info('💹 MARKET PRICE FETCH', [
            'symbol'   => $symbol,
            'response' => $data,
        ]);

        if (!$response->ok() || !isset($data['price'])) {
            Log::channel('telegram')->error('❌ PRICE FETCH FAILED', ['symbol' => $symbol, 'data' => $data]);
            return null;
        }

        return (float) $data['price'];
    }

    /** Get recent OHLC candles — useful later for RSI/MA logic */
    public function getCandles(string $symbol, string $interval = '1h', int $count = 50): array
    {
        $response = $this->http()->get("{$this->baseUrl}/time_series", [
            'symbol'     => $symbol,
            'interval'   => $interval,
            'outputsize' => $count,
            'apikey'     => $this->apiKey,
        ]);

        $data = $response->json();

        if (!$response->ok() || !isset($data['values'])) {
            Log::channel('telegram')->error('❌ CANDLE FETCH FAILED', ['symbol' => $symbol, 'data' => $data]);
            return [];
        }

        return $data['values']; // newest first
    }

    private function http(): \Illuminate\Http\Client\PendingRequest
    {
        $request = Http::withHeaders(['Content-Type' => 'application/json']);
        if (app()->environment('local')) {
            $request = $request->withoutVerifying();
        }
        return $request;
    }
}
