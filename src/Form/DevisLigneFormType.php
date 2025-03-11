<?php

namespace App\Form;

use App\Entity\DevisLigne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DevisLigneFormType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prix_unitaire_ht', IntegerType::class, [
                'label' => 'Prix unitaire HT',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix unitaire HT',
                    'min' => 0,
                ]
            ])
            ->add('prix_unitaire_ttc', IntegerType::class, [
                'label' => 'Prix unitaire TTC',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix unitaire TTC',
                    'min' => 0,
                ]
            ])
            ->add('quantite', IntegerType::class, [
                'label' => 'Quantité',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Quantité',
                    'min' => 1,
                    'value'=> 1
                ]
            ])
            ->add('taxe', IntegerType::class, [
                'label' => 'TVA',
                'required' => false,
                'attr' => [
                    'placeholder' => 'TVA',
                    'min' => 0,
                ]
            ])
            ->add('ligne_totale_ht', IntegerType::class, [
                'label' => 'Ligne total HT',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ligne total HT',
                    'min' => 0,
                ]
            ])
            ->add('ligne_totale_ttc', IntegerType::class, [
                'label' => 'Ligne total TTC',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ligne total TTC',
                    'min' => 0,
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Description',
                ]
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DevisLigne::class,
        ]);
    }
}
