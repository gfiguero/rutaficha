<?php

namespace Sig\FichasocialBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PropiedadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('calle', 'hidden')
            ->add('calle_id', 'autocomplete', array(
                'class'         =>  'SigFichasocialBundle:Calle',
                'label'         =>  'Calle',
            ))
            ->add('numero', 'integer', array(
                'label'         =>  'Número',
            ))
            ->add('complemento', 'text', array(
                'label'         =>  'Complemento',
                'required'      =>  false
            ))
            ->add('rol', 'text', array(
                'label'         =>  'Rol',
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sig\FichasocialBundle\Entity\Propiedad'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sig_fichasocialbundle_propiedad';
    }
}
