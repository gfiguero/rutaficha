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
class UsuarioController extends Controller
{

    /**
     * Lists all Usuario entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SigFichasocialBundle:Usuario')->findAll();

        return $this->render('SigFichasocialBundle:Usuario:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Usuario entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Usuario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($entity);
//            $em->flush();
//            return $this->redirect($this->generateUrl('usuarios_show', array('id' => $entity->getId())));
            $userManager = $this->get('fos_user.user_manager');

            $user = $userManager->createUser();
            $user->setUsername($form->get('username')->getdata());
            $user->setEmail($form->get('email')->getdata());
            $user->setPlainPassword($form->get('password')->getdata());
            $user->setPrimerNombre($form->get('primer_nombre')->getdata());
            $user->setSegundoNombre($form->get('segundo_nombre')->getdata());
            $user->setPrimerApellido($form->get('primer_apellido')->getdata());
            $user->setSegundoApellido($form->get('segundo_apellido')->getdata());
            $user->setTelefono($form->get('telefono')->getdata());
            $user->setRoles($form->get('roles')->getdata());
            $user->setEnabled(true);

            $userManager->updateUser($user);
            $request->getSession()->getFlashBag()->add(
                'noticia',
                'El usuario fue creado satisfactoriamente'
            );    
            return $this->redirect($this->generateUrl('usuarios'));
        }

        return $this->render('SigFichasocialBundle:Usuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Usuario entity.
     *
     * @param Usuario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuarios_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => ' Aceptar', 'attr' => array('icon' => 'ok' )));

        return $form;
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     */
    public function newAction()
    {
        $entity = new Usuario();
        $form   = $this->createCreateForm($entity);

        return $this->render('SigFichasocialBundle:Usuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Usuario entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Usuario.');
        }

        return $this->render('SigFichasocialBundle:Usuario:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Usuario.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('SigFichasocialBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     */
    public function passwordAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Usuario.');
        }

        $passwordForm = $this->createPasswordForm($entity);

        return $this->render('SigFichasocialBundle:Usuario:password.html.twig', array(
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
    private function createEditForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuarios_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->remove('username');
        $form->add('username', 'hidden');
        $form->remove('password');

        $form->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Guardar', 'attr' => array('icon' => 'ok')]],
            ]
        ]);

        return $form;
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
            'action' => $this->generateUrl('usuarios_password_update', array('id' => $entity->getId())),
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
        $form->add('password', 'password');

        $form->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Guardar', 'attr' => array('icon' => 'ok')]],
            ]
        ]);

        return $form;
    }

    public function passwordUpdateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Usuario')->find($id);

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
            $request->getSession()->getFlashBag()->add(
                'noticia',
                'La contraseña fue modificada satisfactoriamente'
            );
            return $this->redirect($this->generateUrl('usuarios'));

        }

        return $this->render('SigFichasocialBundle:Usuario:password.html.twig', array(
            'password_form'   => $passwordForm->createView(),
        ));
    }
    /**
     * Edits an existing Usuario entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Usuario.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $userManager = $this->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($editForm->get('username')->getdata());
            $user->setEmail($editForm->get('email')->getdata());
            $user->setPrimerNombre($editForm->get('primer_nombre')->getdata());
            $user->setSegundoNombre($editForm->get('segundo_nombre')->getdata());
            $user->setPrimerApellido($editForm->get('primer_apellido')->getdata());
            $user->setSegundoApellido($editForm->get('segundo_apellido')->getdata());
            $user->setTelefono($editForm->get('telefono')->getdata());
            $user->setRoles($editForm->get('roles')->getdata());
            $user->setEnabled($editForm->get('enabled')->getdata());

            $userManager->updateUser($user);
            $request->getSession()->getFlashBag()->add(
                'noticia',
                'El usuario fue modificado satisfactoriamente'
            );
            return $this->redirect($this->generateUrl('usuarios'));

        }

        return $this->render('SigFichasocialBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Usuario entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SigFichasocialBundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se pudo encontrar la entidad Usuario.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('usuarios'));
    }

    /**
     * Creates a form to delete a Usuario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuarios_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => ' Eliminar', 'attr' => array('icon' => 'remove' )))
            ->getForm()
        ;
    }

    /********************************/

    public function profileShowAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
        $entity = $em->getRepository('SigFichasocialBundle:Usuario')->find($usuario->getId());

        return $this->render('SigFichasocialBundle:Usuario:profileShow.html.twig', array(
            'entity'      => $entity,
        ));
    }

    public function profileEditAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
        $entity = $em->getRepository('SigFichasocialBundle:Usuario')->find($usuario->getId());

        $profileForm = $this->createProfileForm($entity);

       

        return $this->render('SigFichasocialBundle:Usuario:profileEdit.html.twig', array(
            'entity'        => $entity,
            'profile_form'  => $profileForm->createView(),
        ));

    }

    public function profileUpdateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
        $entity = $em->getRepository('SigFichasocialBundle:Usuario')->find($usuario->getId());

        $profileForm = $this->createProfileForm($entity);
        $profileForm->handleRequest($request);

        if ($profileForm->isValid()) {

            
            return $this->redirect($this->generateUrl('usuarios_profile_show'));
        }

        return $this->render('SigFichasocialBundle:Usuario:perfileditar.html.twig', array(
            'entity'        => $entity,
            'profile_form'  => $profileForm->createView(),
        ));
    }

    private function createProfileEditForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuarios_profile_update'),
            'method' => 'PUT',
        ));

        $form->remove('password');

        $form->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Guardar', 'attr' => array('icon' => 'ok')]],
            ]
        ]);

        return $form;
    }

}