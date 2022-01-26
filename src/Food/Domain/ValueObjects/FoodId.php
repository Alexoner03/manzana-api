<?php
declare(strict_types=1);

namespace Src\Food\Domain\ValueObjects;

use InvalidArgumentException;

final class FoodId
{
    private int $value;

    /**
     * UserId constructor.
     * @param int $id
     * @throws InvalidArgumentException
     */
    public function __construct(int $id)
    {
        $this->validate($id);
        $this->value = $id;
    }

    /**
     * @param int $id
     * @throws InvalidArgumentException
     */
    private function validate(int $id): void
    {
        $options = array(
            'options' => array(
                'min_range' => 1,
            )
        );

        if (!filter_var($id, FILTER_VALIDATE_INT, $options)) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow the value <%s>.', FoodId::class, $id)
            );
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
