<?php

namespace App\Form;

use App\Entity\Source;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('origin',TextType::class,[
                'label'=>'Origin',
                'required'=>true,
            ])
            ->add('purpose',TextType::class,[
                'label'=>'Purpose',
                'required'=>true,
            ])
            ->add('depositDate',DateTimeType::class,[
                'label'=>'Deposit Date',
                'data'=> new \DateTime('now'),
                'widget'=>'single_text',

            ])
            ->add('telephone',TextType::class,[
                'label'=>'Phone Number',
                'required'=>false
            ])
            ->add('email',EmailType::class,[
                'label'=>'Email address',
                'required'=>false,
            ])
            ->add('address',TextareaType::class,[
                'label'=>"Address",
                'required'=>false,
            ])
            ->add('rgpd',CheckboxType::class,[
                'label'=>'You have been informed and accepted that your collected data will not be used for commercial purposes and will be automatically destroyed after 2 years of inactivity on your part or at your request',
                'required'=>true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Source::class,
        ]);
    }
}
