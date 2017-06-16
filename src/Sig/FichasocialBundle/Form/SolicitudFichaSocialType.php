<?php

namespace Sig\FichasocialBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SolicitudFichaSocialType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo', 'entity', array(
                'class'     => 'SigFichasocialBundle:TipoSolicitudFichaSocial',
                'property'  => 'nombre',
            ))
            ->add('estado', 'entity', array(
                'class'     => 'SigFichasocialBundle:EstadoSolicitudFichaSocial',
                'property'  => 'codigonombre',
            ))
            ->add('notas', 'textarea', array(
                'label'     =>  'Notas',
                'required'  => false            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sig\FichasocialBundle\Entity\SolicitudFichaSocial'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sig_fichasocialbundle_solicitudfichasocial';
    }
}
