<?php

namespace App\Entity;

use App\Repository\CountableProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountableProductRepository::class)]
class CountableProduct extends Product
{

    
}
