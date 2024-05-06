<?php

namespace App\Form;

use App\Entity\Logistic;
use App\Entity\Logisticincome;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LogisticincomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('logsponsorname')
            ->add('logincomeqty')
            ->add('logproof')
            ->add('id', EntityType::class, [
                'class' => Logistic::class,
                'choice_label' => 'providedLog',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Logisticincome::class,
        ]);
    }
}
