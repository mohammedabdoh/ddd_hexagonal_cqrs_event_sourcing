<?php declare(strict_types=1);

namespace App\Application\Representation;

class Error
{
    private string $message;
    private int $code;

    public function __construct(string $message, int $code)
    {
        $this->message = $message;
        $this->code = $code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}