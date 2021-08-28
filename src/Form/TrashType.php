<?php

namespace App\Form;

use App\Entity\Trash;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrashType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nature',TextType::class,[
                'label'=>'Nature'
            ])
            ->add('weight',NumberType::class,[
                'label'=>'Weight in kg'
            ])
            //->add('recycling')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trash::class,
        ]);
    }
}
