<?php

namespace App\Form;

use App\Entity\SecondHandStock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SecondHandStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('brand')
            ->add('unit_price')
            ->add('quantity')
            ->add('requirement')
            ->add('recycling')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SecondHandStock::class,
        ]);
    }
}
