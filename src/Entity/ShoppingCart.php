<?php

namespace App\Entity;

use App\Repository\ShoppingCartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShoppingCartRepository::class)]
class ShoppingCart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, CartItem>
     */
    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: 'shoppingCart', orphanRemoval: true, cascade:["persist"])]
    private Collection $cartItems;

    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, CartItem>
     */
    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }

    public function addCartItem(CartItem $cartItem): static
    {
    	// validate ShoppingCart not contain CartItem and the product quantity in inventory is valid
    	if((!$this->cartItems->contains($cartItem)) && ($cartItem->getProduct()->getInventory()->getQuantityAvailableSale() >= $cartItem->getQuantity())){
    		$this->cartItems->add($cartItem);
            $cartItem->setShoppingCart($this);
    	}
        return $this;
    }

    public function removeCartItem(CartItem $cartItem): static
    {
        if ($this->cartItems->removeElement($cartItem)) {
            // set the owning side to null (unless already changed)
            if ($cartItem->getShoppingCart() === $this) {
                $cartItem->setShoppingCart(null);
            }
        }

        return $this;
    }

    public function calculateTotal():float
    {
    	return $this->cartItems->reduce(function(float $total, CartItem $cartItem): float {
    		return $total + $cartItem->getProduct()->calculateProductPrice($cartItem->getQuantity());
    	}, 0);
    }
}
