<?php

namespace App\Controller;

use DateTime;
use App\Classes\Cart;
use App\Entity\Order;
use DateTimeImmutable;
use App\Form\OrderType;
use App\Entity\OrderDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande", name="app_order")
     */
    public function index(Cart $cart): Response
    {
        if (empty($cart->getItems())) {
            return $this->redirectToRoute('app_products');
        }

        if (empty($this->getUser()->getAddresses()->getValues())) {
            return $this->redirectToRoute('app_account_add_address');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getItems()
        ]);
    }


    /**
     * @route("/commande/recapitulatif", name="app_order_recap", methods={"POST"})
     */
    public function add(Cart $cart, Request $request): Response {
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $date = new DateTimeImmutable;
            $carriers = $form->get('carriers')->getData();
            $delivery = $form->get('addresses')->getData();

            $deliveryContent  = $delivery->getFirstname() . ' ' . $delivery->getLastname();
            $deliveryContent .= '<br />' . $delivery->getPhone();

            if ($delivery->getCompany()) {
                $deliveryContent .= '<br />' . $delivery->getCompany();
            }

            $deliveryContent .= '<br />' . $delivery->getAddress();
            $deliveryContent .= '<br />' . $delivery->getZipcode() . ' ' . $delivery->getCity();
            $deliveryContent .= '<br />' . $delivery->getCountry();

            $order = new Order;
            $order->setReference($date->format('dmY') . '-' . uniqid());
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($deliveryContent);
            $order->setIsPaid(0);

            $this->entityManager->persist($order);

            foreach ($cart->getItems() as $item) {
                $orderDetails = new OrderDetails;
                $orderDetails->setOrderEntity($order);
                $orderDetails->setProduct($item['product']->getName());
                $orderDetails->setQuantity($item['quantity']);
                $orderDetails->setPrice($item['product']->getPrice());
                $orderDetails->setTotal($item['product']->getPrice() * $item['quantity']);

                $this->entityManager->persist($orderDetails);
            }

            $this->entityManager->flush();


            return $this->render('order/add.html.twig', [
                'cart' => $cart->getItems(),
                'carrier' => $carriers,
                'delivery' => $deliveryContent,
                'reference' => $order->getReference()
            ]);
        }

        return $this->redirectToRoute('app_cart');
    }


    /**
     * @Route("/commande/confirmation/{stripeSessionId}", name="app_order_confirmation")
     */
    public function confirmation($stripeSessionId, Cart $cart): Response {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        
        if ($order && $order->getUser() === $this->getUser()) {
            if (!$order->isIsPaid()) {
                $order->setIsPaid(1);
                $this->entityManager->flush();
                $cart->remove();
            }

            return $this->render('order/confirmation.html.twig', [
                'order' => $order
            ]);
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/commande/annulation/{stripeSessionId}", name="app_order_cancel")
     */
    public function cancel($stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if ($order && $order->getUser() === $this->getUser()) {
            return $this->render('order/cancel.html.twig', [
                'order' => $order
            ]);
        }

        return $this->redirectToRoute('app_cart');
    }
}
