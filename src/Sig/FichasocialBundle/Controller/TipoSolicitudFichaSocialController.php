<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\TipoSolicitudFichaSocial;
use Sig\FichasocialBundle\Form\TipoSolicitudFichaSocialType;

/**
 * TipoSolicitudFichaSocial controller.
 *
 */
class TipoSolicitudFichaSocialController extends Controller
{

    /**
     * Lists all TipoSolicitudFichaSocial entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SigFichasocialBundle:TipoSolicitudFichaSocial')->findAll();

        return $this->render('SigFichasocialBundle:TipoSolicitudFichaSocial:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TipoSolicitudFichaSocial entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TipoSolicitudFichaSocial();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tipossolicitudfichasocial_show', array('id' => $entity->getId())));
        }

        return $this->render('SigFichasocialBundle:TipoSolicitudFichaSocial:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TipoSolicitudFichaSocial entity.
     *
     * @param TipoSolicitudFichaSocial $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TipoSolicitudFichaSocial $entity)
    {
        $form = $this->createForm(new TipoSolicitudFichaSocialType(), $entity, array(
            'action' => $this->generateUrl('tipossolicitudfichasocial_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => ' Aceptar', 'attr' => array('icon' => 'ok' )));

        return $form;
    }

    /**
     * Displays a form to create a new TipoSolicitudFichaSocial entity.
     *
     */
    public function newAction()
    {
        $entity = new TipoSolicitudFichaSocial();
        $form   = $this->createCreateForm($entity);

        return $this->render('SigFichasocialBundle:TipoSolicitudFichaSocial:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoSolicitudFichaSocial entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:TipoSolicitudFichaSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad TipoSolicitudFichaSocial.');
        }

//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:TipoSolicitudFichaSocial:show.html.twig', array(
            'entity'      => $entity,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoSolicitudFichaSocial entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:TipoSolicitudFichaSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad TipoSolicitudFichaSocial.');
        }

        $editForm = $this->createEditForm($entity);
//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:TipoSolicitudFichaSocial:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TipoSolicitudFichaSocial entity.
    *
    * @param TipoSolicitudFichaSocial $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TipoSolicitudFichaSocial $entity)
    {
        $form = $this->createForm(new TipoSolicitudFichaSocialType(), $entity, array(
            'action' => $this->generateUrl('tipossolicitudfichasocial_update', array('id' => $entity->getId())),
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
     * Edits an existing TipoSolicitudFichaSocial entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:TipoSolicitudFichaSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad TipoSolicitudFichaSocial.');
        }

//        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if ($editForm->get('actions')->get('delete')->isClicked()) {

                $em->remove($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('tipossolicitudfichasocial'));
            }

            $em->flush();

            return $this->redirect($this->generateUrl('tipossolicitudfichasocial_show', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:TipoSolicitudFichaSocial:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TipoSolicitudFichaSocial entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SigFichasocialBundle:TipoSolicitudFichaSocial')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se pudo encontrar la entidad TipoSolicitudFichaSocial.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tipossolicitudfichasocial'));
    }

    /**
     * Creates a form to delete a TipoSolicitudFichaSocial entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipossolicitudfichasocial_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => ' Eliminar', 'attr' => array('icon' => 'remove' )))
            ->getForm()
        ;
    }
}
