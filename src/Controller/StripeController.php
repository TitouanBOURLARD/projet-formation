<?php

namespace App\Controller;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    /**
     * @Route("/commande/create-session/{reference}", name="app_stripe_create_session")
     */
    public function index(EntityManagerInterface $entityManager, $reference): Response
    {
        Stripe::setApiKey('sk_test_51LOOBmI9qPjCwftSMXwLn1JfDJtOcwQmUDt9lmAd8kVJGIKw7m7MdlDVwusm1QZXQfz1p1BMMHcoSnWyYgg6pKqC00OQ9s3OiJ');
        $domain = 'http://localhost:8000';
        $stripeProducts = [];

        $order = $entityManager->getRepository(Order::class)->findOneByReference($reference);
        if (!$order) {
            $response = new JsonResponse(['error' => 'no order found']);
            return $response;
        }
        
        $items = $order->getOrderDetails()->getValues();

        foreach ($items as $item) {
            $product = $entityManager->getRepository(Product::class)->findOneByName($item->getProduct());
            $stripeProducts[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $item->getPrice(),
                    'product_data' => [
                        'name' => $item->getProduct(),
                        'images' => [$domain . '/uploads/' . $product->getIllustration()]
                    ]
                ],
                'quantity' => $item->getQuantity()
            ];
        }

        $stripeProducts[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $order->getCarrierPrice(),
                'product_data' => [
                    'name' => $order->getCarrierName(),
                    'images' => [$domain]
                ]
            ],
            'quantity' => 1
        ];

        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => $this->getUser()->getEmail(),
            'line_items' => [$stripeProducts],
            'mode' => 'payment',
            'success_url' => $domain . '/commande/confirmation/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $domain . '/commande/annulation/{CHECKOUT_SESSION_ID}',
        ]);

        $order->setStripeSessionId($checkout_session->id);
        $entityManager->flush();
        
        $response = new JsonResponse([
            'id' => $checkout_session->id
        ]);
        return $response;
    }
}
