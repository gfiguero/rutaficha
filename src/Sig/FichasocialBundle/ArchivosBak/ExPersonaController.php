<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\Persona;
use Sig\FichasocialBundle\Form\PersonaType;
use Sig\FichasocialBundle\Form\DomicilioPersonaType;

/**
 * Persona controller.
 *
 */
class PersonaController extends Controller
{

    /**
     * Lists all Persona entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SigFichasocialBundle:Persona')->findAll();

        return $this->render('SigFichasocialBundle:Persona:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Persona entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Persona();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('domicilio_personas_edit', array('id' => $entity->getId())));
        }

        return $this->render('SigFichasocialBundle:Persona:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Persona entity.
     *
     * @param Persona $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Persona $entity)
    {
        $form = $this->createForm(new PersonaType(), $entity, array(
            'action' => $this->generateUrl('personas_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => ' Aceptar', 'attr' => array('icon' => 'ok' )));

        return $form;
    }

    /**
     * Displays a form to create a new Persona entity.
     *
     */
    public function newAction()
    {
        $entity = new Persona();
        $form   = $this->createCreateForm($entity);

        return $this->render('SigFichasocialBundle:Persona:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Persona entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Persona')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Persona.');
        }

//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:Persona:show.html.twig', array(
            'entity'      => $entity,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Persona entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Persona')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Persona.');
        }

        $editForm = $this->createEditForm($entity);
//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:Persona:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Muestra un formulario para editar el domicilio de una persona existente.
     *
     */
    public function editDomicilioAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Persona')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Persona.');
        }

        $editForm = $this->createEditDomicilioForm($entity);

        return $this->render('SigFichasocialBundle:Persona:editDomicilio.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Persona entity.
    *
    * @param Persona $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Persona $entity)
    {
        $form = $this->createForm(new PersonaType(), $entity, array(
            'action' => $this->generateUrl('personas_update', array('id' => $entity->getId())),
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
    * Creates a form to edit a Persona entity.
    *
    * @param Persona $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditDomicilioForm(Persona $entity)
    {
        $form = $this->createForm(new DomicilioPersonaType(), $entity, array(
            'action' => $this->generateUrl('domicilio_personas_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Guardar', 'attr' => array('icon' => 'ok')]],
            ]
        ]);

        return $form;
    }

    /**
     * Edits an existing Persona entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Persona')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Persona.');
        }

//        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if ($editForm->get('actions')->get('delete')->isClicked()) {

                $em->remove($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('personas'));
            }

            $em->flush();

            return $this->redirect($this->generateUrl('personas_show', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:Persona:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Edita el domicilio de una persona existente.
     *
     */
    public function updateDomicilioAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Persona')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Persona.');
        }

        $editForm = $this->createEditDomicilioForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $em->flush();

            return $this->redirect($this->generateUrl('personas_show', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:Persona:editDomicilio.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Persona entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SigFichasocialBundle:Persona')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se pudo encontrar la entidad Persona.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('personas'));
    }

    /**
     * Creates a form to delete a Persona entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('personas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => ' Eliminar', 'attr' => array('icon' => 'remove' )))
            ->getForm()
        ;
    }
}
