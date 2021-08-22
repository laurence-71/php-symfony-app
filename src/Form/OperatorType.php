<?php

namespace App\Form;

use App\Entity\Operator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName',TextType::class,[
                'label'=>'Last Name',
                
            ])
            ->add('firstName',TextType::class,[
                'label'=>'First Name',
               
            ])
            ->add('role', ChoiceType::class,[
                'label'=>'Role',
                'choices'=>[
                    'Manager'=>'Manager',
                    'Assistant manager'=>'Assistant Manager',
                    'Operator'=>'Operator'
                ]
            ])
            //->add('operation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operator::class,
        ]);
    }
}
