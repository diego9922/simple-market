<?php

namespace App\Entity;

use App\Repository\CountableProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeightedProductRepository::class)]
class WeightedProduct extends Product
{

    
}
