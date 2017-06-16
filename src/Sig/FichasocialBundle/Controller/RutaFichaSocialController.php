<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\RutaFichaSocial;
use Sig\FichasocialBundle\Form\RutaFichaSocialType;

use Sig\FichasocialBundle\Entity\EventoSolicitud;
use Sig\FichasocialBundle\Form\EventoSolicitudType;

use Sig\FichasocialBundle\Entity\TipoEvento;
use Sig\FichasocialBundle\Form\TipoEventoType;

use Sig\FichasocialBundle\Entity\Usuario;
use Sig\FichasocialBundle\Form\UsuarioType;

use Ps\PdfBundle\Annotation\Pdf;
/**
 * RutaFichaSocial controller.
 *
 */
class RutaFichaSocialController extends Controller
{

    /**
     * Lists all RutaFichaSocial entities.
     *
     */
    public function indexAction($codigo, $pagina)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SigFichasocialBundle:RutaFichaSocial')
            ->createQueryBuilder('r')
            ->select('r', 'rs', 'ren')
            ->leftJoin('r.solicitudes', 'rs')
            ->leftJoin('r.estado', 're')
            ->leftJoin('r.encuestador', 'ren')
            ->where('re.codigo = :codigo')
            ->setParameter('codigo', $codigo)
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
        //findBy(array('estado' => $codigo), array('createdAt' => 'DESC'), $limit = 50);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($entities, $pagina, 30);

