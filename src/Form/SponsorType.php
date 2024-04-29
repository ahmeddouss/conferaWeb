<?php

namespace App\Form;

use App\Entity\Sponsor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SponsorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('email')
            ->add('numtel', IntegerType::class
            )
            ->add('status', ChoiceType::class, [
                'choices' => [
                    '' => '',
                    'Accepted' => 'accepted',
                    'Rejected' => 'rejected',
                ],
                'data' => '', // Set initial value to '
               
                'required' => true,
            ])
            ->add('budget', IntegerType::class, [
                'data' => 0, // Set initial value to 0
            ])
            ->add('cause', ChoiceType::class, [
                'choices' => [
                    '' => '',
                    'Logistic' => 'Logistic',
                    'Financial' => 'Financial',
                    'Personal' => 'Personal',
                ],
                'data' => '', // Set initial value to ''
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sponsor::class,
        ]);
    }
}
