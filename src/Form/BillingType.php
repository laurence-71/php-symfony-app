<?php

namespace App\Form;

use App\Entity\Billing;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('billingDate',DateType::class,[
                'label'=>'Billing Date',
                'data'=>new \DateTime('now'),
                'widget'=>'single_text',
            ])
            ->add('type', ChoiceType::class,[
                'Repair work'=>'Repair work',
                'Sale'=>'Sale',
            ])
            //->add('operation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Billing::class,
        ]);
    }
}
