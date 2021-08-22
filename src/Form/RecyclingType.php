<?php

namespace App\Form;

use App\Entity\Recycling;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecyclingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recyclingDate', DateTimeType::class,[
                'label'=>'Recycling Date',
                'data'=>new \DateTime('now'),
                'widget'=>'single_text'
            ])
            //->add('operation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recycling::class,
        ]);
    }
}
