<?php

namespace Sig\FichasocialBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('username', 'text', array(
                'label'         =>  'Nombre de Usuario',
            ))
            ->add('primer_nombre', 'text', array(
                'label'         =>  'Primer Nombre',
                'required'      =>  false,
            ))
            ->add('segundo_nombre', 'text', array(
                'label'         =>  'Segundo Nombre',
                'required'      =>  false,
            ))
            ->add('primer_apellido', 'text', array(
                'label'         =>  'Primer Apellido',
                'required'      =>  false,
            ))
            ->add('segundo_apellido', 'text', array(
                'label'         =>  'Segundo Apellido',
                'required'      =>  false,
            ))
            ->add('telefono', 'text', array(
                'label'         =>  'Teléfono',
                'required'      =>  false,
            ))
            ->add('email', 'text', array(
                'label'         =>  'Email',
            ))
            ->add('password', 'text', array(
                'label'         =>  'Password',
            ))
            ->add('roles', 'choice', array(
                'label'         =>  'Rol',
                'multiple'      =>  true,
                'expanded'      =>  true,
                'choices'       =>  array(
                    'ROLE_ADMIN'    =>  'Administrador',
                ),
                'required'      =>  false,
//                'attr'          =>  array('align_with_widget' => true),
            ))
            ->add('enabled', 'choice', array(
                'label'         =>  'Estado',
                'choices'       =>  array(
                    '1'         =>  'Habilitado',
                    '0'         =>  'Deshabilitado',
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
            'data_class' => 'Sig\FichasocialBundle\Entity\Usuario'
        ));
    }
/*
    public function getParent()
    {
        return 'fos_user_registration';
    }
*/
    /**
     * @return string
     */
    public function getName()
    {
        return 'sig_fichasocialbundle_usuario';
    }
}
