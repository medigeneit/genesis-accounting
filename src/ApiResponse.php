<?php

namespace Medigeneit\GenesisAccounting;

class ApiResponse
{
    protected bool $success;
    protected int $statusCode;
    protected array $data;
    protected string $message;

    public function __construct(bool $success, int $statusCode, array $data = [], string $message = '')
    {
        $this->success = $success;
        $this->statusCode = $statusCode;
        $this->data = $data;
        $this->message = $message;
    }

    public function isSuccessful(): bool
    {
        return $this->success;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'status_code' => $this->statusCode,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }
}
