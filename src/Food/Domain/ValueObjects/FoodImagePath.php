<?php
declare(strict_types=1);

namespace Src\Food\Domain\ValueObjects;

final class FoodImagePath
{
    private string $value;

    public function __construct(string $imagePath)
    {
        $this->value = $imagePath;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
