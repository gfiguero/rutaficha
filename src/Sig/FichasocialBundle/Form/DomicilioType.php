<?php

namespace Sig\FichasocialBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DomicilioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('calle', 'text', array(
                'label'         =>  'Calle/Pasaje',
                'required'      =>  false,
            ))
            ->add('numero', 'text', array(
                'label'         =>  'Número',
                'required'      =>  false,
            ))
            ->add('poblacion', 'text', array(
                'label'         =>  'Villa/Población',
                'required'      =>  false,
            ))
            ->add('edificio', 'text', array(
                'label'         =>  'Edificio/Block',
                'required'      =>  false,
            ))
            ->add('departamento', 'text', array(
                'label'         =>  'Departamento/Lote',
                'required'      =>  false,
            ))
            ->add('casa', 'text', array(
                'label'         =>  'Casa/Local/Bodega',
                'required'      =>  false,
            ))
            ->add('chacra', 'text', array(
                'label'         =>  'Chacra',
                'required'      =>  false,
            ))
            ->add('parcela', 'text', array(
                'label'         =>  'Parcela',
                'required'      =>  false,
            ))
            ->add('paradero', 'text', array(
                'label'         =>  'Paradero/Km',
                'required'      =>  false,
            ))
            ->add('sector', 'text', array(
                'label'         =>  'Sector',
                'required'      =>  false,
            ))
            ->add('unidad', 'text', array(
                'label'         =>  'Unidad Vecinal',
                'required'      =>  false,
            ))
/*
            ->add('rol', 'text', array(
                'label'         =>  'Rol',
            ))

            ->add('boton_buscar', 'button', array(
                'label'     =>  'Buscar Rol',
                'attr' => array(
                    'class'    =>  'btn-primary',
                )
            ))
*/
            ->add('rol', 'text', array(
                'label'         =>  'Rol',
                'required'      =>  false,
            ))
            ->add('rolId', 'hidden', array(
                'required'      =>  false,
            ))
/*
            ->add('buscador', 'text', array(
                'mapped'    =>  false,
                'label'     =>  'buscador',
                'attr' => array(
                    'style' => 'inline',
                    'label_col'     =>  2,
                    'simple_col'    =>  6,
                    'align_with_widget'    =>  true,
                )
            ))*/
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sig\FichasocialBundle\Entity\Domicilio'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sig_fichasocialbundle_domicilio';
    }
}
