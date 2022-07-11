<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Votre email : ',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre adresse email'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passent doivent être identiques.',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe : ',
                    'attr' => [
                        'placeholder' => 'Saisissez votre mot de passe',
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation : ',
                    'attr' => [
                        'placeholder' => 'Confirmez votre mot de passe',
                    ]
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom : ',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre prénom',
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom : ',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre nom',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Inscription'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
