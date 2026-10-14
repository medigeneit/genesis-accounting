<?php

namespace Medigeneit\GenesisAccounting\Facades;

use Medigeneit\GenesisAccounting\ApiResponse;
use Illuminate\Support\Facades\Facade;

/**
 * @method static ApiResponse enrollStudent(array $data = [], array $query = [])
 * @method static ApiResponse doctorPayment(array $data = [], array $query = [])
 * @method static ApiResponse customerPayment(array $data = [], array $query = [])
 * @method static ApiResponse sales(array $data = [], array $query = [])
 * @method static ApiResponse salesReturn(array $data = [], array $query = [])
 * @method static ApiResponse salarySheet(array $data = [], array $query = [])
 * @method static ApiResponse batchShifting(array $data = [], array $query = [])
 * @method static ApiResponse get(string $endpoint, array $query = [])
 * @method static ApiResponse post(string $endpoint, array $data = [], array $query = [])
 *
 * @see \Medigeneit\GenesisAccounting\GenesisAccountingClient
 */
class GenesisAccounting extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'genesis-accounting';
    }
}
