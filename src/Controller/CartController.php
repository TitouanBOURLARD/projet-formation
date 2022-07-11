<?php

namespace App\Controller;

use App\Classes\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/mon-panier", name="app_cart")
     */
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getItems(),
        ]);
    }

    /**
    * @Route("/cart/add/{id}", name="app_add_to_cart")
    */
    public function add(Cart $cart, $id): Response 
    {
        $cart->add($id);
        return $this->redirectToRoute('app_cart');
    }

    /**
    * @Route("/cart/decrease/{id}", name="app_decrease_from_cart")
    */
    public function decrease(Cart $cart, $id): Response 
    {
        $cart->decrease($id);
        return $this->redirectToRoute('app_cart');
    }

    /**
    * @Route("/cart/delete/item/{id}", name="app_remove_from_cart")
    */
    public function removeItem(Cart $cart, $id): Response 
    {
        $cart->removeItem($id);
        return $this->redirectToRoute('app_cart');
    }

    /**
    * @Route("/cart/delete", name="app_remove_cart")
    */
    public function remove(Cart $cart): Response 
    {
        $cart->remove();
        return $this->redirectToRoute('app_cart');
    }
}
