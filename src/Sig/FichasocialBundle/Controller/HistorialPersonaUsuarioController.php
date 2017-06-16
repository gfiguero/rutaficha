<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\HistorialPersonaUsuario;
use Sig\FichasocialBundle\Form\HistorialPersonaUsuarioType;

/**
 * HistorialPersonaUsuario controller.
 *
 */
class HistorialPersonaUsuarioController extends Controller
{

    /**
     * Lists all HistorialPersonaUsuario entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SigFichasocialBundle:HistorialPersonaUsuario')->findAll();

        return $this->render('SigFichasocialBundle:HistorialPersonaUsuario:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new HistorialPersonaUsuario entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new HistorialPersonaUsuario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('historialpersonausuario_show', array('id' => $entity->getId())));
        }

        return $this->render('SigFichasocialBundle:HistorialPersonaUsuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a HistorialPersonaUsuario entity.
     *
     * @param HistorialPersonaUsuario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(HistorialPersonaUsuario $entity)
    {
        $form = $this->createForm(new HistorialPersonaUsuarioType(), $entity, array(
            'action' => $this->generateUrl('historialpersonausuario_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => ' Aceptar', 'attr' => array('icon' => 'ok' )));

        return $form;
    }

    /**
     * Displays a form to create a new HistorialPersonaUsuario entity.
     *
     */
    public function newAction()
    {
        $entity = new HistorialPersonaUsuario();
        $form   = $this->createCreateForm($entity);

        return $this->render('SigFichasocialBundle:HistorialPersonaUsuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a HistorialPersonaUsuario entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:HistorialPersonaUsuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad HistorialPersonaUsuario.');
        }

//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:HistorialPersonaUsuario:show.html.twig', array(
            'entity'      => $entity,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing HistorialPersonaUsuario entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:HistorialPersonaUsuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad HistorialPersonaUsuario.');
        }

        $editForm = $this->createEditForm($entity);
//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:HistorialPersonaUsuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a HistorialPersonaUsuario entity.
    *
    * @param HistorialPersonaUsuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(HistorialPersonaUsuario $entity)
    {
        $form = $this->createForm(new HistorialPersonaUsuarioType(), $entity, array(
            'action' => $this->generateUrl('historialpersonausuario_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Guardar', 'attr' => array('icon' => 'ok')]],
                'delete' => ['type' => 'submit', 'options' => ['label' => ' Eliminar', 'attr' => array('icon' => 'remove', 'class' => 'btn-danger')]],
            ]
        ]);

        return $form;
    }
    /**
     * Edits an existing HistorialPersonaUsuario entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:HistorialPersonaUsuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad HistorialPersonaUsuario.');
        }

//        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if ($editForm->get('actions')->get('delete')->isClicked()) {

                $em->remove($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('historialpersonausuario'));
            }

            $em->flush();

            return $this->redirect($this->generateUrl('historialpersonausuario_show', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:HistorialPersonaUsuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a HistorialPersonaUsuario entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SigFichasocialBundle:HistorialPersonaUsuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se pudo encontrar la entidad HistorialPersonaUsuario.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('historialpersonausuario'));
    }

    /**
     * Creates a form to delete a HistorialPersonaUsuario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('historialpersonausuario_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => ' Eliminar', 'attr' => array('icon' => 'remove' )))
            ->getForm()
        ;
    }
}
