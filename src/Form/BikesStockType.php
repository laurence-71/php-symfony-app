<?php

namespace App\Form;

use App\Entity\BikesStock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BikesStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('deposit_date',DateTimeType::class,[
                'label'=>'Deposit Date',
                'data'=> new \DateTime('now'),
                'widget'=>'single_text'
            ])
            ->add('image',TextType::class,[
                'label'=>'Link to the bike image'
            ])
            //->add('operation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BikesStock::class,
        ]);
    }
}
