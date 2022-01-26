<?php
declare(strict_types=1);

namespace Src\User\Domain\ValueObjects;

class UserLastName
{
    private string $value;

    public function __construct(string $lastName)
    {
        $this->value = $lastName;
    }

    public function value(): string
    {
        return $this->value;
    }
}
