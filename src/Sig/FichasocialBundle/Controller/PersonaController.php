<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\Persona;
use Sig\FichasocialBundle\Entity\Propiedad;
use Sig\FichasocialBundle\Entity\HistorialPersonaUsuario;
use Sig\FichasocialBundle\Form\PersonaType;
use Sig\FichasocialBundle\Form\DomicilioPersonaType;

use Sig\FichasocialBundle\Entity\EventoPersona;
use Sig\FichasocialBundle\Form\EventoPersonaType;

use Sig\FichasocialBundle\Validator\Constraints\Rut;
use Symfony\Component\Validator\Constraints\NotBlank;
/**
 * Persona controller.
 *
 */
class PersonaController extends Controller
{

    /**B
     * Lists all Persona entities.
     *
     */
    public function indexAction()
    {
//        $em = $this->getDoctrine()->getManager();

//        $entities = $em->getRepository('SigFichasocialBundle:Persona')->findBy(array(), array('createdAt' => 'DESC'), $limit = 30);

        $entity = new Persona();
        $searchForm = $this->createSearchForm($entity);

        return $this->render('SigFichasocialBundle:Persona:index.html.twig', array(
//            'entities'      => $entities,
            'entity'        => $entity,
            'search_form'   => $searchForm->createView(),
        ));

    }
    /**
     * Creates a new Persona entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Persona();
//        $entity->setDomicilio(new Propiedad());

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $tipoEvento = $em->getRepository('SigFichasocialBundle:TipoEvento')->find(1);
            $usuario = $this->getUser();
            $historial = new HistorialPersonaUsuario();
            $historial->setPersona($entity);
            $historial->setUsuario($usuario);
            $historial->setTipo($tipoEvento);
            $historial->setDescripcion('Evento: ' . $tipoEvento->getNombre() . '. Usuario: ' . $usuario->getPrimerNombre() . '. Persona: ' . $entity->getPrimerNombre() . '.');
            $historial->setDetalle(FALSE);
            $em->persist($historial);
            $em->flush();
            
            return $this->redirect($this->generateUrl('personas_show', array('id' => $entity->getId())));
//            return $this->redirect($this->generateUrl('personas_domicilio_edit', array('id' => $entity->getId())));
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
        ))
        ->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Aceptar', 'attr' => array('icon' => 'ok')]],
            ]
        ]);

        return $form;
    }

    /**
     * Displays a form to create a new Persona entity.
     *
     */
    public function newAction()
    {
        $entity = new Persona();
//        $entity->setDomicilio(new Propiedad());
        $form = $this->createCreateForm($entity);

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

//        $domicilio = $em->getRepository('SigFichasocialBundle:Domicilio')->getDomicilioByPersonaId($entity->getId());
        $domicilio = $em->getRepository('SigFichasocialBundle:Domicilio')->findOneBy(array('persona' => $entity), array('createdAt' => 'DESC'));

        $solicitudes = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')->findBy(array('persona' => $entity), array('createdAt' => 'DESC'));

        $tipoEvento = $em->getRepository('SigFichasocialBundle:TipoEvento')->find(4);

        $usuario = $this->getUser();

        $historial = new HistorialPersonaUsuario();
        $historial->setPersona($entity);
        $historial->setUsuario($usuario);
        $historial->setTipo($tipoEvento);
        $historial->setDescripcion('Evento: ' . $tipoEvento->getNombre() . '. Usuario: ' . $usuario->getPrimerNombre() . '. Persona: ' . $entity->getPrimerNombre() . '.');
        $historial->setDetalle(TRUE);
        $em->persist($historial);
        $em->flush();
        $this->personaEvento($entity->getId(), 4, $this->getUser()->getId(), '');
        $eventos = $em->getRepository('SigFichasocialBundle:EventoPersona')->findByPersona($id);
        return $this->render('SigFichasocialBundle:Persona:show.html.twig', array(
            'entity'        =>  $entity,
            'domicilio'     =>  $domicilio,
            'solicitudes'   =>  $solicitudes,
            'eventos'       =>  $eventos,
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

        return $this->render('SigFichasocialBundle:Persona:edit.html.twig', array(
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
        ))
        ->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Guardar', 'attr' => array('icon' => 'ok')]],
//                'delete' => ['type' => 'submit', 'options' => ['label' => ' Eliminar', 'attr' => array('icon' => 'trash', 'class' => 'btn-danger')]],
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

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
/*
            if ($editForm->get('actions')->get('delete')->isClicked()) {

                $em->remove($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('personas'));
            }
*/
            $em->flush();
            $this->personaEvento($id, 3, $this->getUser()->getId(), 'Datos Personales modificados');
            $request->getSession()->getFlashBag()->add(
                'noticia',
                'Los datos personales han sido modificados satisfactoriamente.'
            );
            return $this->redirect($this->generateUrl('personas_show', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:Persona:edit.html.twig', array(
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

    public function searchAction(Request $request)
    {

        $entity = new Persona();
        $searchForm = $this->createSearchForm($entity);
        $searchForm->handleRequest($request);

        if ($searchForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $rut = $searchForm["rut"]->getData();
            $persona = $em->getRepository('SigFichasocialBundle:Persona')->findOneByRut($rut);

            if (!$persona) {
                //throw $this->createNotFoundException('No se pudo encontrar la entidad Persona.');
                $request->getSession()->getFlashBag()->add(
                'noticia',
                'El Rut buscado no está registrado en el sistema'
            );
                return $this->redirect($this->generateUrl('personas'));
            }

            return $this->redirect($this->generateUrl('personas_show', array('id' => $persona->getId())));
        }

        return $this->render('SigFichasocialBundle:Persona:index.html.twig', array(
            'search_form'   => $searchForm->createView(),
        ));

    }

    private function createSearchForm(Persona $entity)
    {
        return $this->get('form.factory')->createNamedBuilder('sig_fichasocialbundle_persona', 'form')
            ->setAction($this->generateUrl('personas_search'))
            ->setMethod('POST')
            ->add('rut', 'text', array(
                'constraints' => array(
                    new NotBlank(),
                    new Rut(),
                ),
                'label' => 'Rut',
            ))
            ->add('actions', 'form_actions', [
                'buttons' => [
                    'submit' => ['type' => 'submit', 'options' => ['label' => ' Buscar', 'attr' => array('icon' => 'search')]],
                ]
            ])
            ->getForm()
        ;

    }

    private function personaEvento($personaId, $tipoEventoId, $usuarioId, $descripcion){
        $entity = new eventoPersona();
        $em = $this->getDoctrine()->getManager();

        $persona = $em->getRepository('SigFichasocialBundle:Persona')->find($personaId);
        $tipoEvento = $em->getRepository('SigFichasocialBundle:TipoEvento')->find($tipoEventoId);
        $usuario = $em->getRepository('SigFichasocialBundle:Usuario')->find($usuarioId);

        $entity->setTipo($tipoEvento);
        $entity->setPersona($persona);
        $entity->setUsuario($usuario);
        $entity->setDescripcion($descripcion);

        $em->persist($entity);
        $em->flush();

    }

}
