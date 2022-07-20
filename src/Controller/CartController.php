<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_index')]
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['GET'])]
    public function add($id, CartService $cartService): Response
    {
        $cartService->add($id);
        
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove', methods: ['GET'])]
    public function remove($id, CartService $cartService): Response
    {
        $cartService->remove($id);
        
        return $this->redirectToRoute('cart_index');
    }
}
