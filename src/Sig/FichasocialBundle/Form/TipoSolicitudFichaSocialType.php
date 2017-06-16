<?php

namespace Sig\FichasocialBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TipoSolicitudFichaSocialType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            /*->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')*/
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sig\FichasocialBundle\Entity\TipoSolicitudFichaSocial'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sig_fichasocialbundle_tiposolicitudfichasocial';
    }
}
