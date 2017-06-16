<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\SolicitudFichaSocial;
use Sig\FichasocialBundle\Form\SolicitudFichaSocialType;

use Sig\FichasocialBundle\Entity\EventoSolicitud;
use Sig\FichasocialBundle\Form\EventoSolicitudType;

use Sig\FichasocialBundle\Entity\TipoEvento;
use Sig\FichasocialBundle\Form\TipoEventoType;

use Doctrine\ORM\EntityRepository;
/**
 * SolicitudFichaSocial controller.
 *
 */
class SolicitudFichaSocialController extends Controller
{

    /**
     * Lists all SolicitudFichaSocial entities.
     *
     */
    public function indexAction($codigo, $pagina)
    {
        $em = $this->getDoctrine()->getManager();

        if($codigo == 'ALL') {
            $entities = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')
                ->createQueryBuilder('s')
                ->select('s', 'sd', 'sp', 'sr', 'st')
                ->leftJoin('s.rutas', 'sr')
                ->leftJoin('s.domicilio', 'sd')
                ->leftJoin('s.persona', 'sp')
                ->leftJoin('s.tipo', 'st')
                ->orderBy('s.createdAt', 'DESC')
                ->getQuery()
                ->getResult();
//                ->findBy(array(), array('createdAt' => 'DESC'));
        }

        if($codigo == 'S00') {
            $entities = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')
                ->createQueryBuilder('s')
                ->select('s', 'sd', 'sp', 'sr', 'st')
                ->leftJoin('s.rutas', 'sr')
                ->leftJoin('s.domicilio', 'sd')
                ->leftJoin('s.persona', 'sp')
                ->leftJoin('s.tipo', 'st')
                ->where('sr is NULL')
                ->orderBy('s.createdAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        if($codigo == 'S01') {
            $entities = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')
                ->createQueryBuilder('s')
                ->select('s', 'sd', 'sp', 'sr', 'st')
                ->leftJoin('s.rutas', 'sr')
                ->leftJoin('s.domicilio', 'sd')
                ->leftJoin('s.persona', 'sp')
                ->leftJoin('s.tipo', 'st')
                ->where('sr is not NULL')
                ->andwhere('s.estado is NULL')
                ->orderBy('s.createdAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        if($codigo == 'S05') {
            $entities = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')
                ->createQueryBuilder('s')
                ->select('s', 'sd', 'sp', 'sr', 'st')
                ->leftJoin('s.rutas', 'sr')
                ->leftJoin('s.domicilio', 'sd')
                ->leftJoin('s.persona', 'sp')
                ->leftJoin('s.tipo', 'st')
                ->leftJoin('s.estado', 'se')
                ->where('s.folio is NULL')
                ->andwhere('sr is not NULL')
                ->andwhere('se.codigo = :codigo')
                ->setParameter('codigo', 'P14')
                ->orderBy('s.createdAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        if($codigo == 'S10') {
            $entities = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')
                ->createQueryBuilder('s')
                ->select('s', 'sd', 'sp', 'sr', 'st')
                ->leftJoin('s.rutas', 'sr')
                ->leftJoin('s.domicilio', 'sd')
                ->leftJoin('s.persona', 'sp')
                ->leftJoin('s.tipo', 'st')
                ->where('s.folio is not NULL')
                ->orderBy('s.createdAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($entities, $pagina, 30);

        return $this->render('SigFichasocialBundle:SolicitudFichaSocial:index.html.twig', array(
            //'entities' => $entities,
            'pagination'    => $pagination,
        ));
    }
    /**
     * Creates a new SolicitudFichaSocial entity.
     *
     */
    public function createAction(Request $request, $personaId)
    {
        $entity = new SolicitudFichaSocial();
        $em = $this->getDoctrine()->getManager();

        $persona = $em->getRepository('SigFichasocialBundle:Persona')->find($personaId);
        $domicilio = $em->getRepository('SigFichasocialBundle:Domicilio')->findOneBy(array('persona' => $persona), array('createdAt' => 'DESC'));

        $entity->setPersona($persona);
        $entity->setDomicilio($domicilio);

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $estado = $em->getRepository('SigFichasocialBundle:EstadoSolicitudFichaSocial')->findOneByCodigo('P01');
            $entity->setEstado($estado);

            $em->persist($entity);
            $em->flush();

            nuevoEventoSolicitud($entity->getId(), 5, $this->getUser()->getId(), 'Solicitud ingresada');

            return $this->redirect($this->generateUrl('personas_show', array('id' => $personaId)));
        }

        return $this->render('SigFichasocialBundle:SolicitudFichaSocial:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a SolicitudFichaSocial entity.
     *
     * @param SolicitudFichaSocial $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SolicitudFichaSocial $entity)
    {
        $form = $this->createForm(new SolicitudFichaSocialType(), $entity, array(
            'action' => $this->generateUrl('solicitudesfichasocial_create', array('personaId' => $entity->getPersona()->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => ' Confirmar', 'attr' => array('icon' => 'ok' )));

        return $form;
    }

    /**
     * Displays a form to create a new SolicitudFichaSocial entity.
     *
     */
    public function newAction($personaId)
    {
        $em = $this->getDoctrine()->getManager();

        $persona = $em->getRepository('SigFichasocialBundle:Persona')->find($personaId);

        if (!$persona) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad Persona.');
        }

        $domicilio = $em->getRepository('SigFichasocialBundle:Domicilio')->findOneBy(array('persona' => $persona), array('createdAt' => 'DESC'));

        $entity = new SolicitudFichaSocial();
        $entity->setPersona($persona);
        $entity->setDomicilio($domicilio);
        $form = $this->createCreateForm($entity);

        return $this->render('SigFichasocialBundle:SolicitudFichaSocial:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SolicitudFichaSocial entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad SolicitudFichaSocial.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $eventos = $em->getRepository('SigFichasocialBundle:EventoSolicitud')->findBySolicitud($id);

        return $this->render('SigFichasocialBundle:SolicitudFichaSocial:show.html.twig', array(
            'entity'      => $entity,
            'eventos'     => $eventos,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SolicitudFichaSocial entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad SolicitudFichaSocial.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:SolicitudFichaSocial:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a SolicitudFichaSocial entity.
    *
    * @param SolicitudFichaSocial $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SolicitudFichaSocial $entity)
    {
        $form = $this->createForm(new SolicitudFichaSocialType(), $entity, array(
            'action' => $this->generateUrl('solicitudesfichasocial_update', array('id' => $entity->getId())),
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
     * Edits an existing SolicitudFichaSocial entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad SolicitudFichaSocial.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if ($editForm->get('actions')->get('delete')->isClicked()) {

                $em->remove($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('solicitudesfichasocial'));
            }

            $em->flush();
            $descripcion = 'Estado: '.$entity->getEstado()->getCodigo().' - '.$entity->getEstado()->getNombre().', Tipo: '.$entity->getTipo()->getNombre();
            $this->solicitudEvento($id, 10, $this->getUser()->getId(),$descripcion);
            $request->getSession()->getFlashBag()->add(
                'noticia',
                'La solicitud fue modificada exitosamente'
            );
            return $this->redirect($this->generateUrl('solicitudesfichasocial_show', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:SolicitudFichaSocial:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a SolicitudFichaSocial entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se pudo encontrar la entidad SolicitudFichaSocial.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('solicitudesfichasocial'));
    }

    /**
     * Creates a form to delete a SolicitudFichaSocial entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('solicitudesfichasocial_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => ' Eliminar', 'attr' => array('icon' => 'remove' )))
            ->getForm()
        ;
    }

    private function solicitudEvento($solicitudId, $tipoEventoId, $usuarioId, $descripcion){
        $entity = new EventoSolicitud();
        $em = $this->getDoctrine()->getManager();

        $solicitud = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')->find($solicitudId);
        $tipoEvento = $em->getRepository('SigFichasocialBundle:TipoEvento')->find($tipoEventoId);
        $usuario = $em->getRepository('SigFichasocialBundle:Usuario')->find($usuarioId);

        $entity->setSolicitud($solicitud);
        $entity->setTipo($tipoEvento);
        $entity->setUsuario($usuario);
        $entity->setDescripcion($descripcion);

        $em->persist($entity);
        $em->flush();

    }

    public function concludeAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad SolicitudFichaSocial.');
        }

        $concludeForm = $this->createConcludeForm($entity);

        return $this->render('SigFichasocialBundle:SolicitudFichaSocial:conclude.html.twig', array(
            'entity'            => $entity,
            'conclude_form'     => $concludeForm->createView(),
        ));
    }
    public function finnishAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad SolicitudFichaSocial.');
        }
        $concludeForm = $this->createConcludeForm($entity);
        $concludeForm->handleRequest($request);

        if ($concludeForm->isValid()) {
            $em->flush();
            $descripcion = 'Resolución: ' . $entity->getEstado()->getCodigo() . ' - ' . $entity->getEstado()->getNombre();
            $this->solicitudEvento($id, 11, $this->getUser()->getId(), $descripcion);
            $request->getSession()->getFlashBag()->add( 'noticia', 'La solicitud fue concluída exitosamente' );
            return $this->redirect($this->generateUrl('rutas_show', array('id' => $entity->getRuta()->getId())));
        }

        return $this->render('SigFichasocialBundle:SolicitudFichaSocial:conclude.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $concludeForm->createView(),
        ));
    }
    private function createConcludeForm(SolicitudFichaSocial $entity)
    {
        $form = $this->createForm(new SolicitudFichaSocialType(), $entity, array(
            'action' => $this->generateUrl('solicitudesfichasocial_finnish', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->remove('tipo');
        $form->remove('estado');
        $form->add('estado', 'entity', array(
            'label'     =>  'Resolución',
            'class'     =>  'SigFichasocialBundle:EstadoSolicitudFichaSocial',
            'property'  =>  'codigonombre',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('e')->where("e.codigo LIKE 'P%'");
            },
        ));

        $form->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Finalizar', 'attr' => array('icon' => 'ok')]],
            ]
        ]);

        return $form;
    }

    public function foilAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad SolicitudFichaSocial.');
        }
        $foilForm = $this->createFoilForm($entity);
        return $this->render('SigFichasocialBundle:SolicitudFichaSocial:foil.html.twig', array(
            'entity'            => $entity,
            'foil_form'     => $foilForm->createView(),
        ));
    }
    public function fileAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad SolicitudFichaSocial.');
        }
        $foilForm = $this->createFoilForm($entity);
        $foilForm->handleRequest($request);
        if ($foilForm->isValid()) {
            $estado = $em->getRepository('SigFichasocialBundle:EstadoSolicitudFichaSocial')->findOneByCodigo('S10');
            $entity->setEstado($estado);
            $em->flush();
            $descripcion = '';
            $this->solicitudEvento($id, 12, $this->getUser()->getId(), $descripcion);
            $request->getSession()->getFlashBag()->add( 'noticia', 'La solicitud fue archivada exitosamente' );
            return $this->redirect($this->generateUrl('solicitudesfichasocial_show', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:SolicitudFichaSocial:foil.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $foilForm->createView(),
        ));
    }
    private function createFoilForm(SolicitudFichaSocial $entity)
    {
        $form = $this->createForm(new SolicitudFichaSocialType(), $entity, array(
            'action' => $this->generateUrl('solicitudesfichasocial_file', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->remove('tipo');
        $form->remove('estado');
        $form->add('folio', 'text', array(
            'label'     =>  'Folio',
        ));
        $form->add('archivo', 'entity', array(
            'label'     =>  'Archivo o Caja',
            'class'     =>  'SigFichasocialBundle:Archivo',
            'property'  =>  'codigo',
        ));
        $form->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Archivar', 'attr' => array('icon' => 'folder-open')]],
            ]
        ]);
        return $form;
    }
}
