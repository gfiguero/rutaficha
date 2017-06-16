<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\Domicilio;
use Sig\FichasocialBundle\Form\DomicilioType;

/**
 * Domicilio controller.
 *
 */
class DomicilioController extends Controller
{

    /**
     * Lists all Domicilio entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SigFichasocialBundle:Domicilio')->findAll();

        return $this->render('SigFichasocialBundle:Domicilio:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Domicilio entity.
     *
     */
    public function createAction(Request $request, $personaId)
    {
        $entity = new Domicilio();
        $em = $this->getDoctrine()->getManager();
        $persona = $em->getRepository('SigFichasocialBundle:Persona')->find($personaId);
        if (!$persona) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Persona.');
        }
        $entity->setPersona($persona);

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->add(
                'noticia',
                'El domicilio fue agregado satisfactoriamente'
            );
            return $this->redirect($this->generateUrl('personas_show', array('id' => $personaId)));
        }

        return $this->render('SigFichasocialBundle:Domicilio:new.html.twig', array(
            'entity'    => $entity,
            'form'      => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Domicilio entity.
     *
     * @param Domicilio $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Domicilio $entity)
    {
        $form = $this->createForm(new DomicilioType(), $entity, array(
            'action' => $this->generateUrl('domicilios_create', array('personaId' => $entity->getPersona()->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => ' Guardar', 'attr' => array('icon' => 'ok' )));

        return $form;
    }

    /**
     * Displays a form to create a new Domicilio entity.
     *
     */
    public function newAction($personaId)
    {
        $em = $this->getDoctrine()->getManager();
        $persona = $em->getRepository('SigFichasocialBundle:Persona')->find($personaId);
        if (!$persona) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Persona.');
        }

        $entity = $em->getRepository('SigFichasocialBundle:Domicilio')->findOneByPersona($personaId, array('createdAt' => 'DESC'));
        if(!$entity) { 
            $entity = new Domicilio();
            $entity->setPersona($persona);
        }

        $form   = $this->createCreateForm($entity);
        return $this->render('SigFichasocialBundle:Domicilio:new.html.twig', array(
            'entity'    => $entity,
            'form'      => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Domicilio entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Domicilio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Domicilio.');
        }

//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:Domicilio:show.html.twig', array(
            'entity'      => $entity,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Domicilio entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Domicilio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Domicilio.');
        }

        $editForm = $this->createEditForm($entity);
//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:Domicilio:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Domicilio entity.
    *
    * @param Domicilio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Domicilio $entity)
    {
        $form = $this->createForm(new DomicilioType(), $entity, array(
            'action' => $this->generateUrl('domicilios_update', array('id' => $entity->getId())),
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
     * Edits an existing Domicilio entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Domicilio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Domicilio.');
        }

//        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if ($editForm->get('actions')->get('delete')->isClicked()) {

                $em->remove($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('domicilios'));
            }

            $em->flush();

            return $this->redirect($this->generateUrl('domicilios_show', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:Domicilio:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Domicilio entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SigFichasocialBundle:Domicilio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se pudo encontrar la entidad Domicilio.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('domicilios'));
    }

    /**
     * Creates a form to delete a Domicilio entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('domicilios_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => ' Eliminar', 'attr' => array('icon' => 'remove' )))
            ->getForm()
        ;
    }
}
