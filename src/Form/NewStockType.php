<?php

namespace App\Form;

use App\Entity\NewStock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label',TextType::class,[
                'label'=>'Label'
            ])
            ->add('brand', TextType::class,[
                'label'=>'Brand'
            ])
            ->add('unit_price',NumberType::class,[
                'label'=>'Unit Price in Euros',
                'required'=>false,

            ])
            ->add('quantity',NumberType::class,[
                'label'=>'Quantity',
                'required'=>false,
                
            ])
            //->add('requirement_quantity')
           //->add('requirement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewStock::class,
        ]);
    }
}
