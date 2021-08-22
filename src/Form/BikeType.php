<?php

namespace App\Form;

use App\Entity\Bike;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BikeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('serialNumber',TextType::class,[
                'label'=>"Serial Number"
            ])
            ->add('brand',TextType::class,[
                'label'=>"Brand",
                'required'=>false,
            ])
            ->add('category',ChoiceType::class,[
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
            ->add('color', TextType::class,[
                'label'=>"Color",
                'required'=>false,
            ])
            ->add('size',ChoiceType::class,[
                'label'=>"Size",
                'choices'=>[
                    'XS'=>'XS',
                    'S'=>'S',
                    'M'=>'M',
                    'L'=>'L',
                    'XL'=>'XL',
                    'XXL'=>'XXL',
                ],
                'required'=>false,
            ])
            ->add('weight',NumberType::class,[
                'required'=>false,
            ])
           // ->add('source')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bike::class,
        ]);
    }
}
