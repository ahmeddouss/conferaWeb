<?php

namespace App\Form;

use App\Entity\Conference;
use App\Entity\Emplacement;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
class ConferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
            'attr' => ['placeholder' => 'Enter conference name...'],// Placeholder for nom field
            'label' => 'Name', 
             ])
            ->add('date', DateType::class, [
                'data' => new \DateTime(),
                'widget' => 'single_text',
            ])
            ->add('sujet', TextareaType::class, [
                'label' => 'Topic',
                'attr' => [
                    
                    'rows' => 10,
                    'cols' => '50',
                    'placeholder' => 'Enter conference description...', // Placeholder for sujet field
                    
                ],
                
            ])
            ->add('budget', MoneyType::class, [
                'attr' => ['placeholder' => 'Enter conference budget...'], // Placeholder for budget field
            ])
            ->add('typeconf', null, [
                'label' => 'Private',
            ]
            )
            ->add('photo',FileType::class,[
                'required' => false,
                'mapped' => false,
            ])

            ->add('emplacement',EntityType::class,[
                'class' => Emplacement::class,
                'choice_label'=>'label',
              
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conference::class,
        ]);
    }
}
