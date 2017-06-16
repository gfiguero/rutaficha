<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sig\FichasocialBundle\Entity\Persona;
use Sig\FichasocialBundle\Form\PersonaType;

use Sig\FichasocialBundle\Entity\Domicilio;
use Sig\FichasocialBundle\Form\DomicilioType;

use Sig\FichasocialBundle\Entity\SolicitudFichaSocial;
use Sig\FichasocialBundle\Form\SolicitudFichaSocialType;

use Sig\FichasocialBundle\Entity\EventoSolicitud;
use Sig\FichasocialBundle\Form\EventoSolicitudType;

use Sig\FichasocialBundle\Entity\EventoPersona;
use Sig\FichasocialBundle\Form\EventoPersonaType;

use Sig\FichasocialBundle\Entity\TipoEvento;
use Sig\FichasocialBundle\Form\TipoEventoType;

use Sig\FichasocialBundle\Entity\Usuario;
use Sig\FichasocialBundle\Form\UsuarioType;


use Sig\FichasocialBundle\Validator\Constraints\Rut;

use Symfony\Component\Validator\Constraints\NotBlank;

class ProcesoSolicitudController extends Controller
{

    public function buscarAction(Request $request)
    {
        $buscarForm = $this->buscarForm();
        $buscarForm->handleRequest($request);

        if ($buscarForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $rut = $buscarForm["rut"]->getData();
            $persona = $em->getRepository('SigFichasocialBundle:Persona')->findOneByRut($rut);

            if (!$persona) {
                return $this->redirect($this->generateUrl('proceso_persona_nueva', array( 'rut' => $rut )));
            }

            return $this->redirect($this->generateUrl('proceso_persona_existente', array( 'id' => $persona->getId() )));
        }

        return $this->render('SigFichasocialBundle:ProcesoSolicitud:buscar.html.twig', array(
            'buscarForm' => $buscarForm->createView(),
        ));
    }

