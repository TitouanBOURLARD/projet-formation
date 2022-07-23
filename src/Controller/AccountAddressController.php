<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/account/addresses", name="app_account_addresses")
     */
    public function index(): Response
    {
        return $this->render('account/addresses.html.twig', [
            'controller_name' => 'AccountAddressController',
        ]);
    }

    /**
     * @Route("/account/new/address", name="app_account_add_addresse")
     */
    public function add(Request $request): Response
    {

        $address = new Address;
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());

            $this->entityManager->persist($address);
            $this->entityManager->flush();
            
            return $this->redirectToRoute(('app_account_addresses'));
        }

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/account/update/address", name="app_account_update_addresse")
     */
    public function update(): Response
    {
        return $this->render('account/address_form.html.twig', [
            'controller_name' => 'AccountAddressController',
        ]);
    }

    /**
     * @Route("/account/remove/address", name="app_account_remove_addresse")
     */
    public function remove(): Response
    {
        /**
         * process remove
         */
        return $this->redirectToRoute('app_account_addresses');
    }
}
