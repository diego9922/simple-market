<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ShoppingCart;
use App\Entity\CartItem;
use App\Entity\Product;

#[Route('/shopping-cart', name: 'app_shopping_cart_')]
class ShoppingCartController extends AbstractController
{
	private EntityManagerInterface $em;

	public function __construct(
		EntityManagerInterface $em
	){
		$this->em = $em;
	}

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('shoppingCart/index.html.twig', [
            'controller_name' => 'ShoppingCartController',
            'shoppingCart' => $this->em->getRepository(ShoppingCart::class)->findOneBy([])
        ]);
    }

    #[Route('/api/add', name: 'api_add', methods: ['POST'])]
    public function apiAdd(Request $request): JsonResponse
    {
    	$product = $this->em->getRepository(Product::class)->find($request->get('product-id'));
    	$shoppingCart = $this->em->getRepository(ShoppingCart::class)->findOneBy([]);

    	if ($shoppingCart == null) $shoppingCart = new ShoppingCart();

    	$cartItem = (new CartItem())
    		->setProduct($product)
    		->setQuantity($request->get('product-quantity'));
    	$shoppingCart->addCartItem($cartItem);

    	if(!$shoppingCart->getCartItems()->contains($cartItem)){
    		return new JsonResponse([
    			'message' => "It is not possible add the quantity required, check the quantity available or this already has been added."
    		], 400);
    	}

    	$this->em->persist($shoppingCart);
    	$this->em->flush();
        return new JsonResponse([
        	'message' => 'Cart item has been added.',
        	'cartItem' => [
	        	'product' => [
	        		'id' => $product->getId(),
	        		'name' => $product->getName(),
	        		'unitPrice' => $product->getUnitPrice()
	        	],
        		'quantity' => $cartItem->getQuantity(),
        		'itemPrice' => $product->calculateProductPrice($cartItem->getQuantity())
        	]
        ], 200);
    }

    #[Route('/api/remove/{id}', name: 'api_remove', methods: ['DELETE'])]
    public function removeCartitem(int $id): JsonResponse
    {
    	try {
    		$cartItem = $this->em->getRepository(CartItem::class)->find($id);
    		$this->em->remove($cartItem);
    		$this->em->flush();
    		return new JsonResponse([
    			'message' => $cartItem->getProduct()->getName()." has been removed",
    			'cartItemRemoved' => [
		        	'product' => [
		        		'id' => $cartItem->getProduct()->getId(),
		        		'name' => $cartItem->getProduct()->getName(),
		        		'unitPrice' => $cartItem->getProduct()->getUnitPrice()
		        	],
	        		'quantity' => $cartItem->getQuantity(),
	        		'itemPrice' => $cartItem->getProduct()->calculateProductPrice($cartItem->getQuantity())
	        	]
    		], 200);
    	} catch (Exception $e) {
    		return new JsonResponse([
    			'message' => 'It is not possible remove cart item'
    		], 500);
    	}
    }
}
