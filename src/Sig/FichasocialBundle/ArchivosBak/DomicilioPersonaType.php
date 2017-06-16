<?php

namespace Sig\FichasocialBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DomicilioPersonaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('calle', 'text', array(
                'label'         =>  'Calle',
                'mapped'        =>  false,
                'required'      =>  true,
                'data'          =>  $entity->getDomicilioId()->getCalle(),
            ))
            ->add('numero', 'text', array(
                'label'         =>  'Número',
                'mapped'        =>  false,
                'required'      =>  true,
                'data'          =>  $entity->getDomicilioId()->getNumero(),
            ))
            ->add('complemento', 'text', array(
                'label'         =>  'Complemento',
                'mapped'        =>  false,
                'required'      =>  false,
                'data'          =>  $entity->getDomicilioId()->getComplemento(),
            ))
            ->add('domicilio_id', 'hidden', array(
                'label'         =>  'Id Domicilio',
                'read_only'     =>  'true',
                'mapped'        =>  false,
                'data'          =>  $entity->getDomicilioId()->getId(),
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sig\FichasocialBundle\Entity\Persona'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sig_fichasocialbundle_persona';
    }
}
