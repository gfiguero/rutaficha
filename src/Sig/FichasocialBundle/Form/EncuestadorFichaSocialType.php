<?php

namespace Sig\FichasocialBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EncuestadorFichaSocialType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rut', 'text', array(
                'label'         =>  'Rut',
            ))
            ->add('primer_nombre', 'text', array(
                'label'         =>  'Primer Nombre',
            ))
            ->add('segundo_nombre', 'text', array(
                'label'         =>  'Segundo Nombre',
            ))
            ->add('primer_apellido', 'text', array(
                'label'         =>  'Primer Apellido',
            ))
            ->add('segundo_apellido', 'text', array(
                'label'         =>  'Segundo Apellido',
            ))
            ->add('email', 'text', array(
                'label'         =>  'Email',
            ))
            ->add('celular', 'text', array(
                'label'         =>  'Celular',
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sig\FichasocialBundle\Entity\EncuestadorFichaSocial'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sig_fichasocialbundle_encuestadorfichasocial';
    }
}
