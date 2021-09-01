<?php

namespace App\Form;

use App\Entity\SecondHandStock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SecondHandStockRequirementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label',TextType::class,[
                'label'=>'Label'
            ])
            ->add('brand',TextType::class,[
                'label'=>'Brand'
            ])
            ->add('unit_price',NumberType::class,[
                'label'=>'Unit Price in Euros',
                'required'=>false
            ])
            //->add('quantity')
            ->add('requirement_quantity',NumberType::class,[
                'label'=>'Requirement Quantity',
                'required'=>false
            ])
            //->add('requirement')
            //->add('recycling')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SecondHandStock::class,
        ]);
    }
}
