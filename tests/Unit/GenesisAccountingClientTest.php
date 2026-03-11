<?php

namespace Medigeneit\GenesisAccounting\Tests\Unit;

use Medigeneit\GenesisAccounting\ApiResponse;
use Medigeneit\GenesisAccounting\Exceptions\GenesisAccountingException;
use Medigeneit\GenesisAccounting\Facades\GenesisAccounting;
use Medigeneit\GenesisAccounting\GenesisAccountingClient;
use Medigeneit\GenesisAccounting\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class GenesisAccountingClientTest extends TestCase
{
    protected GenesisAccountingClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = app('genesis-accounting');
    }

    public function test_client_is_resolved_from_container(): void
    {
        $this->assertInstanceOf(GenesisAccountingClient::class, $this->client);
    }

    public function test_facade_resolves_to_client(): void
    {
        $this->assertInstanceOf(GenesisAccountingClient::class, GenesisAccounting::getFacadeRoot());
    }

    public function test_config_values_are_loaded(): void
    {
        $this->assertEquals(
            'https://stepserp.webnstech.net/Webns/steperp/med/',
            config('genesis-accounting.base_url')
        );
        $this->assertEquals('test-api-key', config('genesis-accounting.api_key'));
        $this->assertEquals(10, config('genesis-accounting.timeout'));
    }

    public function test_throws_exception_when_api_key_is_empty(): void
    {
        config()->set('genesis-accounting.api_key', '');
        $client = new GenesisAccountingClient();

        $this->expectException(GenesisAccountingException::class);
        $this->expectExceptionMessage('ERP API key is not configured');

        $client->enrollStudent(['enrollments' => []]);
    }

    public function test_enroll_student_sends_post_request(): void
    {
        Http::fake([
            '*enroll-student*' => Http::response(['message' => 'Success', 'data' => []], 200),
        ]);

        $response = $this->client->enrollStudent(['enrollments' => [
            ['reg_no' => 'REG1001', 'full_name' => 'Test Student'],
        ]]);

        $this->assertInstanceOf(ApiResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(200, $response->getStatusCode());

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'enroll-student')
                && str_contains($request->url(), 'API_KEY=test-api-key')
                && $request->method() === 'POST';
        });
    }

    public function test_doctor_payment_sends_post_request(): void
    {
        Http::fake([
            '*doctor-payment*' => Http::response(['message' => 'Success'], 200),
        ]);

        $response = $this->client->doctorPayment(['payments' => [
            ['reg_no' => 'DOC12345', 'payment_amount' => 5000],
        ]]);

        $this->assertTrue($response->isSuccessful());

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'doctor-payment')
                && $request->method() === 'POST';
        });
    }

    public function test_customer_payment_sends_post_request(): void
    {
        Http::fake([
            '*customer-payment*' => Http::response(['message' => 'Success'], 200),
        ]);

        $response = $this->client->customerPayment(['payments' => [
            ['customer_id' => 'CUST001', 'payment_amount' => 3000],
        ]]);

        $this->assertTrue($response->isSuccessful());

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'customer-payment')
                && $request->method() === 'POST';
        });
    }

    public function test_sales_sends_post_request(): void
    {
        Http::fake([
            '*sales?*' => Http::response(['message' => 'Success'], 200),
        ]);

        $response = $this->client->sales(['SALESHeader' => [
            ['invoiceNo' => 'INV-001', 'totalAmount' => 5000],
        ]]);

        $this->assertTrue($response->isSuccessful());

        Http::assertSent(function ($request) {
            return str_contains($request->url(), '/sales?')
                && $request->method() === 'POST';
        });
    }

    public function test_sales_return_sends_post_request(): void
    {
        Http::fake([
            '*sales-return*' => Http::response(['message' => 'Success'], 200),
        ]);

        $response = $this->client->salesReturn(['SALESReturnHeader' => [
            ['returnNo' => 'RET-001', 'totalReturnAmount' => 1000],
        ]]);

        $this->assertTrue($response->isSuccessful());

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'sales-return')
                && $request->method() === 'POST';
        });
    }

    public function test_salary_sheet_sends_post_request(): void
    {
        Http::fake([
            '*salary-sheet*' => Http::response(['message' => 'Success'], 200),
        ]);

        $response = $this->client->salarySheet([
            'salaryMonth' => '2026-03',
            'salaryType' => 'Monthly',
            'employeeSalaries' => [],
        ]);

        $this->assertTrue($response->isSuccessful());

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'salary-sheet')
                && $request->method() === 'POST';
        });
    }

    public function test_batch_shifting_sends_post_request(): void
    {
        Http::fake([
            '*batch-shifting*' => Http::response(['message' => 'Success'], 200),
        ]);

        $response = $this->client->batchShifting(['batch_shift' => [
            'reg_no' => 'REG1001',
            'shift_date' => '2026-03-09',
        ]]);

        $this->assertTrue($response->isSuccessful());

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'batch-shifting')
                && $request->method() === 'POST';
        });
    }

    public function test_handles_api_error_response(): void
    {
        Http::fake([
            '*enroll-student*' => Http::response(['message' => 'Validation failed'], 422),
        ]);

        $response = $this->client->enrollStudent(['enrollments' => []]);

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertEquals('Validation failed', $response->getMessage());
    }

    public function test_handles_server_error_response(): void
    {
        Http::fake([
            '*enroll-student*' => Http::response(['message' => 'Internal Server Error'], 500),
        ]);

        $response = $this->client->enrollStudent(['enrollments' => []]);

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(500, $response->getStatusCode());
    }

    public function test_api_response_to_array(): void
    {
        Http::fake([
            '*enroll-student*' => Http::response(['message' => 'Success', 'id' => 1], 200),
        ]);

        $response = $this->client->enrollStudent(['enrollments' => []]);
        $array = $response->toArray();

        $this->assertArrayHasKey('success', $array);
        $this->assertArrayHasKey('status_code', $array);
        $this->assertArrayHasKey('message', $array);
        $this->assertArrayHasKey('data', $array);
        $this->assertTrue($array['success']);
        $this->assertEquals(200, $array['status_code']);
    }

    public function test_query_parameters_are_appended_to_url(): void
    {
        Http::fake([
            '*enroll-student*' => Http::response(['message' => 'Success'], 200),
        ]);

        $this->client->enrollStudent(
            ['enrollments' => []],
            ['extra_param' => 'value']
        );

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'extra_param=value')
                && str_contains($request->url(), 'API_KEY=test-api-key');
        });
    }

    public function test_get_request_method(): void
    {
        Http::fake([
            '*some-endpoint*' => Http::response(['message' => 'Success'], 200),
        ]);

        $response = $this->client->get('some-endpoint', ['param' => 'value']);

        $this->assertTrue($response->isSuccessful());

        Http::assertSent(function ($request) {
            return $request->method() === 'GET'
                && str_contains($request->url(), 'some-endpoint')
                && str_contains($request->url(), 'param=value');
        });
    }

    public function test_generic_post_request_method(): void
    {
        Http::fake([
            '*custom-endpoint*' => Http::response(['message' => 'OK'], 200),
        ]);

        $response = $this->client->post('custom-endpoint', ['key' => 'value']);

        $this->assertTrue($response->isSuccessful());

        Http::assertSent(function ($request) {
            return $request->method() === 'POST'
                && str_contains($request->url(), 'custom-endpoint');
        });
    }

    public function test_exception_contains_status_code_and_body(): void
    {
        $exception = new GenesisAccountingException(
            'Test error',
            422,
            ['error' => 'validation']
        );

        $this->assertEquals(422, $exception->getStatusCode());
        $this->assertEquals(['error' => 'validation'], $exception->getResponseBody());
        $this->assertEquals('Test error', $exception->getMessage());
    }
}
