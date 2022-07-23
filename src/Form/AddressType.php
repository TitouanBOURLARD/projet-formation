<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Libellé de l'adresse",
                'attr' => [
                    'placeholder' => 'ex: domicile'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => "Prénom",
                'attr' => [
                    'placeholder' => 'Veuillez indiquer votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => "Nom",
                'attr' => [
                    'placeholder' => 'Veuillez indiquer votre nom'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => "Adresse",
                'attr' => [
                    'placeholder' => 'Veuillez indiquer votre adresse'
                ]
            ])
            ->add('company', TextType::class, [
                'label' => "Société (facultatif)",
                'required' => false,
                'attr' => [
                    'placeholder' => 'Veuillez indiquer le nom de votre société'
                ]
            ])
            ->add('zipcode', TextType::class, [
                'label' => "Code postal",
                'attr' => [
                    'placeholder' => 'Veuillez indiquer votre code postal'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => "Ville",
                'attr' => [
                    'placeholder' => 'Veuillez indiquer une ville'
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => "Pays",
                'attr' => [
                    'placeholder' => 'Veuillez indiquer un pays'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => "N° de téléphone",
                'attr' => [
                    'placeholder' => 'Veuillez indiquer votre numéro de téléphone'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
