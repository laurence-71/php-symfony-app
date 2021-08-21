<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class,[
                'label'=>'Last Name'
            ])
            ->add('firstName', TextType::class,[
                'label'=>'First Name'
            ])
            ->add('email', EmailType::class,[
                'label'=>"Email address",
                'constraints'=>[
                    new NotBlank([
                        'message'=>'Thanks to give a valid email address'
                    ])
                    ],
                    'required'=>true,
                    'attr'=>[
                        'class'=>'form-control'
                    ]
            ])
            ->add('roles', ChoiceType::class,[
                'label'=>'Role',
                'choices'=>[
                    'User'=>'ROLE_USER',
                    'Manager'=>'ROLE_MANAGER',
                ],
                'expanded'=>true,
                'multiple'=>true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
