<?php

namespace App\Form;

use App\Entity\Emplacement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmplacementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('gouvernourat', null, [
            'attr' => ['placeholder' => 'Enter gouvernourat...']
        ])
        ->add('ville', null, [
            'attr' => ['placeholder' => 'Enter ville...']
        ])
        ->add('capacite', null, [
            'attr' => ['placeholder' => 'Enter capacite...']
        ])
        ->add('label', null, [
            'attr' => ['placeholder' => 'Enter label...']
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emplacement::class,
        ]);
    }
}
