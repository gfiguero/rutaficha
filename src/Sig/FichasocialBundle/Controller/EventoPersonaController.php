<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\EventoPersona;
use Sig\FichasocialBundle\Form\EventoPersonaType;

/**
 * EventoPersona controller.
 *
 */
class EventoPersonaController extends Controller
{

    /**
     * Lists all EventoPersona entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SigFichasocialBundle:EventoPersona')->findAll();

        return $this->render('SigFichasocialBundle:EventoPersona:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new EventoPersona entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new EventoPersona();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('eventospersona_show', array('id' => $entity->getId())));
        }

        return $this->render('SigFichasocialBundle:EventoPersona:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a EventoPersona entity.
     *
     * @param EventoPersona $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(EventoPersona $entity)
    {
        $form = $this->createForm(new EventoPersonaType(), $entity, array(
            'action' => $this->generateUrl('eventospersona_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => ' Aceptar', 'attr' => array('icon' => 'ok' )));

        return $form;
    }

    /**
     * Displays a form to create a new EventoPersona entity.
     *
     */
    public function newAction()
    {
        $entity = new EventoPersona();
        $form   = $this->createCreateForm($entity);

        return $this->render('SigFichasocialBundle:EventoPersona:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EventoPersona entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:EventoPersona')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad EventoPersona.');
        }

//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:EventoPersona:show.html.twig', array(
            'entity'      => $entity,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EventoPersona entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:EventoPersona')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad EventoPersona.');
        }

        $editForm = $this->createEditForm($entity);
//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:EventoPersona:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a EventoPersona entity.
    *
    * @param EventoPersona $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EventoPersona $entity)
    {
        $form = $this->createForm(new EventoPersonaType(), $entity, array(
            'action' => $this->generateUrl('eventospersona_update', array('id' => $entity->getId())),
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
     * Edits an existing EventoPersona entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:EventoPersona')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad EventoPersona.');
        }

//        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if ($editForm->get('actions')->get('delete')->isClicked()) {

                $em->remove($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('eventospersona'));
            }

            $em->flush();

            return $this->redirect($this->generateUrl('eventospersona_show', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:EventoPersona:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a EventoPersona entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SigFichasocialBundle:EventoPersona')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se pudo encontrar la entidad EventoPersona.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('eventospersona'));
    }

    /**
     * Creates a form to delete a EventoPersona entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('eventospersona_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => ' Eliminar', 'attr' => array('icon' => 'remove' )))
            ->getForm()
        ;
    }
}
