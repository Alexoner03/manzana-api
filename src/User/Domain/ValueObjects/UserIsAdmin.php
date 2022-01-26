<?php
declare(strict_types=1);

namespace Src\User\Domain\ValueObjects;

final class UserIsAdmin
{
    private bool $value;

    public function __construct(bool $isAdmin)
    {
        $this->value = $isAdmin;
    }

    public function value(): bool
    {
        return $this->value;
    }
}
