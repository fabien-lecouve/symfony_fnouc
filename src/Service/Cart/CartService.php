<?php

namespace App\Service\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    protected $requestStack;
    protected $productRepository;

    public function __construct(RequestStack $requestStack, ProductRepository $productRepository)
    {
        $this->requestStack = $requestStack;
        $this->productRepository = $productRepository;
    }

    public function getFullCart(): array
    {
        $cart = $this->requestStack->getSession()->get('cart', []);

        $cartWithData = [];

        foreach ( $cart as $id => $quantity )
        {
            $cartWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $cartWithData;
    }

    public function getTotal(): int 
    {
        $total = 0;

        foreach ( $this->getFullCart() as $cart )
        {
            $total += $cart['product']->getUnitPrice() * $cart['quantity'];
        }
        return $total;
    }

    public function add($id)
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        if ( !empty($cart[$id]))
        {
            $cart[$id]++;
        }
        else
        {
            $cart[$id] = 1;
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }

    public function remove($id)
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        if ( !empty($cart[$id]))
        {
            unset($cart[$id]);
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }
}