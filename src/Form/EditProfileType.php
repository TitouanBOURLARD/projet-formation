<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Nouvel email : ',
                'attr' => [
                    'placeholder' => 'Veuillez changer votre email',
                ]
            ])
            // ->add('password', RepeatedType::class, [
            //     'invalid_message' => 'Les mots de passent doivent être identiques.',
            //     'required' => false,
            //     'first_options' => [
            //         'label' => 'Mot de passe : ',
            //         'data' => '',
            //         'attr' => [
            //             'placeholder' => 'Entrez un nouveau mot de passe si souhaité',
            //         ]
            //     ],
            //     'second_options' => [
            //         'label' => 'Confirmation : ',
            //         'data' => '',
            //         'attr' => [
            //             'placeholder' => 'Confirmez votre nouveau mot de passe',
            //         ]
            //     ]
            // ])
            ->add('firstname', TextType::class, [
                'label' => 'Nouveau prénom : ',
                'attr' => [
                    'placeholder' => 'Veuillez changer votre prénom',
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nouveau nom : ',
                'attr' => [
                    'placeholder' => 'Veuillez changer votre nom',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider ces changements'
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
