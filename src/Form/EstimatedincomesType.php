<?php

namespace App\Form;

use App\Entity\Estimatedincomes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstimatedincomesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('incomesource')
            ->add('pessimisticincome')
            ->add('realisticincome')
            ->add('optimisticincome')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Estimatedincomes::class,
        ]);
    }
}
