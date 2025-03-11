<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CreateClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isPro', CheckboxType::class, [
                'label' => false, // On désactive le label auto
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'data-action' => 'change->form-client#toggleFormPro',
                ],
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom (requis)',
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'form-control'
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'form-control'
                ],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email (requis)',
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'form-control'
                ],
            ])
            ->add('rue', TextType::class, [
                'label' => 'Rue',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rue',
                    'class' => 'form-control'
                ],
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'form-control'
                ],
            ])
            ->add('code_postal', TextType::class, [
                'label' => 'Code postal',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Code postale',
                    'class' => 'form-control'
                ],
            ])
            ->add('tel_portable', TextType::class, [
                'label' => 'N° mobile (requis)',
                'attr' => [
                    'placeholder' => 'Téléphone mobile',
                    'class' => 'form-control'
                ],
            ])
            ->add('tel_fixe', TextType::class, [
                'label' => 'N° fixe',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Téléphone fixe',
                    'class' => 'form-control'
                ],
            ])
            ->add('fax', TextType::class, [
                'label' => 'N° fax',
                'required' => false,
                'attr' => [
                    'placeholder' => 'fax',
                    'class' => 'form-control'
                ],
            ])
            ->add('raison_sociale', TextType::class, [
                'label' => 'Raison sociale',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Raison sociale',
                    'class' => 'form-control'
                ],
            ])
            ->add('siret', IntegerType::class, [
                'label' => 'SIRET',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Siret',
                    'class' => 'form-control'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
