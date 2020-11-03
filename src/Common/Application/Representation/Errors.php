<?php declare(strict_types=1);

namespace App\Common\Application\Representation;

class Errors
{
    /** @var Error[] */
    private array $errors;

    /**
     * Errors constructor.
     * @param Error[] $errors
     */
    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return Error[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}