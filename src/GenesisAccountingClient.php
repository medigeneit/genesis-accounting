<?php

namespace Medigeneit\GenesisAccounting;

use Medigeneit\GenesisAccounting\Exceptions\GenesisAccountingException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class GenesisAccountingClient
{
    protected string $baseUrl;
    protected string $apiKey;
    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('genesis-accounting.base_url'), '/') . '/';
        $this->apiKey = config('genesis-accounting.api_key');
        $this->timeout = (int) config('genesis-accounting.timeout', 30);
    }

    /**
     * Enroll one or more students.
     *
     * POST /enroll-student
     */
    public function enrollStudent(array $data = [], array $query = []): ApiResponse
    {
        return $this->post('enroll-student', $data, $query);
    }

    /**
     * Submit doctor payment(s).
     *
     * POST /doctor-payment
     */
    public function doctorPayment(array $data = [], array $query = []): ApiResponse
    {
        return $this->post('doctor-payment', $data, $query);
    }

    /**
     * Submit customer payment(s).
     *
     * POST /customer-payment
     */
    public function customerPayment(array $data = [], array $query = []): ApiResponse
    {
        return $this->post('customer-payment', $data, $query);
    }

    /**
     * Submit sales invoice(s).
     *
     * POST /sales
     */
    public function sales(array $data = [], array $query = []): ApiResponse
    {
        return $this->post('sales', $data, $query);
    }

    /**
     * Submit sales return(s).
     *
     * POST /sales-return
     */
    public function salesReturn(array $data = [], array $query = []): ApiResponse
    {
        return $this->post('sales-return', $data, $query);
    }

    /**
     * Submit salary sheet.
     *
     * POST /salary-sheet
     */
    public function salarySheet(array $data = [], array $query = []): ApiResponse
    {
        return $this->post('salary-sheet', $data, $query);
    }

    /**
     * Submit batch shifting request.
     *
     * POST /batch-shifting
     */
    public function batchShifting(array $data = [], array $query = []): ApiResponse
    {
        return $this->post('batch-shifting', $data, $query);
    }

    /**
     * Send a GET request to the given endpoint.
     */
    public function get(string $endpoint, array $query = []): ApiResponse
    {
        return $this->request('GET', $endpoint, [], $query);
    }

    /**
     * Send a POST request to the given endpoint.
     */
    public function post(string $endpoint, array $data = [], array $query = []): ApiResponse
    {
        return $this->request('POST', $endpoint, $data, $query);
    }

    /**
     * Build the full URL for a given endpoint with API_KEY and optional query parameters.
     */
    protected function buildUrl(string $endpoint, array $query = []): string
    {
        $url = $this->baseUrl . ltrim($endpoint, '/');

        $params = array_merge(['API_KEY' => $this->apiKey], $query);

        return $url . '?' . http_build_query($params);
    }

    /**
     * Send an HTTP request and return a standardized ApiResponse.
     *
     * @throws GenesisAccountingException
     */
    protected function request(string $method, string $endpoint, array $data = [], array $query = []): ApiResponse
    {
        if (empty($this->apiKey)) {
            throw new GenesisAccountingException(
                'ERP API key is not configured. Please set ERP_API_KEY in your .env file.',
                0
            );
        }

        $url = $this->buildUrl($endpoint, $query);

        try {
            $pendingRequest = Http::timeout($this->timeout)
                ->acceptJson()
                ->asJson();

            $response = strtoupper($method) === 'GET'
                ? $pendingRequest->get($url)
                : $pendingRequest->post($url, $data);

            $body = $response->json() ?? [];
            $statusCode = $response->status();

            if ($response->successful()) {
                return new ApiResponse(
                    true,
                    $statusCode,
                    $body,
                    $body['message'] ?? 'Request successful.'
                );
            }

            return new ApiResponse(
                false,
                $statusCode,
                $body,
                $body['message'] ?? 'Request failed with status ' . $statusCode . '.'
            );
        } catch (ConnectionException $e) {
            throw new GenesisAccountingException(
                'Unable to connect to the ERP API: ' . $e->getMessage(),
                0,
                [],
                $e
            );
        } catch (RequestException $e) {
            $statusCode = $e->response ? $e->response->status() : 0;
            $body = $e->response ? ($e->response->json() ?? []) : [];

            throw new GenesisAccountingException(
                'ERP API request failed: ' . $e->getMessage(),
                $statusCode,
                $body,
                $e
            );
        } catch (\Throwable $e) {
            throw new GenesisAccountingException(
                'An unexpected error occurred: ' . $e->getMessage(),
                0,
                [],
                $e instanceof \Exception ? $e : null
            );
        }
    }
}
