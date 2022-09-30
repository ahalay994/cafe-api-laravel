<?php

namespace App\DataTransferObjects\Position\Relations;

class PositionObject
{
    public int $id;
    public string $name;
    public string $slug;
    public string $description;
    public ?string $image;
    public ?float $price;
    public ?float $oldPrice;
    public ?int $discount;

    public function __construct(
        int     $id,
        string  $name,
        string  $slug,
        string  $description,
        ?string $image,
        ?float  $price,
        ?float  $oldPrice,
        ?int    $discount
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->description = $description;
        $this->image = $image;
        if ($price) $this->price = $price;
        if ($oldPrice) $this->oldPrice = $oldPrice;
        if ($discount) $this->discount = $discount;
    }
}
