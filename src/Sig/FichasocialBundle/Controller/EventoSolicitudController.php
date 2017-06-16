<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\EventoSolicitud;
use Sig\FichasocialBundle\Form\EventoSolicitudType;

/**
 * EventoSolicitud controller.
 *
 */
class EventoSolicitudController extends Controller
{

    /**
     * Lists all EventoSolicitud entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SigFichasocialBundle:EventoSolicitud')->findAll();

        return $this->render('SigFichasocialBundle:EventoSolicitud:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new EventoSolicitud entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new EventoSolicitud();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('eventossolicitud_show', array('id' => $entity->getId())));
        }

        return $this->render('SigFichasocialBundle:EventoSolicitud:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a EventoSolicitud entity.
     *
     * @param EventoSolicitud $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(EventoSolicitud $entity)
    {
        $form = $this->createForm(new EventoSolicitudType(), $entity, array(
            'action' => $this->generateUrl('eventossolicitud_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => ' Aceptar', 'attr' => array('icon' => 'ok' )));

        return $form;
    }

    /**
     * Displays a form to create a new EventoSolicitud entity.
     *
     */
    public function newAction()
    {
        $entity = new EventoSolicitud();
        $form   = $this->createCreateForm($entity);

        return $this->render('SigFichasocialBundle:EventoSolicitud:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EventoSolicitud entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:EventoSolicitud')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad EventoSolicitud.');
        }

//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:EventoSolicitud:show.html.twig', array(
            'entity'      => $entity,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EventoSolicitud entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:EventoSolicitud')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad EventoSolicitud.');
        }

        $editForm = $this->createEditForm($entity);
//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:EventoSolicitud:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a EventoSolicitud entity.
    *
    * @param EventoSolicitud $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EventoSolicitud $entity)
    {
        $form = $this->createForm(new EventoSolicitudType(), $entity, array(
            'action' => $this->generateUrl('eventossolicitud_update', array('id' => $entity->getId())),
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
     * Edits an existing EventoSolicitud entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:EventoSolicitud')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad EventoSolicitud.');
        }

//        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if ($editForm->get('actions')->get('delete')->isClicked()) {

                $em->remove($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('eventossolicitud'));
            }

            $em->flush();

            return $this->redirect($this->generateUrl('eventossolicitud_show', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:EventoSolicitud:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a EventoSolicitud entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SigFichasocialBundle:EventoSolicitud')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se pudo encontrar la entidad EventoSolicitud.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('eventossolicitud'));
    }

    /**
     * Creates a form to delete a EventoSolicitud entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('eventossolicitud_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => ' Eliminar', 'attr' => array('icon' => 'remove' )))
            ->getForm()
        ;
    }
}
