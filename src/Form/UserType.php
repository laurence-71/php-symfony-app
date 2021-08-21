<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('lastName',TextType::class,[
                'label'=>'Last Name'
            ])
            ->add('firstName',TextType::class,[
                'label'=>'First Name'
            ])
            ->add('email', EmailType::class,[
                'label'=>'Email address'
            ])
            
            ->add('password', RepeatedType::class,[
                'type'=>PasswordType::class,
                'first_options'=>['label'=>'Password'],
                'second_options'=>['label'=>'repeat password'],
                'constraints'=>[
                    new Length([
                        'min'=>8,
                        'minMessage'=>'This is too short, must be at least 8 caracters',
                    ])
                ]
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
