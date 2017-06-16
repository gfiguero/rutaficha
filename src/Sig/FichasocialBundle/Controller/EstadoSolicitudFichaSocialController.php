<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\EstadoSolicitudFichaSocial;
use Sig\FichasocialBundle\Form\EstadoSolicitudFichaSocialType;

/**
 * EstadoSolicitudFichaSocial controller.
 *
 */
class EstadoSolicitudFichaSocialController extends Controller
{

    /**
     * Lists all EstadoSolicitudFichaSocial entities.
     *
     */
    public function indexAction($pagina)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SigFichasocialBundle:EstadoSolicitudFichaSocial')->findBy(array(), array('codigo' => 'ASC'));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($entities, $pagina, 30);

        return $this->render('SigFichasocialBundle:EstadoSolicitudFichaSocial:index.html.twig', array(
            'entities'      => $entities,
            'pagination'    => $pagination,
        ));
    }
    /**
     * Creates a new EstadoSolicitudFichaSocial entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new EstadoSolicitudFichaSocial();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('estadossolicitudfichasocial_show', array('id' => $entity->getId())));
        }

        return $this->render('SigFichasocialBundle:EstadoSolicitudFichaSocial:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a EstadoSolicitudFichaSocial entity.
     *
     * @param EstadoSolicitudFichaSocial $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(EstadoSolicitudFichaSocial $entity)
    {
        $form = $this->createForm(new EstadoSolicitudFichaSocialType(), $entity, array(
            'action' => $this->generateUrl('estadossolicitudfichasocial_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => ' Aceptar', 'attr' => array('icon' => 'ok' )));

        return $form;
    }

    /**
     * Displays a form to create a new EstadoSolicitudFichaSocial entity.
     *
     */
    public function newAction()
    {
        $entity = new EstadoSolicitudFichaSocial();
        $form   = $this->createCreateForm($entity);

        return $this->render('SigFichasocialBundle:EstadoSolicitudFichaSocial:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EstadoSolicitudFichaSocial entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:EstadoSolicitudFichaSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad EstadoSolicitudFichaSocial.');
        }

//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:EstadoSolicitudFichaSocial:show.html.twig', array(
            'entity'      => $entity,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EstadoSolicitudFichaSocial entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:EstadoSolicitudFichaSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad EstadoSolicitudFichaSocial.');
        }

        $editForm = $this->createEditForm($entity);
//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:EstadoSolicitudFichaSocial:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a EstadoSolicitudFichaSocial entity.
    *
    * @param EstadoSolicitudFichaSocial $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EstadoSolicitudFichaSocial $entity)
    {
        $form = $this->createForm(new EstadoSolicitudFichaSocialType(), $entity, array(
            'action' => $this->generateUrl('estadossolicitudfichasocial_update', array('id' => $entity->getId())),
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
     * Edits an existing EstadoSolicitudFichaSocial entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:EstadoSolicitudFichaSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad EstadoSolicitudFichaSocial.');
        }

//        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if ($editForm->get('actions')->get('delete')->isClicked()) {

                $em->remove($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('estadossolicitudfichasocial'));
            }

            $em->flush();

            return $this->redirect($this->generateUrl('estadossolicitudfichasocial'));
        }

        return $this->render('SigFichasocialBundle:EstadoSolicitudFichaSocial:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a EstadoSolicitudFichaSocial entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SigFichasocialBundle:EstadoSolicitudFichaSocial')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se pudo encontrar la entidad EstadoSolicitudFichaSocial.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('estadossolicitudfichasocial'));
    }

    /**
     * Creates a form to delete a EstadoSolicitudFichaSocial entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estadossolicitudfichasocial_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => ' Eliminar', 'attr' => array('icon' => 'remove' )))
            ->getForm()
        ;
    }
}
