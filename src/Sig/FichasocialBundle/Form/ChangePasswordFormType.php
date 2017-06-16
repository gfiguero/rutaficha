<?php

namespace Sig\FichasocialBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraint\UserPassword as OldUserPassword;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

use FOS\UserBundle\Form\Type\ChangePasswordFormType as BaseType;

class ChangePasswordFormType extends BaseType
{

    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (class_exists('Symfony\Component\Security\Core\Validator\Constraints\UserPassword')) {
            $constraint = new UserPassword();
        } else {
            // Symfony 2.1 support with the old constraint class
            $constraint = new OldUserPassword();
        }

        $builder
            ->add('current_password', 'password', array(
                'label'         =>  'Password Actual',
                'mapped'        =>  false,
                'constraints'   =>  $constraint,
            ))
            ->add('password', 'repeated', array(
                'type'              =>  'password',
                'first_options'     =>  array('label' => 'Password'),
                'second_options'    =>  array('label' => 'Confirmación de Password'),
                'invalid_message'   =>  'No coincide la Password',
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention'  => 'change_password',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sig_fichasocial_change_password';
    }
}