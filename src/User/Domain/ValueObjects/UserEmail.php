<?php
declare(strict_types=1);

namespace Src\User\Domain\ValueObjects;

use InvalidArgumentException;

final class UserEmail
{
    private string $value;

    /**
     * UserEmail constructor.
     * @param string $email
     * @throws InvalidArgumentException
     */
    public function __construct(string $email)
    {
        $this->validate($email);
        $this->value = $email;
    }

    /**
     * @param string $email
     * @throws InvalidArgumentException
     */
    private function validate(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow the invalid email: <%s>.', UserEmail::class, $email)
            );
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
