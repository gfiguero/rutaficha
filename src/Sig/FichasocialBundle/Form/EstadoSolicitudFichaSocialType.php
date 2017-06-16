<?php

namespace Sig\FichasocialBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EstadoSolicitudFichaSocialType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('codigo')
            ->add('descripcion')
            ->add('locked', 'choice', array(
                'label'     =>  'Asignación a Ruta',
                'choices'   =>  array(
                    '0'     =>  'Desbloqueada',
                    '1'     =>  'Bloqueada'
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sig\FichasocialBundle\Entity\EstadoSolicitudFichaSocial'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sig_fichasocialbundle_estadosolicitudfichasocial';
    }
}