    private function buscarForm()
    {
        return $this->get('form.factory')->createNamedBuilder('sig_fichasocialbundle_persona', 'form')
            ->setAction($this->generateUrl('proceso_buscar'))
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
                    'submit' => ['type' => 'submit', 'options' => ['label' => ' Siguiente', 'attr' => array('icon' => 'arrow-right')]],
                ]
            ])
            ->getForm()
        ;
    }









    public function personaNewAction(Request $request)
    {
        $persona = new Persona();
        $persona->setRut($request->query->get('rut'));
        $personaForm = $this->personaNewForm($persona);
        return $this->render('SigFichasocialBundle:ProcesoSolicitud:persona.html.twig', array(
            'persona'       => $persona,
            'personaForm'   => $personaForm->createView()
        ));
    }

    public function personaCreateAction(Request $request)
    {
        $persona = new Persona();
        $personaForm = $this->personaNewForm($persona);
        $personaForm->handleRequest($request);
        if ($personaForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($persona);
            $em->flush();
            $this->personaEvento($persona->getId(), 1, $this->getUser()->getId(), '');
            return $this->redirect($this->generateUrl('proceso_domicilio', array('id' => $persona->getId())));
        }
        return $this->render('SigFichasocialBundle:ProcesoSolicitud:persona.html.twig', array(
            'personaForm'   => $personaForm->createView(),
            'persona'       => $persona,
        ));
    }

    public function personaEditAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $persona = $em->getRepository('SigFichasocialBundle:Persona')->find($id);
        $personaForm = $this->personaEditForm($persona);
        return $this->render('SigFichasocialBundle:ProcesoSolicitud:persona.html.twig', array(
            'persona'       => $persona,
            'personaForm'   => $personaForm->createView(),
        ));
    }

    public function personaUpdateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $persona = $em->getRepository('SigFichasocialBundle:Persona')->find($id);
        $personaForm = $this->personaEditForm($persona);
        $personaForm->handleRequest($request);
        if ($personaForm->isValid()) {
            $em->flush();
            $this->personaEvento($id, 3, $this->getUser()->getId(), '');
            return $this->redirect($this->generateUrl('proceso_domicilio', array('id' => $id)));
        }
        return $this->render('SigFichasocialBundle:ProcesoSolicitud:persona.html.twig', array(
            'personaForm'   => $personaForm->createView(),
            'persona'       => $persona,
        ));
    }



    private function personaNewForm(Persona $persona)
    {
        $form = $this->createForm(new PersonaType(), $persona, array(
            'action' => $this->generateUrl('proceso_persona_crear'),
            'method' => 'POST',
        ))
        ->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Siguiente', 'attr' => array('icon' => 'arrow-right')]],
            ]
        ]);
        return $form;
    }

    private function personaEditForm(Persona $persona)
    {
        $form = $this->createForm(new PersonaType(), $persona, array(
            'action' => $this->generateUrl('proceso_persona_actualizar', array('id' => $persona->getId())),
            'method' => 'PUT',
        ))
        ->remove('rut')
        ->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Siguiente', 'attr' => array('icon' => 'arrow-right')]],
            ]
        ]);
        return $form;
    }










    public function domicilioAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $domicilio = $em->getRepository('SigFichasocialBundle:Domicilio')->findOneByPersona($id, array('createdAt' => 'DESC'));
        $persona = $em->getRepository('SigFichasocialBundle:Persona')->find($id);
        if(!$domicilio) { 
            $domicilio = new Domicilio();
            $domicilio->setPersona($persona);
        }
        $domicilioForm = $this->domicilioForm($domicilio, $persona);
        return $this->render('SigFichasocialBundle:ProcesoSolicitud:domicilio.html.twig', array(
            'domicilioForm' => $domicilioForm->createView(),
            'domicilio'     => $domicilio,
            'persona'       => $persona,
        ));
    }

    public function domicilioUpdateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        //$domicilio = $em->getRepository('SigFichasocialBundle:Domicilio')->findOneByPersona($id, array('createdAt' => 'DESC'));
        $domicilio = new Domicilio();
        $persona = $em->getRepository('SigFichasocialBundle:Persona')->find($id);
        $domicilioForm = $this->domicilioForm($domicilio, $persona);
        $domicilioForm->handleRequest($request);
        if ($domicilioForm->isValid()) {
            $domicilio->setPersona($persona);
            $em->persist($domicilio);
            $em->flush();
            $this->personaEvento($id, 2, $this->getUser()->getId(), '');
            return $this->redirect($this->generateUrl('proceso_solicitud', array('id' => $id)));
        }
        return $this->render('SigFichasocialBundle:ProcesoSolicitud:domicilio.html.twig', array(
            'domicilioForm' => $domicilioForm->createView(),
            'domicilio'     => $domicilio,
            'persona'       => $persona,
        ));
    }

    private function domicilioForm(Domicilio $domicilio, Persona $persona)
    {
        $form = $this->createForm(new DomicilioType(), $domicilio, array(
            'action' => $this->generateUrl('proceso_domicilio_actualizar', array('id' => $persona->getId())),
            'method' => 'POST',
        ))
        ->add('actions', 'form_actions', [
            'buttons' => [
                'reset' => ['type' => 'reset', 'options' => ['label' => ' Reestablecer', 'attr' => array('icon' => 'refresh')]],
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Siguiente', 'attr' => array('icon' => 'arrow-right')]],
            ]
        ]);
        return $form;
    }














    public function solicitudAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $persona = $em->getRepository('SigFichasocialBundle:Persona')->find($id);
        $domicilio = $em->getRepository('SigFichasocialBundle:Domicilio')->findOneByPersona($id, array('createdAt' => 'DESC'));
        $solicitud = new SolicitudFichaSocial();

        $solicitudForm = $this->solicitudForm($solicitud, $persona);
 
        return $this->render('SigFichasocialBundle:ProcesoSolicitud:solicitud.html.twig', array(
            'solicitudForm' => $solicitudForm->createView(),
            'solicitud'     => $solicitud,
            'domicilio'     => $domicilio,
            'persona'       => $persona,
        ));
    }

    public function solicitudIngresarAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $persona = $em->getRepository('SigFichasocialBundle:Persona')->find($id);
        $domicilio = $em->getRepository('SigFichasocialBundle:Domicilio')->findOneByPersona($id, array('createdAt' => 'DESC'));
        $solicitud = new SolicitudFichaSocial();

        $solicitudForm = $this->solicitudForm($solicitud, $persona);
        $solicitudForm->handleRequest($request);

        if ($solicitudForm->isValid()) {
            $solicitud->setPersona($persona);
            $solicitud->setDomicilio($domicilio);
            $estado = $em->getRepository('SigFichasocialBundle:EstadoSolicitudFichaSocial')->findOneByCodigo('S00');
            $solicitud->setEstado($estado);
            $em->persist($solicitud);
            $em->flush();
            $descripcion = 'Tipo:'.$solicitud->getTipo()->getNombre();
            $this->personaEvento($persona->getId(), 5, $this->getUser()->getId(), $descripcion);
            $this->solicitudEvento($solicitud->getId(), 5, $this->getUser()->getId(), 'Solicitud ingresada');
            $request->getSession()->getFlashBag()->add(
                'noticia',
                'La solicitud ha sido ingresada satisfactoriamente.'
            );
            return $this->redirect($this->generateUrl('solicitudesfichasocial'));
            //return $this->redirect($this->generateUrl('proceso_finalizar', array('id' => $id)));
        }
        return $this->render('SigFichasocialBundle:ProcesoSolicitud:domicilio.html.twig', array(
            'solicitudForm' => $solicitudForm->createView(),
            'solicitud'     => $solicitud,
            'domicilio'     => $domicilio,
            'persona'       => $persona,
        ));
    }

    private function solicitudForm(SolicitudFichaSocial $solicitud, Persona $persona)
    {
        $form = $this->createForm(new SolicitudFichaSocialType(), $solicitud, array(
            'action' => $this->generateUrl('proceso_solicitud_ingresar', array('id' => $persona->getId())),
            'method' => 'POST',
        ))
        ->remove('estado')
        ->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => ' Finalizar', 'attr' => array('icon' => 'ok')]],
            ]
        ]);

        return $form;
    }

    public function finalizarAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $persona = $em->getRepository('SigFichasocialBundle:Persona')->find($id);
        $domicilio = $em->getRepository('SigFichasocialBundle:Domicilio')->findOneByPersona($id, array('createdAt' => 'DESC'));
        $solicitud = $em->getRepository('SigFichasocialBundle:SolicitudFichaSocial')->findOneByPersona($id, array('createdAt' => 'DESC'));

        return $this->render('SigFichasocialBundle:ProcesoSolicitud:finalizar.html.twig', array(
            'solicitud'     => $solicitud,
            'domicilio'     => $domicilio,
            'persona'       => $persona,
        ));
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