<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EditProfileController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/profile/edit", name="app_edit_profile")
     */

    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        // if($this->getUser()){
        //     return $this->redirectToRoute("home");
        // }
       
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $user->getPassword();
            $user = $form->getData();
            // dd($form['password']->getData());
            if (empty($user->getPassword())){
                $user->setPassword($oldPassword);
            }
            else {
                $new_password = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($new_password);
            }

            // $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash('success', 'Profil mis à jour');
            
            return $this->redirectToRoute('app_profile');
        }


        return $this->render('edit_profile/index.html.twig' , [
            'form' => $form->createView()
        ]);
    }
}
