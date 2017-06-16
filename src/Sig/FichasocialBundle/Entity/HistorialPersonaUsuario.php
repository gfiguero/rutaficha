<?php

namespace Sig\FichasocialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistorialPersonaUsuario
 */
class HistorialPersonaUsuario
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
     * @var \Sig\FichasocialBundle\Entity\Persona
     */
    private $persona;

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
     * @return HistorialPersonaUsuario
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
     * @return HistorialPersonaUsuario
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
     * Set persona
     *
     * @param \Sig\FichasocialBundle\Entity\Persona $persona
     * @return HistorialPersonaUsuario
     */
    public function setPersona(\Sig\FichasocialBundle\Entity\Persona $persona = null)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \Sig\FichasocialBundle\Entity\Persona 
     */
    public function getPersona()
    {
        return $this->persona;
    }

    /**
     * Set usuario
     *
     * @param \Sig\FichasocialBundle\Entity\Usuario $usuario
     * @return HistorialPersonaUsuario
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
     * @return HistorialPersonaUsuario
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
    /**
     * @var boolean
     */
    private $detalle;


    /**
     * Set detalle
     *
     * @param boolean $detalle
     * @return HistorialPersonaUsuario
     */
    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;

        return $this;
    }

    /**
     * Get detalle
     *
     * @return boolean 
     */
    public function getDetalle()
    {
        return $this->detalle;
    }
}
