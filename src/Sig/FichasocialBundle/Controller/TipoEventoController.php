<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\TipoEvento;
use Sig\FichasocialBundle\Form\TipoEventoType;

/**
 * TipoEvento controller.
 *
 */
class TipoEventoController extends Controller
{

    /**
     * Lists all TipoEvento entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SigFichasocialBundle:TipoEvento')->findAll();

        return $this->render('SigFichasocialBundle:TipoEvento:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TipoEvento entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TipoEvento();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tiposevento_show', array('id' => $entity->getId())));
        }

        return $this->render('SigFichasocialBundle:TipoEvento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TipoEvento entity.
     *
     * @param TipoEvento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TipoEvento $entity)
    {
        $form = $this->createForm(new TipoEventoType(), $entity, array(
            'action' => $this->generateUrl('tiposevento_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => ' Aceptar', 'attr' => array('icon' => 'ok' )));

        return $form;
    }

    /**
     * Displays a form to create a new TipoEvento entity.
     *
     */
    public function newAction()
    {
        $entity = new TipoEvento();
        $form   = $this->createCreateForm($entity);

        return $this->render('SigFichasocialBundle:TipoEvento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoEvento entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:TipoEvento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad TipoEvento.');
        }

//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:TipoEvento:show.html.twig', array(
            'entity'      => $entity,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoEvento entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:TipoEvento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad TipoEvento.');
        }

        $editForm = $this->createEditForm($entity);
//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:TipoEvento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TipoEvento entity.
    *
    * @param TipoEvento $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TipoEvento $entity)
    {
        $form = $this->createForm(new TipoEventoType(), $entity, array(
            'action' => $this->generateUrl('tiposevento_update', array('id' => $entity->getId())),
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
     * Edits an existing TipoEvento entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:TipoEvento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad TipoEvento.');
        }

//        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if ($editForm->get('actions')->get('delete')->isClicked()) {

                $em->remove($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('tiposevento'));
            }

            $em->flush();

            return $this->redirect($this->generateUrl('tiposevento_show', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:TipoEvento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TipoEvento entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SigFichasocialBundle:TipoEvento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se pudo encontrar la entidad TipoEvento.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tiposevento'));
    }

    /**
     * Creates a form to delete a TipoEvento entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tiposevento_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => ' Eliminar', 'attr' => array('icon' => 'remove' )))
            ->getForm()
        ;
    }
}
