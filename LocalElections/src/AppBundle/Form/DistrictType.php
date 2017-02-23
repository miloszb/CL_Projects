<?php

namespace AppBundle\Form;

use AppBundle\Entity\District;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DistrictType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('locality', null, ['label' => 'Nazwa jednostki: '])
            ->add('number', null, ['label' => 'Nr okręgu: '])
            ->add('description', null, ['label' => 'Opis: '])
            ->add(
                'level',
                ChoiceType::class,
                [
                    'choices' => [
                        District::NAMES[District::QRT] => District::QRT,
                        District::NAMES[District::MNP] => District::MNP,
                        District::NAMES[District::MA1] => District::MA1,
                        District::NAMES[District::MA2] => District::MA2,
                        District::NAMES[District::MA3] => District::MA3,
                        District::NAMES[District::CNT] => District::CNT,
                        District::NAMES[District::VOI] => District::VOI,
                    ],
                    'choices_as_values' => true,
                    'label' => 'Rodzaj wyborów: '
                ]
            )
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\District'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_district';
    }


}
