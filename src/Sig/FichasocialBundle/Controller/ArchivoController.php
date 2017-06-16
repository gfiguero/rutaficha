<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\Archivo;
use Sig\FichasocialBundle\Form\ArchivoType;

/**
 * Archivo controller.
 *
 */
class ArchivoController extends Controller
{

    /**
     * Lists all Archivo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SigFichasocialBundle:Archivo')->findAll();

        return $this->render('SigFichasocialBundle:Archivo:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Archivo entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Archivo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('archivos_show', array('id' => $entity->getId())));
        }

        return $this->render('SigFichasocialBundle:Archivo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Archivo entity.
     *
     * @param Archivo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Archivo $entity)
    {
        $form = $this->createForm(new ArchivoType(), $entity, array(
            'action' => $this->generateUrl('archivos_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => ' Aceptar', 'attr' => array('icon' => 'ok' )));

        return $form;
    }

    /**
     * Displays a form to create a new Archivo entity.
     *
     */
    public function newAction()
    {
        $entity = new Archivo();
        $form   = $this->createCreateForm($entity);

        return $this->render('SigFichasocialBundle:Archivo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Archivo entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Archivo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Archivo.');
        }

//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:Archivo:show.html.twig', array(
            'entity'      => $entity,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Archivo entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Archivo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Archivo.');
        }

        $editForm = $this->createEditForm($entity);
//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:Archivo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Archivo entity.
    *
    * @param Archivo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Archivo $entity)
    {
        $form = $this->createForm(new ArchivoType(), $entity, array(
            'action' => $this->generateUrl('archivos_update', array('id' => $entity->getId())),
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
     * Edits an existing Archivo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Archivo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Archivo.');
        }

//        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if ($editForm->get('actions')->get('delete')->isClicked()) {

                $em->remove($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('archivos'));
            }

            $em->flush();

            return $this->redirect($this->generateUrl('archivos_show', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:Archivo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Archivo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SigFichasocialBundle:Archivo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se pudo encontrar la entidad Archivo.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('archivos'));
    }

    /**
     * Creates a form to delete a Archivo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('archivos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => ' Eliminar', 'attr' => array('icon' => 'remove' )))
            ->getForm()
        ;
    }
}
