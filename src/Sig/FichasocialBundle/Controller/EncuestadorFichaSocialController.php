<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\EncuestadorFichaSocial;
use Sig\FichasocialBundle\Form\EncuestadorFichaSocialType;

/**
 * EncuestadorFichaSocial controller.
 *
 */
class EncuestadorFichaSocialController extends Controller
{

    /**
     * Lists all EncuestadorFichaSocial entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SigFichasocialBundle:EncuestadorFichaSocial')->findAll();

        return $this->render('SigFichasocialBundle:EncuestadorFichaSocial:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new EncuestadorFichaSocial entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new EncuestadorFichaSocial();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->add(
                'noticia',
                'El encuestador fue registrado satisfactoriamente'
            );
            return $this->redirect($this->generateUrl('encuestadores', array('id' => $entity->getId())));
        }

        return $this->render('SigFichasocialBundle:EncuestadorFichaSocial:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a EncuestadorFichaSocial entity.
     *
     * @param EncuestadorFichaSocial $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(EncuestadorFichaSocial $entity)
    {
        $form = $this->createForm(new EncuestadorFichaSocialType(), $entity, array(
            'action' => $this->generateUrl('encuestadores_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => ' Aceptar', 'attr' => array('icon' => 'ok' )));

        return $form;
    }

    /**
     * Displays a form to create a new EncuestadorFichaSocial entity.
     *
     */
    public function newAction()
    {
        $entity = new EncuestadorFichaSocial();
        $form   = $this->createCreateForm($entity);

        return $this->render('SigFichasocialBundle:EncuestadorFichaSocial:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EncuestadorFichaSocial entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:EncuestadorFichaSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad EncuestadorFichaSocial.');
        }

//        $deleteForm = $this->createDeleteForm($id);
        $rutas = $em->getRepository('SigFichasocialBundle:RutaFichaSocial')->findByEncuestador($id);
        return $this->render('SigFichasocialBundle:EncuestadorFichaSocial:show.html.twig', array(
            'entity'      => $entity,
            'rutas'       => $rutas,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EncuestadorFichaSocial entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:EncuestadorFichaSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad EncuestadorFichaSocial.');
        }

        $editForm = $this->createEditForm($entity);
//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:EncuestadorFichaSocial:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a EncuestadorFichaSocial entity.
    *
    * @param EncuestadorFichaSocial $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EncuestadorFichaSocial $entity)
    {
        $form = $this->createForm(new EncuestadorFichaSocialType(), $entity, array(
            'action' => $this->generateUrl('encuestadores_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Guardar', 'attr' => array('icon' => 'ok')]],
//                'delete' => ['type' => 'submit', 'options' => ['label' => ' Eliminar', 'attr' => array('icon' => 'remove', 'class' => 'btn-danger')]],
            ]
        ]);

        return $form;
    }
    /**
     * Edits an existing EncuestadorFichaSocial entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:EncuestadorFichaSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad EncuestadorFichaSocial.');
        }

//        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

/*            if ($editForm->get('actions')->get('delete')->isClicked()) {

                $em->remove($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('encuestadores'));
            }
*/
            $em->flush();
            $request->getSession()->getFlashBag()->add(
                'noticia',
                'La información del encuestador fue modificada satisfactoriamente'
            );
            return $this->redirect($this->generateUrl('encuestadores', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:EncuestadorFichaSocial:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a EncuestadorFichaSocial entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SigFichasocialBundle:EncuestadorFichaSocial')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se pudo encontrar la entidad EncuestadorFichaSocial.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('encuestadores'));
    }

    /**
     * Creates a form to delete a EncuestadorFichaSocial entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('encuestadores_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => ' Eliminar', 'attr' => array('icon' => 'remove' )))
            ->getForm()
        ;
    }
}
