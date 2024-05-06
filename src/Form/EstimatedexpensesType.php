<?php

namespace App\Form;

use App\Entity\Estimatedexpenses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstimatedexpensesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('expensesway')
            ->add('pessimisticexpenses')
            ->add('realisticexpenses')
            ->add('optimisticexpenses')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Estimatedexpenses::class,
        ]);
    }
}
