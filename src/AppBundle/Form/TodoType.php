<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('completed')
            ->add('description','text',array(
                'label' => ' ',
                'attr' => array (
                    'placeholder' => 'What should be done?',
                    'id' => 'new-todo',
                    'autofocus' => null
                )))
        ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Todo'
        ));
    }
    public function getName()
    {
        return 'appbundle_todotype';
    }
}