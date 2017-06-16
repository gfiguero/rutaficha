<?php

namespace Sig\FichasocialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventoSolicitud
 */
class EventoSolicitud
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \Sig\FichasocialBundle\Entity\SolicitudFichaSocial
     */
    private $solicitud;

    /**
     * @var \Sig\FichasocialBundle\Entity\Usuario
     */
    private $usuario;

    /**
     * @var \Sig\FichasocialBundle\Entity\TipoEvento
     */
    private $tipo;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return EventoSolicitud
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return EventoSolicitud
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set solicitud
     *
     * @param \Sig\FichasocialBundle\Entity\SolicitudFichaSocial $solicitud
     * @return EventoSolicitud
     */
    public function setSolicitud(\Sig\FichasocialBundle\Entity\SolicitudFichaSocial $solicitud = null)
    {
        $this->solicitud = $solicitud;

        return $this;
    }

    /**
     * Get solicitud
     *
     * @return \Sig\FichasocialBundle\Entity\SolicitudFichaSocial 
     */
    public function getSolicitud()
    {
        return $this->solicitud;
    }

    /**
     * Set usuario
     *
     * @param \Sig\FichasocialBundle\Entity\Usuario $usuario
     * @return EventoSolicitud
     */
    public function setUsuario(\Sig\FichasocialBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Sig\FichasocialBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set tipo
     *
     * @param \Sig\FichasocialBundle\Entity\TipoEvento $tipo
     * @return EventoSolicitud
     */
    public function setTipo(\Sig\FichasocialBundle\Entity\TipoEvento $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \Sig\FichasocialBundle\Entity\TipoEvento 
     */
    public function getTipo()
    {
        return $this->tipo;
    }
}
