<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\Propiedad;
use Sig\FichasocialBundle\Form\PropiedadType;

/**
 * Propiedad controller.
 *
 */
class PropiedadController extends Controller
{

    /**
     * Lists all Propiedad entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SigFichasocialBundle:Propiedad')->findAll();

        return $this->render('SigFichasocialBundle:Propiedad:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Propiedad entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Propiedad();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('propiedades_show', array('id' => $entity->getId())));
        }

        return $this->render('SigFichasocialBundle:Propiedad:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Propiedad entity.
     *
     * @param Propiedad $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Propiedad $entity)
    {
        $form = $this->createForm(new PropiedadType(), $entity, array(
            'action' => $this->generateUrl('propiedades_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => ' Aceptar', 'attr' => array('icon' => 'ok' )));

        return $form;
    }

    /**
     * Displays a form to create a new Propiedad entity.
     *
     */
    public function newAction()
    {
        $entity = new Propiedad();
        $form   = $this->createCreateForm($entity);

        return $this->render('SigFichasocialBundle:Propiedad:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Propiedad entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Propiedad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Propiedad.');
        }

//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:Propiedad:show.html.twig', array(
            'entity'      => $entity,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Propiedad entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Propiedad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Propiedad.');
        }

        $editForm = $this->createEditForm($entity);
//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:Propiedad:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Propiedad entity.
    *
    * @param Propiedad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Propiedad $entity)
    {
        $form = $this->createForm(new PropiedadType(), $entity, array(
            'action' => $this->generateUrl('propiedades_update', array('id' => $entity->getId())),
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
     * Edits an existing Propiedad entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:Propiedad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Propiedad.');
        }

//        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if ($editForm->get('actions')->get('delete')->isClicked()) {

                $em->remove($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('propiedades'));
            }

            $em->flush();

            return $this->redirect($this->generateUrl('propiedades_show', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:Propiedad:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Propiedad entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SigFichasocialBundle:Propiedad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se pudo encontrar la entidad Propiedad.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('propiedades'));
    }

    /**
     * Creates a form to delete a Propiedad entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('propiedades_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => ' Eliminar', 'attr' => array('icon' => 'remove' )))
            ->getForm()
        ;
    }


    public function searchAction(Request $request)
    {
        $col = $request->get('col');
        $calle = $request->get('calle');
        $numero = $request->get('numero');
        $complemento = $request->get('complemento');
        $callback = $request->get('callback');
        $em = $this->getDoctrine()->getManager();
        if($col == 'calle') $domicilios = $em->getRepository('SigFichasocialBundle:Propiedad')->findLikeCalle($calle);
        if($col == 'numero') $domicilios = $em->getRepository('SigFichasocialBundle:Propiedad')->findLikeNumero($calle, $numero);
        if($col == 'complemento') $domicilios = $em->getRepository('SigFichasocialBundle:Propiedad')->findLikeComplemento($calle, $numero, $complemento);
        $response = new JsonResponse($domicilios, 200, array());
        $response->setCallback($callback);
        return $this->redirect($this->generateUrl('propiedades_show'));
        return $response;
    }

    public function getAction(Request $request)
    {
        $term = $request->get('id');
        $callback = $request->get('callback');
        $em = $this->getDoctrine()->getManager();
        $calle = $em->getRepository('SigFichasocialBundle:Propiedad')->getById($term);
        $response = new JsonResponse($calle, 200, array());
        $response->setCallback($callback);
        return $response;
    }
}
