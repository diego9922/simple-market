<?php

namespace App\Entity;

use App\Repository\CountableProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeightedProductRepository::class)]
class WeightedProduct extends Product implements PricingStrategyInterface
{
	const UNIT_MEASUREMENT = 'kg';
	const QUANTITY_FOR_DISCOUNT = 10;
	const VALUE_TO_DISCOUNT = 0.1;

    public function calculateProductPrice(float $quantity):float
    {
    	$price = $this->getUnitPrice() * $quantity;
    	if ($quantity > self::QUANTITY_FOR_DISCOUNT){
    		$price = $price - ($price * self::VALUE_TO_DISCOUNT);
    	}
    	return $price;
    }
}
