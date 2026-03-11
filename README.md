# Genesis Accounting

[![Packagist](https://img.shields.io/packagist/v/medigeneit/genesis-accounting.svg)](https://packagist.org/packages/medigeneit/genesis-accounting)

A Laravel package for seamless integration with the Genesis ERP API system. Supports Laravel 8.x through 12.x and PHP 8.1 through 8.3.

> **Note:** This is an internal package maintained by [Medigene IT](https://github.com/medigeneit). Outside contributions are not accepted.

## Installation

Install via Composer:

```bash
composer require medigeneit/genesis-accounting
```

The package uses Laravel's auto-discovery, so no manual service provider or facade registration is needed.

## Configuration

Add the following variables to your `.env` file:

```env
ERP_API_BASE_URL=https://stepserp.webnstech.net/Webns/steperp/med/
ERP_API_KEY=d0e876fbfb1c0033b14c69281f3ccff1cf908ce2a7b9b7255b1892a90687b33a
```

That's it. No config publishing or additional setup required.

### Optional Configuration

If you need to customize the config file, you can publish it:

```bash
php artisan vendor:publish --tag=genesis-accounting-config
```

You can also set the API timeout (defaults to 30 seconds):

```env
ERP_API_TIMEOUT=30
```

## Usage

### Using the Facade

#### enrollStudent

```php
use Medigeneit\GenesisAccounting\Facades\GenesisAccounting;

$response = GenesisAccounting::enrollStudent([
    'enrollments' => [
        [
            'reg_no' => 'REG1001',
            'full_name' => 'Rahim Uddin',
            'project_code' => '00001',
            'project_name' => 'FCPS Part-I',
            'gender' => 'Male',
            'phone' => '01711111111',
            'email' => 'rahim@gmail.com',
            'course_id' => 101,
            'course_name' => 'Web Development',
            'course_code' => 'WD-01',
            'course_category_id' => 10,
            'course_category_name' => 'IT',
            'branch_id' => 1,
            'batch_id' => 1,
            'batch_name' => 'Batch-15',
            'batch_type' => 'Regular',
            'session_id' => 2026,
            'session_name' => 'Spring 2026',
            'course_fee' => 30000,
            'lecture_sheet_fee' => 2000,
            'courier_fee' => 100,
            'discount_amount' => 1000,
            'payment' => [
                'payment_method' => 'BKASH',
                'payment_gateway' => 'BKASH',
                'transaction_id' => 'XDASDFASFD',
                'gateway_reference' => '',
                'mobile_ac_number' => '01711111111',
                'mobile_number' => '01711111111',
                'card_type' => '',
                'card_last4' => '',
                'card_issuer' => '',
                'bank_name' => '',
                'bank_account' => '',
                'currency' => 'BDT',
                'payment_amount' => 3000.00,
                'gateway_fee' => 0.00,
                'payment_status' => 'SUCCESS',
                'ip_address' => '',
                'device_info' => '',
                'remarks' => 'Online payment',
            ],
        ],
    ],
]);
```

#### doctorPayment

```php
$response = GenesisAccounting::doctorPayment([
    'payments' => [
        [
            'reg_no' => 'DOC12345',
            'payment_date' => '2026-03-08',
            'payment_date_time' => '2026-03-08 01:01:01 PM',
            'payment_method' => 'BKASH',
            'payment_gateway' => 'BKASH',
            'transaction_id' => 'TXN789456123',
            'gateway_reference' => 'REF123456',
            'order_id' => 'ORD20260308-001',
            'mobile_ac_number' => '01711111111',
            'mobile_number' => '01712345678',
            'card_type' => '',
            'card_last4' => '',
            'card_issuer' => '',
            'bank_name' => '',
            'bank_account' => '',
            'currency' => 'BDT',
            'payment_amount' => 5000.00,
            'gateway_fee' => 50.00,
            'payment_status' => 'SUCCESS',
            'ip_address' => '192.168.1.100',
            'device_info' => 'Chrome on Windows 10',
            'remarks' => 'March consultation fee',
            'payment_for' => 'Student Fee',
            'entryById' => 'E00001',
            'entryByName' => 'Alice',
        ],
    ],
]);
```

#### customerPayment

```php
$response = GenesisAccounting::customerPayment([
    'payments' => [
        [
            'customer_id' => 'DOC67890',
            'payment_date' => '2026-03-08',
            'payment_date_time' => '2026-03-08 01:01:01 PM',
            'payment_method' => 'CASH',
            'payment_gateway' => '',
            'transaction_id' => '',
            'gateway_reference' => '',
            'order_id' => '',
            'mobile_ac_number' => '01711111111',
            'mobile_number' => '',
            'card_type' => '',
            'card_last4' => '',
            'card_issuer' => '',
            'bank_name' => '',
            'bank_account' => '',
            'currency' => 'BDT',
            'payment_amount' => 3000.00,
            'gateway_fee' => 0.00,
            'payment_status' => 'SUCCESS',
            'ip_address' => '',
            'device_info' => '',
            'remarks' => 'Onsite payment',
            'payment_for' => 'Sales',
            'entryById' => 'E00001',
            'entryByName' => 'Alice',
        ],
    ],
]);
```

#### sales

```php
$response = GenesisAccounting::sales([
    'SALESHeader' => [
        [
            'invoiceNo' => 'INV-20260308-001',
            'invoiceDate' => '2026-03-08',
            'customerCode' => 'CUST001',
            'customerName' => 'John Doe',
            'customerPhone' => '017XXXXXXXX',
            'customerAddress' => '123, Main Street, Dhaka',
            'invoiceMode' => 'Cash',
            'totalAmount' => 5000.00,
            'totalDiscount' => 200.00,
            'totalVatAmount' => 450.00,
            'deliveryCharge' => 50.00,
            'netAmount' => 5300.00,
            'invoiceType' => 'Cash',
            'salesPersonId' => 'E00001',
            'salesPerson' => 'Alice',
            'paymentStatus' => 'Paid',
            'payment' => [
                'payment_method' => 'CASH',
                'payment_gateway' => '',
                'transaction_id' => '',
                'gateway_reference' => '',
                'order_id' => '',
                'mobile_number' => '',
                'card_type' => '',
                'card_last4' => '',
                'card_issuer' => '',
                'bank_name' => '',
                'bank_account' => '',
                'currency' => 'BDT',
                'payment_amount' => 3000.00,
                'gateway_fee' => 0.00,
                'payment_status' => 'SUCCESS',
                'ip_address' => '',
                'device_info' => '',
                'remarks' => 'Onsite payment',
                'paymnet_for' => 'Sales',
            ],
            'SALESDetails' => [
                [
                    'itemCode' => 'ITEM001',
                    'itemName' => 'Paracetamol 500mg',
                    'packSize' => '10x10',
                    'uom' => 'Box',
                    'salesQty' => 2,
                    'unitPrice' => 200.00,
                    'unitVatPrct' => 15.00,
                    'unitDiscount' => 5.00,
                    'totalLineCost' => 390.00,
                ],
                [
                    'itemCode' => 'ITEM002',
                    'itemName' => 'Amoxicillin 250mg',
                    'packSize' => '10x10',
                    'uom' => 'Box',
                    'salesQty' => 1,
                    'unitPrice' => 300.00,
                    'unitVatPrct' => 15.00,
                    'unitDiscount' => 0.00,
                    'totalLineCost' => 345.00,
                ],
            ],
        ],
    ],
]);
```

#### salesReturn

```php
$response = GenesisAccounting::salesReturn([
    'SALESReturnHeader' => [
        [
            'returnNo' => 'RET-20260308-001',
            'returnDate' => '2026-03-08',
            'originalInvoiceNo' => 'INV-20260308-001',
            'customerCode' => 'CUST001',
            'customerName' => 'John Doe',
            'customerPhone' => '017XXXXXXXX',
            'customerAddress' => '123, Main Street, Dhaka',
            'returnMode' => 'Cash',
            'totalReturnAmount' => 1000.00,
            'totalDiscount' => 50.00,
            'totalVatAmount' => 90.00,
            'netReturnAmount' => 1040.00,
            'returnReason' => 'Damaged Product',
            'salesPerson' => 'Alice',
            'refundStatus' => 'Refunded',
            'entryById' => 'E001',
            'entryByName' => 'asad',
            'refund' => [
                'payment_method' => 'CASH',
                'payment_gateway' => '',
                'transaction_id' => '',
                'gateway_reference' => '',
                'order_id' => '',
                'mobile_number' => '',
                'card_type' => '',
                'card_last4' => '',
                'card_issuer' => '',
                'bank_name' => '',
                'bank_account' => '',
                'currency' => 'BDT',
                'payment_amount' => 1040.00,
                'gateway_fee' => 0.00,
                'payment_status' => 'SUCCESS',
                'ip_address' => '',
                'device_info' => '',
                'remarks' => 'Refund for returned sales',
                'payment_for' => 'Sales Return',
            ],
            'SALESReturnDetails' => [
                [
                    'itemCode' => 'ITEM001',
                    'itemName' => 'Paracetamol 500mg',
                    'packSize' => '10x10',
                    'uom' => 'Box',
                    'returnQty' => 1,
                    'unitPrice' => 200.00,
                    'unitVatPrct' => 15.00,
                    'unitDiscount' => 5.00,
                    'totalLineCost' => 195.00,
                    'returnReason' => 'Damaged strip',
                ],
                [
                    'itemCode' => 'ITEM002',
                    'itemName' => 'Amoxicillin 250mg',
                    'packSize' => '10x10',
                    'uom' => 'Box',
                    'returnQty' => 1,
                    'unitPrice' => 300.00,
                    'unitVatPrct' => 15.00,
                    'unitDiscount' => 0.00,
                    'totalLineCost' => 345.00,
                    'returnReason' => 'Expired',
                ],
            ],
        ],
    ],
]);
```

#### salarySheet

```php
$response = GenesisAccounting::salarySheet([
    'salaryMonth' => '2026-03',
    'salaryType' => 'Monthly',
    'salary_Prepared_by' => 'E0001',
    'company_name' => 'GENESIS',
    'employeeSalaries' => [
        [
            'employeeId' => 'EMP001',
            'employeeName' => 'Rahim Uddin',
            'department' => 'Accounts',
            'designation' => 'Account Officer',
            'bankAccount' => '1234567890',
            'bankName' => 'DBBL',
            'basicSalary' => 30000.00,
            'houseRent' => 15000.00,
            'medicalAllowance' => 3000.00,
            'conveyanceAllowance' => 2000.00,
            'otherAllowance' => 1000.00,
            'grossSalary' => 51000.00,
            'taxDeduction' => 2000.00,
            'pfDeduction' => 1500.00,
            'loanDeduction' => 1000.00,
            'otherDeduction' => 500.00,
            'totalDeduction' => 5000.00,
            'netSalary' => 46000.00,
            'paymentMethod' => 'BANK',
            'paymentStatus' => 'Pending',
            'remarks' => 'March salary',
        ],
    ],
]);
```

#### batchShifting

```php
$response = GenesisAccounting::batchShifting([
    'batch_shift' => [
        'shift_date' => '2026-03-09',
        'shift_reason' => 'Schedule conflict',
        'reg_no' => 'REG1001',
        'new_reg_no' => 'REG1002',
        'shifting_type' => 'NEW_BATCH',
        'used_amount' => 3000,
        'batch_shifting_fee' => 2000,
        'adjustment_amount' => 2000,
        'rest_amount' => 2000,
        'new_batch' => [
            'reg_no' => 'REG1001',
            'full_name' => 'Rahim Uddin',
            'gender' => 'Male',
            'phone' => '01711111111',
            'email' => 'rahim@gmail.com',
            'project_code' => '00001',
            'project_name' => 'FCPS Part-I',
            'course_id' => 101,
            'course_name' => 'Web Development',
            'course_code' => 'WD-01',
            'course_category_id' => 10,
            'course_category_name' => 'IT',
            'branch_id' => 1,
            'batch_name' => 'Batch-15',
            'batch_id' => 1333,
            'batch_type' => 'Regular',
            'session_id' => 2026,
            'session_name' => 'Spring 2026',
            'course_fee' => 30000,
            'lecture_sheet_fee' => 2000,
            'discount_amount' => 1000,
            'prev_batch_rest_amount' => 2000,
            'payment' => [
                'payment_method' => 'BKASH',
                'payment_gateway' => 'BKASH',
                'transaction_id' => 'XDASDFASFD',
                'gateway_reference' => '',
                'mobile_ac_number' => '01711111111',
                'mobile_number' => '01711111111',
                'card_type' => '',
                'card_last4' => '',
                'card_issuer' => '',
                'bank_name' => '',
                'bank_account' => '',
                'currency' => 'BDT',
                'payment_amount' => 3000.00,
                'gateway_fee' => 0.00,
                'payment_status' => 'SUCCESS',
                'ip_address' => '',
                'device_info' => '',
                'remarks' => 'Online payment',
            ],
        ],
    ],
]);
```

### Using Dependency Injection

```php
use Medigeneit\GenesisAccounting\GenesisAccountingClient;

class MyController extends Controller
{
    public function store(GenesisAccountingClient $erp)
    {
        $response = $erp->enrollStudent([
            'enrollments' => [/* ... */],
        ]);

        if ($response->isSuccessful()) {
            return response()->json($response->getData());
        }

        return response()->json([
            'error' => $response->getMessage(),
        ], $response->getStatusCode());
    }
}
```

### Generic Requests

For any custom endpoint:

```php
// GET request
$response = GenesisAccounting::get('custom-endpoint', ['param' => 'value']);

// POST request
$response = GenesisAccounting::post('custom-endpoint', ['key' => 'value']);
```

### Response Handling

All methods return an `ApiResponse` object:

```php
$response = GenesisAccounting::enrollStudent($data);

$response->isSuccessful();  // bool
$response->getStatusCode(); // int (HTTP status code)
$response->getData();       // array (response body)
$response->getMessage();    // string
$response->toArray();       // ['success' => bool, 'status_code' => int, 'message' => string, 'data' => array]
```

### Error Handling

```php
use Medigeneit\GenesisAccounting\Exceptions\GenesisAccountingException;

try {
    $response = GenesisAccounting::enrollStudent($data);
} catch (GenesisAccountingException $e) {
    $e->getMessage();      // Error message
    $e->getStatusCode();   // HTTP status code
    $e->getResponseBody(); // Response body as array
}
```

## Available Methods

| Method | HTTP | Endpoint |
|---|---|---|
| `enrollStudent(array $data, array $query)` | POST | `/enroll-student` |
| `doctorPayment(array $data, array $query)` | POST | `/doctor-payment` |
| `customerPayment(array $data, array $query)` | POST | `/customer-payment` |
| `sales(array $data, array $query)` | POST | `/sales` |
| `salesReturn(array $data, array $query)` | POST | `/sales-return` |
| `salarySheet(array $data, array $query)` | POST | `/salary-sheet` |
| `batchShifting(array $data, array $query)` | POST | `/batch-shifting` |
| `get(string $endpoint, array $query)` | GET | Custom |
| `post(string $endpoint, array $data, array $query)` | POST | Custom |

## Testing

```bash
composer test
```

## Support

- **Issues:** [GitHub Issues](https://github.com/medigeneit/genesis-accounting/issues)
- **Source:** [GitHub Repository](https://github.com/medigeneit/genesis-accounting)
- **Packagist:** [medigeneit/genesis-accounting](https://packagist.org/packages/medigeneit/genesis-accounting)

## License

MIT - [Medigene IT](https://github.com/medigeneit)
