<?php

namespace Sig\FichasocialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SolicitudFichaSocial
 */
class SolicitudFichaSocial
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \DateTime
     */
    private $deletedAt;

    /**
     * @var \Sig\FichasocialBundle\Entity\Domicilio
     */
    private $domicilio;

    /**
     * @var \Sig\FichasocialBundle\Entity\Persona
     */
    private $persona;

    /**
     * @var \Sig\FichasocialBundle\Entity\EstadoSolicitudFichaSocial
     */
    private $estado;


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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return SolicitudFichaSocial
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return SolicitudFichaSocial
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return SolicitudFichaSocial
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set domicilio
     *
     * @param \Sig\FichasocialBundle\Entity\Domicilio $domicilio
     * @return SolicitudFichaSocial
     */
    public function setDomicilio(\Sig\FichasocialBundle\Entity\Domicilio $domicilio = null)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio
     *
     * @return \Sig\FichasocialBundle\Entity\Domicilio 
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Set persona
     *
     * @param \Sig\FichasocialBundle\Entity\Persona $persona
     * @return SolicitudFichaSocial
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
     * Set estado
     *
     * @param \Sig\FichasocialBundle\Entity\EstadoSolicitudFichaSocial $estado
     * @return SolicitudFichaSocial
     */
    public function setEstado(\Sig\FichasocialBundle\Entity\EstadoSolicitudFichaSocial $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \Sig\FichasocialBundle\Entity\EstadoSolicitudFichaSocial 
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
