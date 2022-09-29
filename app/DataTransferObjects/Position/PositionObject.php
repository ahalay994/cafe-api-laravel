<?php

namespace App\DataTransferObjects\Position;

use function Symfony\Component\Translation\t;

class PositionObject
{
    public ?string $image;
    public float $price;
    public int $discount;

    public function __construct($image, $price, $discount)
    {
        $this->image = $image;
        $this->price = $price;
        $this->discount = $discount;
    }
}

