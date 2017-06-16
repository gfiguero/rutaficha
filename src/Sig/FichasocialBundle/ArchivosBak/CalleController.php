<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\Calle;
use Sig\FichasocialBundle\Form\CalleType;

/**
 * Calle controller.
 *
 */
class CalleController extends Controller
{

    /**
     * Lists all Calle entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SigFichasocialBundle:Calle')->findAll();

        return $this->render('SigFichasocialBundle:Calle:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Calle entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Calle();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('calles_show', array('id' => $entity->getId())));
        }

        return $this->render('SigFichasocialBundle:Calle:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Calle entity.
     *
     * @param Calle $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Calle $entity)
    {
        $form = $this->createForm(new CalleType(), $entity, array(
            'action' => $this->generateUrl('calles_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => ' Aceptar', 'attr' => array('icon' => 'ok' )));

        return $form;
    }

    /**
     * Displays a form to create a new Calle entity.
     *
     */
    public function newAction()
    {
        $entity = new Calle();
        $form   = $this->createCreateForm($entity);

        return $this->render('SigFichasocialBundle:Calle:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Calle entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Calle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Calle.');
        }

//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:Calle:show.html.twig', array(
            'entity'      => $entity,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Calle entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Calle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Calle.');
        }

        $editForm = $this->createEditForm($entity);
//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:Calle:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Calle entity.
    *
    * @param Calle $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Calle $entity)
    {
        $form = $this->createForm(new CalleType(), $entity, array(
            'action' => $this->generateUrl('calles_update', array('id' => $entity->getId())),
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
     * Edits an existing Calle entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Calle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Calle.');
        }

//        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if ($editForm->get('actions')->get('delete')->isClicked()) {

                $em->remove($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('calles'));
            }

            $em->flush();

            return $this->redirect($this->generateUrl('calles_show', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:Calle:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Calle entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SigFichasocialBundle:Calle')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se pudo encontrar la entidad Calle.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('calles'));
    }

    /**
     * Creates a form to delete a Calle entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('calles_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => ' Eliminar', 'attr' => array('icon' => 'remove' )))
            ->getForm()
        ;
    }
    public function searchAction(Request $request)
    {
        $term = $request->get('q');
        $callback = $request->get('callback');
        $em = $this->getDoctrine()->getManager();
        $calles = $em->getRepository('SigFichasocialBundle:Calle')->findLikeNombre($term);
        $response = new JsonResponse($calles, 200, array());
        $response->setCallback($callback);
        return $response;
    }

    public function getAction(Request $request)
    {
        $term = $request->get('id');
        $callback = $request->get('callback');
        $em = $this->getDoctrine()->getManager();
        $calle = $em->getRepository('SigFichasocialBundle:Calle')->getById($term);
        $response = new JsonResponse($calle, 200, array());
        $response->setCallback($callback);
        return $response;
    }
}
