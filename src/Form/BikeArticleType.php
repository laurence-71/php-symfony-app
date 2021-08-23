<?php

namespace App\Form;

use App\Entity\BikeArticle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BikeArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('main',ChoiceType::class,[
                'label'=>'Main',
                'choices'=>[
                    'Frame'=>'Frame',
                    'Fork'=>'Fork',
                    'Handlebar_Stem'=>'Handlebar_stem',
                    'Headset'=>'Headset',
                    'Handle'=>'Handle',
                    'Saddles'=>'Saddle',
                    'Seatpost'=>'Seatpost'

                ],
                'expanded'=>true,
                'multiple'=>true,
                'required'=>false,
            ])
            ->add('brake',ChoiceType::class,[
                'label'=>'Brake',
                'choices'=>[
                    'Brake Levers'=>'Brake Levers',
                    'Cable'=>'Cable',
                    'Cable Housing'=>'Cable Housing',
                    'Caliper'=>'Caliper',
                    'Brake Disc'=>'Brake Disc',
                    'Brake Pad'=>'Brake Pad',

                ],
                'expanded'=>true,
                'multiple'=>true,
                'required'=>false,
            ])
            ->add('wheel',ChoiceType::class,[
                'label'=>'Wheel',
                'choices'=>[
                    'Tyre'=>'Tyre',
                    'Inner Tube'=>'Inner Tube',
                    'Wheel Rim'=>'Wheel Rime',
                ],
                'expanded'=>true,
                'multiple'=>true,
                'required'=>false,
            ])
            ->add('transmission',ChoiceType::class,[
                'label'=>'Transmission',
                'choices'=>[
                    'Chain'=>'Chain',
                    'Cassette'=>'Cassette',
                    'Front derailleur'=>'front derailleur',
                    'Rear derailleur'=>'Rear derailleur',
                    'Cable'=>'Cable',
                    'Cable Housing'=>'Cable Housing',
                    'Groupset'=>'Groupset',
                ],
                'expanded'=>true,
                'multiple'=>true,
                'required'=>false,
            ])
            ->add('crank',ChoiceType::class,[
                'label'=>'Crankset',
                'choices'=>[
                    'Crank'=>'crank',
                     'Pedal'=>'Pedal'
                ],
                'expanded'=>true,
                'multiple'=>true,
                'required'=>false,
               
            ])
            ->add('security', ChoiceType::class,[
                'label'=>'Security',
                'choices'=>[
                    'Light'=>'Light',
                    'Reflector'=>'Reflector',
                    'Bell'=>'Bell',
                ],
                'expanded'=>true,
                'multiple'=>true,
                'required'=>false,
            ])
            ->add('comments',TextareaType::class,[
                'label'=>'Comments',
                'required'=>false,
            ])
            //->add('repair')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BikeArticle::class,
        ]);
    }
}
