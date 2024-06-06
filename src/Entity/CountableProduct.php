<?php

namespace App\Entity;

use App\Repository\CountableProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class CountableProduct extends Product implements PricingStrategyInterface
{

	const UNIT_MEASUREMENT = 'unit';

    public function calculateProductPrice(float $quantity):float
    {
    	return $this->getUnitPrice() * $quantity;
    }
}
