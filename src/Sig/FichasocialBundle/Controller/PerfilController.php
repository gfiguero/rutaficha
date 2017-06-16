<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\Usuario;
use Sig\FichasocialBundle\Form\UsuarioType;

/**
 * Usuario controller.
 *
 */
class PerfilController extends Controller
{

    public function showAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
        $entity = $em->getRepository('SigFichasocialBundle:Usuario')->find($usuario->getId());
        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Usuario.');
        }
        return $this->render('SigFichasocialBundle:Perfil:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    public function editAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
        $entity = $em->getRepository('SigFichasocialBundle:Usuario')->find($usuario->getId());
        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Usuario.');
        }
        $editForm = $this->createEditForm($entity);
        return $this->render('SigFichasocialBundle:Perfil:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('perfil_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->remove('username');
        $form->add('username', 'hidden');
        $form->remove('password');
        $form->remove('roles');
        $form->remove('enabled');

        $form->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Guardar', 'attr' => array('icon' => 'ok')]],
            ]
        ]);

        return $form;
    }
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
        $entity = $em->getRepository('SigFichasocialBundle:Usuario')->find($usuario->getId());

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Usuario.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $userManager = $this->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($editForm->get('username')->getdata());
            $user->setPrimerNombre($editForm->get('primer_nombre')->getdata());
            $user->setSegundoNombre($editForm->get('segundo_nombre')->getdata());
            $user->setPrimerApellido($editForm->get('primer_apellido')->getdata());
            $user->setSegundoApellido($editForm->get('segundo_apellido')->getdata());
            $user->setTelefono($editForm->get('telefono')->getdata());
            $user->setEmail($editForm->get('email')->getdata());

            $userManager->updateUser($user);
            $em->flush();
              $request->getSession()->getFlashBag()->add(
                'noticia',
                'Su información personal fue modificada satisfactoriamente'
            );

            return $this->redirect($this->generateUrl('perfil'));

        }

        return $this->render('SigFichasocialBundle:Perfil:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    public function passwordAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
        $entity = $em->getRepository('SigFichasocialBundle:Usuario')->find($usuario->getId());
        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Usuario.');
        }
        $passwordForm = $this->createPasswordForm($entity);
        return $this->render('SigFichasocialBundle:Perfil:password.html.twig', array(
            'entity'      => $entity,
            'password_form'   => $passwordForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createPasswordForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('perfil_password_update'),
            'method' => 'PUT',
        ));

        $form->remove('username');
        $form->remove('primer_nombre');
        $form->remove('segundo_nombre');
        $form->remove('primer_apellido');
        $form->remove('segundo_apellido');
        $form->remove('telefono');
        $form->remove('email');
        $form->remove('password');
        $form->remove('roles');
        $form->remove('enabled');
        $form->add('username', 'hidden');
//        $form->add('password', 'password');
        $form->add('password', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'Nueva Password no coincide con Confirmar Password',
            'options' => array('attr' => array('class' => 'password-field')),
            'required' => true,
            'first_options'  => array('label' => 'Nueva Password'),
            'second_options' => array('label' => 'Confirmar Password'),
        ));

        $form->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Guardar', 'attr' => array('icon' => 'ok')]],
            ]
        ]);

        return $form;
    }

    public function passwordUpdateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
        $entity = $em->getRepository('SigFichasocialBundle:Usuario')->find($usuario->getId());
        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Usuario.');
        }
        $passwordForm = $this->createPasswordForm($entity);
        $passwordForm->handleRequest($request);

        if ($passwordForm->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->findUserByUsername($passwordForm->get('username')->getdata());
            $user->setPlainPassword($passwordForm->get('password')->getdata());
            $userManager->updateUser($user);
            $em->flush();
              $request->getSession()->getFlashBag()->add(
                'noticia',
                'Su contraseña fue modificada satisfactoriamente'
            );
            return $this->redirect($this->generateUrl('perfil'));
        }

        return $this->render('SigFichasocialBundle:Perfil:password.html.twig', array(
            'password_form'   => $passwordForm->createView(),
        ));
    }

}