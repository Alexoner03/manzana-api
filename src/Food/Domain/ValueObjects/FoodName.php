<?php
declare(strict_types=1);

namespace Src\Food\Domain\ValueObjects;

final class FoodName
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
