<?php
declare(strict_types=1);

namespace Src\User\Domain\ValueObjects;

final class UserName
{
    private string $value;

    public function __construct(string $name)
    {
        $this->value = $name;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
