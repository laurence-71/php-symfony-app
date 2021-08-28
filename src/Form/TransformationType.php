<?php

namespace App\Form;

use App\Entity\Transformation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('article_label',TextType::class,[
                'label'=>'Article label'
            ])
            ->add('destination',TextType::class,[
                'label'=>'Destination'
            ])
            ->add('quantity',NumberType::class,[
                'label'=>'Quantity'
            ])
            //->add('recycling')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transformation::class,
        ]);
    }
}
