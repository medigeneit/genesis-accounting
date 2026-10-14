<?php

namespace Medigeneit\GenesisAccounting\Exceptions;

use Exception;

class GenesisAccountingException extends Exception
{
    protected int $statusCode;
    protected array $responseBody;

    public function __construct(
        string $message = '',
        int $statusCode = 0,
        array $responseBody = [],
        ?Exception $previous = null
    ) {
        $this->statusCode = $statusCode;
        $this->responseBody = $responseBody;

        parent::__construct($message, $statusCode, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getResponseBody(): array
    {
        return $this->responseBody;
    }
}
