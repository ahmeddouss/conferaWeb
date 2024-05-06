<?php

namespace App\Form;

use App\Entity\Financialincomes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FinancialincomesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sponsorname')
            ->add('cashin')
            ->add('proof', FileType::class, [
                'label' => 'Proof (PDF or Image file)',
                'required' => false, // Set to true if proof upload is mandatory
                'mapped' => false, // This field will not be mapped directly to the entity
                'attr' => ['accept' => '.pdf,.jpg,.jpeg,.png'], // Specify allowed file types
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Financialincomes::class,
        ]);
    }
}
