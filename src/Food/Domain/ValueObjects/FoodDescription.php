<?php
declare(strict_types=1);

namespace Src\Food\Domain\ValueObjects;

final class FoodDescription
{
    private string $value;

    public function __construct(string $description)
    {
        $this->value = $description;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

}
