<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

// [ORM\MappedSuperclass]
// (repositoryClass: ProductRepository::class)
#[ORM\Entity]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap([CountableProduct::UNIT_MEASUREMENT => CountableProduct::class, WeightedProduct::UNIT_MEASUREMENT => WeightedProduct::class])]
class Product
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $unitPrice = null;

    #[ORM\OneToOne(mappedBy: 'Product', cascade: ['persist', 'remove'])]
    private ?Inventory $inventory = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): static
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getInventory(): ?Inventory
    {
        return $this->inventory;
    }

    public function setInventory(Inventory $inventory): static
    {
        // set the owning side of the relation if necessary
        if ($inventory->getProduct() !== $this) {
            $inventory->setProduct($this);
        }

        $this->inventory = $inventory;

        return $this;
    }

    public function getUnitMeasurement():string
	{
		return static::UNIT_MEASUREMENT;
	}
}