        return $this->render('SigFichasocialBundle:RutaFichaSocial:index.html.twig', array(
            //'entities' => $entities,
            'pagination'    => $pagination,
        ));
    }

    /**
     * Creates a new RutaFichaSocial entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new RutaFichaSocial();

        $em = $this->getDoctrine()->getManager();
        $estado = $em->getRepository('SigFichasocialBundle:EstadoRutaFichaSocial')->findOneByCodigo('R00');
        $entity->setEstado($estado);

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
//            $solicitudes = $form->get('solicitudes')->getData();
//            foreach ($solicitudes as $solicitud) {
//                ladybug_dump($solicitud);
//            }

            $em->persist($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->add('noticia', 'La ruta fue creada satisfactoriamente');
            return $this->redirect($this->generateUrl('rutas_show', array('id' => $entity->getId())));
        }

        return $this->render('SigFichasocialBundle:RutaFichaSocial:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a RutaFichaSocial entity.
     *
     * @param RutaFichaSocial $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RutaFichaSocial $entity)
    {
        $form = $this->createForm(new RutaFichaSocialType(), $entity, array(
            'action' => $this->generateUrl('rutas_create'),
            'method' => 'POST',
        ));

        $form->remove('estado');
        $form->remove('encuestador');

        $form->add('submit', 'submit', array('label' => ' Aceptar', 'attr' => array('icon' => 'ok' )));

        return $form;
    }

    /**
     * Displays a form to create a new RutaFichaSocial entity.
     *
     */
    public function newAction()
    {
        $entity = new RutaFichaSocial();
        $form   = $this->createCreateForm($entity);
        $options = $form->get('solicitudes')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();

        return $this->render('SigFichasocialBundle:RutaFichaSocial:new.html.twig', array(
            'entity'    => $entity,
            'form'      => $form->createView(),
            'choices'   => $choices,
        ));
    }

    /**
     * Finds and displays a RutaFichaSocial entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:RutaFichaSocial')
            ->createQueryBuilder('r')
            ->select('r', 're', 'ren')
            ->leftJoin('r.estado', 're')
            ->leftJoin('r.encuestador', 'ren')
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();

        $solicitudes = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')
            ->createQueryBuilder('s')
            ->select('s', 'sd', 'sp', 'sr', 'st')
            ->leftJoin('s.rutas', 'sr')
            ->leftJoin('s.domicilio', 'sd')
            ->leftJoin('s.persona', 'sp')
            ->leftJoin('s.tipo', 'st')
            ->where('sr.id = :id')
            ->setParameter('id', $id)
            ->orderBy('sd.poblacion', 'ASC')
            ->addOrderBy('sd.calle', 'ASC')
            ->addOrderBy('sd.numero', 'ASC')
            ->getQuery()
            ->getResult();

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad RutaFichaSocial.');
        }

//        $deleteForm = $this->createDeleteForm($id);
        $executeForm = $this->createExecuteForm($entity);


        return $this->render('SigFichasocialBundle:RutaFichaSocial:show.html.twig', array(
            'entity'      => $entity,
            'solicitudes'      => $solicitudes,
//            'delete_form' => $deleteForm->createView(),
            'execute_form' => $executeForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing RutaFichaSocial entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:RutaFichaSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad RutaFichaSocial.');
        }

        $editForm = $this->createEditForm($entity);
        $options = $editForm->get('solicitudes')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SigFichasocialBundle:RutaFichaSocial:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'choices'     => $choices,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a RutaFichaSocial entity.
    *
    * @param RutaFichaSocial $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(RutaFichaSocial $entity)
    {
        $form = $this->createForm(new RutaFichaSocialType(), $entity, array(
            'id'   => $entity->getId(),
            'action' => $this->generateUrl('rutas_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->remove('estado');

        $form->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Guardar', 'attr' => array('icon' => 'ok')]],
                //'delete' => ['type' => 'submit', 'options' => ['label' => ' Eliminar', 'attr' => array('icon' => 'remove', 'class' => 'btn-danger')]],
            ]
        ]);

        return $form;
    }

    /**
    * Creates a form to execute a RutaFichaSocial entity.
    *
    * @param RutaFichaSocial $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createExecuteForm(RutaFichaSocial $entity)
    {
        $form = $this->createForm(new RutaFichaSocialType(), $entity, array(
            'id'   => $entity->getId(),
            'action' => $this->generateUrl('rutas_execute', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->remove('estado');
        $form->remove('encuestador');
        $form->remove('solicitudes');

        if($entity->getEstado()->getCodigo() == 'R00') {
            /*El siguiente código deshabilita el botón despachar si la ruta no tiene asignado un encuestador*/
            /*$form->add('actions', 'form_actions', [
                    'buttons' => [
                        'despachar'   => ['type' => 'submit', 'options' => ['label' => ' Despachar', 'attr' => array('icon' => 'send', 'class' => 'btn-success')]],
                    ]
                ]);*/
            /*if($entity->getEncuestador()) {
                $form->add('actions', 'form_actions', [
                    'buttons' => [
                        'despachar'   => ['type' => 'submit', 'options' => ['label' => ' Despachar', 'attr' => array('icon' => 'send', 'class' => 'btn-success')]],
                    ]
                ]);
            } else {
                $form->add('actions', 'form_actions', [
                    'buttons' => [
                        'despachar'   => ['type' => 'submit', 'options' => ['label' => ' Despachar', 'attr' => array('icon' => 'send', 'class' => 'btn-success disabled' )]],
                    ]
                ]);
            }*/
        }

        /*if($entity->getEstado()->getCodigo() == 'R01') $form->add('actions', 'form_actions', [
            'buttons' => [
                'recepcionar' => ['type' => 'submit', 'options' => ['label' => ' Recepcionar', 'attr' => array('icon' => 'inbox', 'class' => 'btn-success')]],
            ]
        ]);*/

        if($entity->getEstado()->getCodigo() == 'R05') $form->add('actions', 'form_actions', [
            'buttons' => [
                'terminar'    => ['type' => 'submit', 'options' => ['label' => ' Terminar', 'attr' => array('icon' => 'flag', 'class' => 'btn-success')]],
            ]
        ]);

        return $form;
    }

    /**
     * Edits an existing RutaFichaSocial entity.
     *
     */
    public function executeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SigFichasocialBundle:RutaFichaSocial')->find($id);
        $executeForm = $this->createExecuteForm($entity);
        $executeForm->handleRequest($request);

        if ($executeForm->isValid()) {

            if ($executeForm->get('actions')->has('despachar') && $executeForm->get('actions')->get('despachar')->isClicked()) {
//                $estadoRuta = $em->getRepository('SigFichasocialBundle:EstadoRutaFichaSocial')->findOneByCodigo('R01');
//                $estadoSolicitud = $em->getRepository('SigFichasocialBundle:EstadoSolicitudFichaSocial')->findOneByCodigo('S03');
//                $entity->setEstado($estadoRuta);
//                foreach ($entity->getSolicitudes() as $solicitud) {
//                    $solicitud->setEstado($estadoSolicitud);
//                };
//                $em->flush();
                $this->actualizarEstadoRuta($entity->getId(), 'R01', 'S01');
                $request->getSession()->getFlashBag()->add('noticia', 'La Ruta fue despachada satisfactoriamente');
                return $this->redirect($this->generateUrl('rutas_show', array('id' => $id)));
//                return $this->redirect($this->generateUrl('rutas'));
            }
            if ($executeForm->get('actions')->has('recepcionar') && $executeForm->get('actions')->get('recepcionar')->isClicked()) {
//                $estado = $em->getRepository('SigFichasocialBundle:EstadoRutaFichaSocial')->findOneByCodigo('R05');
//                $entity->setEstado($estado);
//                $em->flush();
                $this->actualizarEstadoRuta($entity->getId(), 'R05', 'S05');
                $request->getSession()->getFlashBag()->add('noticia', 'La Ruta fue recepcionada satisfactoriamente');
                return $this->redirect($this->generateUrl('rutas_show', array('id' => $id)));
            }
            if ($executeForm->get('actions')->has('terminar') && $executeForm->get('actions')->get('terminar')->isClicked()) {
//                $estado = $em->getRepository('SigFichasocialBundle:EstadoRutaFichaSocial')->findOneByCodigo('R10');
//                $entity->setEstado($estado);
//                $em->flush();
                $this->actualizarEstadoRuta($entity->getId(), 'R10', 'S10');
                $request->getSession()->getFlashBag()->add( 'noticia', 'La Ruta fue terminada satisfactoriamente');
                return $this->redirect($this->generateUrl('rutas_show', array('id' => $id)));
//                return $this->redirect($this->generateUrl('rutas'));
            }

            $request->getSession()->getFlashBag()->add( 'noticia', 'Se produjo un error en la ruta');
            return $this->redirect($this->generateUrl('rutas_show', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:RutaFichaSocial:show.html.twig', array(
            'entity'      => $entity,
            'execute_form' => $execForm->createView(),
        ));
    }
    /**
     * Edits an existing RutaFichaSocial entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SigFichasocialBundle:RutaFichaSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la entidad RutaFichaSocial.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $options = $editForm->get('solicitudes')->getConfig()->getOptions();
        $choices = $options['choice_list']->getChoices();
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if ($editForm->get('encuestador')->isEmpty()) {
                $estado = $em->getRepository('SigFichasocialBundle:EstadoRutaFichaSocial')->findOneByCodigo('R00');
                $entity->setEstado($estado);
            } else {
                $estado = $em->getRepository('SigFichasocialBundle:EstadoRutaFichaSocial')->findOneByCodigo('R05');
                $entity->setEstado($estado);
            }

/*
            if ($editForm->get('actions')->get('delete')->isClicked()) {

                $em->remove($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('rutas'));
            }
*/
            $em->flush();
            $request->getSession()->getFlashBag()->add(
                'noticia',
                'La Ruta fue modificada exitosamente'
            );
            return $this->redirect($this->generateUrl('rutas_show', array('id' => $id)));
        }

        return $this->render('SigFichasocialBundle:RutaFichaSocial:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'choices'     => $choices,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a RutaFichaSocial entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SigFichasocialBundle:RutaFichaSocial')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se pudo encontrar la entidad RutaFichaSocial.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('rutas'));
    }

    /**
     * Creates a form to delete a RutaFichaSocial entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rutas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => ' Eliminar', 'attr' => array('icon' => 'remove' )))
            ->getForm()
        ;
    }
    private function actualizarEstadoRuta($rutaId, $codigoEstadoRuta, $codigoEstadoSolicitud){
        $em = $this->getDoctrine()->getManager();
        $ruta = $em->getRepository('SigFichasocialBundle:RutaFichaSocial')->find($rutaId);
        $estadoRuta = $em->getRepository('SigFichasocialBundle:EstadoRutaFichaSocial')->findOneByCodigo($codigoEstadoRuta);
        $estadoSolicitud = $em->getRepository('SigFichasocialBundle:EstadoSolicitudFichaSocial')->findOneByCodigo($codigoEstadoSolicitud);
        $ruta->setEstado($estadoRuta);
        foreach ($ruta->getSolicitudes() as $solicitud) {
            switch($codigoEstadoSolicitud) {
                case 'S01':
                    $solicitud->setEstado($estadoSolicitud);
                    $this->solicitudEvento($solicitud->getId(), 6, $this->getUser()->getId(), 'Solicitud Despachada');
                    break;
                case 'S05':
                    $solicitud->setEstado($estadoSolicitud);
                    $this->solicitudEvento($solicitud->getId(), 6, $this->getUser()->getId(), 'Solicitud Recepcionada');
                    break;
//                case 'S10':
//                    $this->solicitudEvento($solicitud->getId(), 6, $this->getUser()->getId(), 'Solicitud Archivada');
//                    break;
            }
        };
        $em->persist($ruta);
        $em->flush();
    }

    private function solicitudEvento($solicitudId, $tipoEventoId, $usuarioId, $descripcion){
        $entity = new EventoSolicitud();
        $em = $this->getDoctrine()->getManager();

        $solicitud = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')->find($solicitudId);
        $tipoEvento = $em->getRepository('SigFichasocialBundle:TipoEvento')->find($tipoEventoId);
        $usuario = $em->getRepository('SigFichasocialBundle:Usuario')->find($usuarioId);

        $entity->setTipo($tipoEvento);
        $entity->setSolicitud($solicitud);
        $entity->setUsuario($usuario);
        $entity->setDescripcion($descripcion);

        $em->persist($entity);
        $em->flush();

    }

    /**
     * @Pdf()
     */
    public function pdfAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SigFichasocialBundle:RutaFichaSocial')->findOneBy(
            array('id' => $id)
        );
        if (!$entity) { throw $this->createNotFoundException('No se pudo encontrar la entidad RutaFichaSocial.'); }

        $solicitudes = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')
            ->createQueryBuilder('s')
            ->select('s', 'sd', 'sp', 'sr', 'st')
            ->leftJoin('s.rutas', 'sr')
            ->leftJoin('s.domicilio', 'sd')
            ->leftJoin('s.persona', 'sp')
            ->leftJoin('s.tipo', 'st')
            ->where('sr.id = :id_ruta')
            ->setParameter('id_ruta', $id)
            ->orderBy('sd.poblacion', 'ASC')
            ->addOrderBy('sd.calle', 'ASC')
            ->addOrderBy('sd.numero', 'ASC')
            ->addOrderBy('sd.unidad', 'ASC')
            ->getQuery()
            ->getResult();
