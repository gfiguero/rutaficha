<?php

namespace Sig\FichasocialBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RutaFichaSocialType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $options['id'];
        $builder
            ->add('estado', 'entity', array(
                'class'     => 'SigFichasocialBundle:EstadoRutaFichaSocial',
                'property'  => 'nombre',
            ))
            ->add('encuestador', 'entity', array(
                'class'     => 'SigFichasocialBundle:EncuestadorFichaSocial',
                'property'  => 'nombrecompleto',
                'required'  => false,
            ))
            ->add('solicitudes', 'entity', array(
                'class'     => 'SigFichasocialBundle:SolicitudFichaSocial',
                'property'  =>  'id',
                'query_builder' => function (EntityRepository $er) use ($id) {
                    return $er->createQueryBuilder('s')
                            ->leftJoin('s.estado', 'se')
                            ->leftJoin('s.rutas', 'r')
                            ->leftJoin('r.estado', 're')
                            ->orWhere('r.id = :id')
                            ->orWhere('re.locked = 0 and se.locked = 0')
                            ->orWhere('re.locked IS NULL')
                            ->orderBy('s.id', 'ASC')
                            ->setParameter('id', $id);;
                },
                'multiple'  =>  true,
                'expanded'  =>  true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sig\FichasocialBundle\Entity\RutaFichaSocial',
            'id'       => NULL,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sig_fichasocialbundle_rutafichasocial';
    }
}
