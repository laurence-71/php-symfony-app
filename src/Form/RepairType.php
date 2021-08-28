<?php

namespace App\Form;

use App\Entity\Repair;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepairType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('takingCareDate',DateTimeType::class,[
                'label'=>'Taking Care Date',
                'data'=>new \DateTime('now'),
                'widget'=>'single_text'
            ])
            //->add('doneDate')
            ->add('laborCost',NumberType::class,[
                'label'=>'Labor Cost in Euro'
            ])
           
            ->add('comments',TextareaType::class,[
                'label'=>'Comments',
                'required'=>false
            ])
            //->add('validation')
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
