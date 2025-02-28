<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CreateClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'form-control'
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'form-control'
                ],
            ])
            ->add('email', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'form-control'
                ],
            ])
            ->add('rue', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Rue',
                    'class' => 'form-control'
                ],
            ])
            ->add('ville', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'form-control'
                ],
            ])
            ->add('code_postal', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Code postale',
                    'class' => 'form-control'
                ],
            ])
            ->add('tel_portable', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Téléphone mobile',
                    'class' => 'form-control'
                ],
            ])
            ->add('tel_fixe', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Téléphone fixe',
                    'class' => 'form-control'
                ],
            ])
            ->add('fax', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'fax',
                    'class' => 'form-control'
                ],
            ])
            ->add('raison_sociale', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Raison sociale',
                    'class' => 'form-control'
                ],
            ])
            ->add('siret', IntegerType::class, [
                'label' => false,
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
            'data_class' => User::class,
        ]);
    }
}
