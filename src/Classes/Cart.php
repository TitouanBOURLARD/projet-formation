<?php

namespace App\Classes;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart {
    private $session;

    private $cart = [];

    private $stack = [];

    private $entityManager;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
        $this->cart = $this->session->get('cart', []);
    }


    public function getItems() {
        $this->stack = [];

        if (!empty($this->get())) {
            foreach ($this->get() as $id => $quantity) {
                $this->stack[] = [
                    'product' => $this->entityManager->getRepository(Product::class)->findOneById($id),
                    'quantity' => $quantity
                ];
            }
        }

        return $this->stack;
    }


    public function add($id){
        $product = $this->entityManager->getRepository(Product::class)->findOneById($id);
        
        if (!empty($product)) {
            if (!empty($this->cart[$id])) {
                $this->cart[$id]++;
            } else {
                $this->cart[$id] = 1;
            }

            $this->session->set('cart', $this->cart);
        }

    }

    public function decrease($id) {
        if ($this->cart[$id] > 1) {
            $this->cart[$id]--;
        } else {
            $this->removeItem($id);
        }

        $this->session->set('cart', $this->cart);
    }

    public function removeItem($id) {
        unset($this->cart[$id]);
        $this->session->set('cart', $this->cart);
    }

    public function get() {
        return $this->session->get('cart');
    }

    public function remove() {
        return $this->session->remove('cart');
    }

}