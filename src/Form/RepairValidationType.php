<?php

namespace App\Form;

use App\Entity\Repair;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepairValidationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('takingCareDate')
            ->add('doneDate',DateTimeType::class,[
                'label'=>'Done Date',
                'data'=>new \DateTime('now'),
                'widget'=>'single_text'
            ])
            //->add('laborCost')
            //->add('comments')
            ->add('validation',CheckboxType::class,[
                'label'=>'Validation',
                'required'=>true,
            ])
           //->add('operation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Repair::class,
        ]);
    }
}
