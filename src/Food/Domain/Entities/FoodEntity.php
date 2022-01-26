<?php
declare(strict_types=1);

namespace Src\Food\Domain\Entities;

use Src\Food\Domain\ValueObjects\FoodDescription;
use Src\Food\Domain\ValueObjects\FoodId;
use Src\Food\Domain\ValueObjects\FoodImagePath;
use Src\Food\Domain\ValueObjects\FoodName;

final class FoodEntity
{
    private FoodId $id;
    private FoodDescription $description;
    private FoodName $name;
    private FoodImagePath $imagePath;

    /**
     * @param FoodId $id
     * @param FoodDescription $description
     * @param FoodName $name
     * @param FoodImagePath $imagePath
     */
    public function __construct(FoodId $id, FoodDescription $description, FoodName $name, FoodImagePath $imagePath)
    {
        $this->id = $id;
        $this->description = $description;
        $this->name = $name;
        $this->imagePath = $imagePath;
    }

    /**
     * @return FoodDescription
     */
    public function getDescription(): FoodDescription
    {
        return $this->description;
    }

    /**
     * @param FoodDescription $description
     */
    public function setDescription(FoodDescription $description): void
    {
        $this->description = $description;
    }

    /**
     * @return FoodName
     */
    public function getName(): FoodName
    {
        return $this->name;
    }

    /**
     * @param FoodName $name
     */
    public function setName(FoodName $name): void
    {
        $this->name = $name;
    }

    /**
     * @return FoodImagePath
     */
    public function getImagePath(): FoodImagePath
    {
        return $this->imagePath;
    }

    /**
     * @param FoodImagePath $imagePath
     */
    public function setImagePath(FoodImagePath $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    /**
     * @return FoodId
     */
    public function getId(): FoodId
    {
        return $this->id;
    }

    /**
     * @param FoodId $id
     */
    public function setId(FoodId $id): void
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function getArrayValues(): array
    {
        return [
            "id" => $this->id->value(),
            "description" => $this->description->value(),
            "name" => $this->name->value(),
            "imagePath" => $this->imagePath->value(),
        ];
    }

}
