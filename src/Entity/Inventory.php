<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventoryRepository::class)]
class Inventory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'inventory', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $Product = null;

    #[ORM\Column]
    private ?float $quantityAvailableSale = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->Product;
    }

    public function setProduct(Product $Product): static
    {
        $this->Product = $Product;

        return $this;
    }

    public function getQuantityAvailableSale(): ?float
    {
        return $this->quantityAvailableSale;
    }

    public function setQuantityAvailableSale(float $quantityAvailableSale): static
    {
        $this->quantityAvailableSale = $quantityAvailableSale;

        return $this;
    }

}
