<?php

namespace CLBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Imię: '])
            ->add('surname', null, ['label' => 'Nazwisko: '])
            ->add(
                'groups', EntityType::class,
                [
                    'class' => 'CLBundle\Entity\CGroup',
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                    'label' => 'Grupy:'
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
            'data_class' => 'CLBundle\Entity\Contact'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'clbundle_contact';
    }


}
