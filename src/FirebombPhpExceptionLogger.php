<?php

namespace MeridianPulse\Firebomb;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class FirebombPhpExceptionLogger
{
    protected $client;
    protected $apiKey;
    protected $url;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->apiKey = config('firebombphpclient.api_key');
        $this->url = config('firebombphpclient.api_url');
    }

    /**
     * Log an exception.
     *
     * @param Exception $exception The exception to log.
     * @return void
     */
    public function logException(Exception $exception)
    {
        Log::info("Logging exception", ['exception' => $exception->getMessage()]);

        try {
            $this->client->post($this->url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTraceAsString(),
                    'previous' => $exception->getPrevious() ? $exception->getPrevious()->getMessage() : null,
                    'additionalInfo' => [
                        'user_id' => auth()->id(), // Assuming you're using Laravel's authentication
                        'url' => request()->fullUrl(),
                        'http_method' => request()->method(),
                        'input_data' => request()->all(),
                        'environment' => app()->environment(),
                        'timestamp' => now()->toDateTimeString()
                    ]
                ],
            ]);
        } catch (GuzzleException $e) {
            Log::error('Failed to log exception', ['exception' => $e->getMessage()]);
        }
    }
}
