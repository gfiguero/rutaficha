<?php

namespace Sig\FichasocialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RutaFichaSocial
 */
class RutaFichaSocial
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
     * @var \Sig\FichasocialBundle\Entity\EstadoRutaFichaSocial
     */
    private $estado;

    /**
     * @var \Sig\FichasocialBundle\Entity\EncuestadorFichaSocial
     */
    private $encuestador;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $solicitudes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->solicitudes = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return RutaFichaSocial
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
     * @return RutaFichaSocial
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
     * @return RutaFichaSocial
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
     * Set estado
     *
     * @param \Sig\FichasocialBundle\Entity\EstadoRutaFichaSocial $estado
     * @return RutaFichaSocial
     */
    public function setEstado(\Sig\FichasocialBundle\Entity\EstadoRutaFichaSocial $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \Sig\FichasocialBundle\Entity\EstadoRutaFichaSocial 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set encuestador
     *
     * @param \Sig\FichasocialBundle\Entity\EncuestadorFichaSocial $encuestador
     * @return RutaFichaSocial
     */
    public function setEncuestador(\Sig\FichasocialBundle\Entity\EncuestadorFichaSocial $encuestador = null)
    {
        $this->encuestador = $encuestador;

        return $this;
    }

    /**
     * Get encuestador
     *
     * @return \Sig\FichasocialBundle\Entity\EncuestadorFichaSocial 
     */
    public function getEncuestador()
    {
        return $this->encuestador;
    }

    /**
     * Add solicitudes
     *
     * @param \Sig\FichasocialBundle\Entity\SolicitudFichaSocial $solicitudes
     * @return RutaFichaSocial
     */
    public function addSolicitude(\Sig\FichasocialBundle\Entity\SolicitudFichaSocial $solicitudes)
    {
        $this->solicitudes[] = $solicitudes;

        return $this;
    }

    /**
     * Remove solicitudes
     *
     * @param \Sig\FichasocialBundle\Entity\SolicitudFichaSocial $solicitudes
     */
    public function removeSolicitude(\Sig\FichasocialBundle\Entity\SolicitudFichaSocial $solicitudes)
    {
        $this->solicitudes->removeElement($solicitudes);
    }

    /**
     * Get solicitudes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSolicitudes()
    {
        return $this->solicitudes;
    }
}
