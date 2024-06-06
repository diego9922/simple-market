<?php
namespace App\Entity;

interface PricingStrategyInterface{
	public function calculateProductPrice(float $quantity): float;
}