<?php

namespace App\Form;

use App\Entity\Conference;
use App\Entity\Session;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sessionname')
            ->add('starttime', TimeType::class, [
                'widget' => 'single_text',
                'required' => false,
                'empty_data' => null,
                'by_reference' => true,
            ])
            ->add('endtime', TimeType::class, [
                'widget' => 'single_text',
                'required' => false,
                'empty_data' => null,
                'by_reference' => true,
            ])
            //->add('presencenbr')
            //->add('presencequality')
            //->add('presencespent')
            ->add('idconference', EntityType::class, [
                'class' => Conference::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