//        $format = $this->get('request')->get('_format');

//        return $this->render(sprintf('SigFichasocialBundle:RutaFichaSocial:show.pdf.twig', $format), array(
//            'entity' => $entity,
//        ));

        $format = $this->get('request')->get('_format');

        return $this->render( sprintf('SigFichasocialBundle:RutaFichaSocial:show.%s.twig', $format), array(
            'entity'        => $entity,
            'solicitudes'   => $solicitudes,
        ));
/*
        $html = $this->renderView('SigFichasocialBundle:RutaFichaSocial:pdf.html.twig', array(
            'entity'  => $entity
        ));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );
*/

/*
        return $this->render('SigFichasocialBundle:RutaFichaSocial:show.html.twig', array(
            'entity'      => $entity,
        ));
*/
    }
    public function pdftestAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SigFichasocialBundle:RutaFichaSocial')->findOneBy(
            array('id' => $id)
        );
        if (!$entity) { throw $this->createNotFoundException('No se pudo encontrar la entidad RutaFichaSocial.'); }

        $solicitudes = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')
            ->createQueryBuilder('s')
            ->select('s', 'sd', 'sp', 'sr', 'st')
            ->leftJoin('s.rutas', 'sr')
            ->leftJoin('s.domicilio', 'sd')
            ->leftJoin('s.persona', 'sp')
            ->leftJoin('s.tipo', 'st')
            ->where('sr.id = :id_ruta')
            ->setParameter('id_ruta', $id)
            ->orderBy('sd.poblacion', 'ASC')
            ->addOrderBy('sd.calle', 'ASC')
            ->addOrderBy('sd.numero', 'ASC')
            ->getQuery()
            ->getResult();

        $format = $this->get('request')->get('_format');

//        return $this->render(sprintf('SigFichasocialBundle:RutaFichaSocial:testpdf.html.twig', $format), array(
//            'entity' => $entity,
//        ));

        return $this->render('SigFichasocialBundle:RutaFichaSocial:testpdf.html.twig', array(
            'entity'      => $entity,
            'solicitudes'      => $solicitudes,
        ));
    }

}
