<?php

namespace App\Form;

use App\Entity\Organisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganisationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation_sociale', TextType::class, [
                'label' => 'Désignation sociale (requis)',
                'required' => true,
                'attr'=>[
                    'placeholder'=>'Désignation Sociale'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email (requis)',
                'required' => true,
                'attr'=>[
                    'placeholder'=>'Email'
                    ]
            ])
            ->add('phone', TextType::class, [   
                'label' => 'N° téléphone',
                'required' => false,
                'attr'=>[
                    'placeholder'=>'Téléphone'
                    ]
            ])
            ->add('rue', TextType::class, [
                'label' => 'Rue',
                'required' => false,
                'attr'=>[
                    'placeholder'=>'Rue'
                    ]
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'required' => false,
                'attr'=>[
                    'placeholder'=>'Ville'
                    ]
            ])
            ->add('code_postal', TextType::class, [ 
                'label' => 'Code postale',
                'required' => false,
                'attr'=>[
                    'placeholder'=>'Code postal'
                    ]
            ])
            ->add('siret', IntegerType::class, [
                'label' => 'SIRET (requis)',
                'required' => true,
                'attr'=>[
                    'placeholder'=>'SIRET'
                    ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Organisation::class,
        ]);
    }
}