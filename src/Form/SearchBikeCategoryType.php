<?php

namespace App\Form;

use App\Entity\Bike;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchBikeCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          
            ->add('category', ChoiceType::class,[
                'label'=>"Category",
                'choices'=>[
                    'Urban'=>'Urban',
                    'Fitness'=>'Fitness',
                    'AllTrack'=>'AllTrack',
                     'VTT'=>'VTT',
                    'DH'=>'DH',
                ],
                'required'=>false,
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bike::class,
        ]);
    }
}
