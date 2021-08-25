<?php

namespace App\Form;

use App\Entity\Requirement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequirementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('requirementDate',DateTimeType::class,[
                'label'=>'Requirement Date',
                'data'=>new \DateTime('now'),
                'widget'=>'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Requirement::class,
        ]);
    }
}
