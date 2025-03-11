<?php

namespace App\Form;

use App\Entity\User;
use App\Form\OrganisationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom (requis)',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom',
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom (requis)',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Prénom',
                ],
            ])
            ->add('tel_portable', TextType::class, [
                'label' => 'N° mobile (requis)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Téléphone Portable',
                ],
            ])
            ->add('tel_fixe', TextType::class, [
                'label' => 'N° fixe',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Téléphone Fixe',
                ],
            ])
            ->add('organisation', OrganisationFormType::class, [
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
