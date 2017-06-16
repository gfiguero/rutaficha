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
     * @var float
     */
    private $coordenadaX;

    /**
     * @var float
     */
    private $coordenadaY;

    /**
     * @var \Sig\FichasocialBundle\Entity\EstadoRutaFichaSocial
     */
    private $estado;

    /**
     * @var \Sig\FichasocialBundle\Entity\EncuestadorFichaSocial
     */
    private $encuestador_asignado;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $solicitudes_asignadas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->solicitudes_asignadas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set coordenadaX
     *
     * @param float $coordenadaX
     * @return RutaFichaSocial
     */
    public function setCoordenadaX($coordenadaX)
    {
        $this->coordenadaX = $coordenadaX;

        return $this;
    }

    /**
     * Get coordenadaX
     *
     * @return float 
     */
    public function getCoordenadaX()
    {
        return $this->coordenadaX;
    }

    /**
     * Set coordenadaY
     *
     * @param float $coordenadaY
     * @return RutaFichaSocial
     */
    public function setCoordenadaY($coordenadaY)
    {
        $this->coordenadaY = $coordenadaY;

        return $this;
    }

    /**
     * Get coordenadaY
     *
     * @return float 
     */
    public function getCoordenadaY()
    {
        return $this->coordenadaY;
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
     * Set encuestador_asignado
     *
     * @param \Sig\FichasocialBundle\Entity\EncuestadorFichaSocial $encuestadorAsignado
     * @return RutaFichaSocial
     */
    public function setEncuestadorAsignado(\Sig\FichasocialBundle\Entity\EncuestadorFichaSocial $encuestadorAsignado = null)
    {
        $this->encuestador_asignado = $encuestadorAsignado;

        return $this;
    }

    /**
     * Get encuestador_asignado
     *
     * @return \Sig\FichasocialBundle\Entity\EncuestadorFichaSocial 
     */
    public function getEncuestadorAsignado()
    {
        return $this->encuestador_asignado;
    }

    /**
     * Add solicitudes_asignadas
     *
     * @param \Sig\FichasocialBundle\Entity\SolicitudFichaSocial $solicitudesAsignadas
     * @return RutaFichaSocial
     */
    public function addSolicitudesAsignada(\Sig\FichasocialBundle\Entity\SolicitudFichaSocial $solicitudesAsignadas)
    {
        $this->solicitudes_asignadas[] = $solicitudesAsignadas;

        return $this;
    }

    /**
     * Remove solicitudes_asignadas
     *
     * @param \Sig\FichasocialBundle\Entity\SolicitudFichaSocial $solicitudesAsignadas
     */
    public function removeSolicitudesAsignada(\Sig\FichasocialBundle\Entity\SolicitudFichaSocial $solicitudesAsignadas)
    {
        $this->solicitudes_asignadas->removeElement($solicitudesAsignadas);
    }

    /**
     * Get solicitudes_asignadas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSolicitudesAsignadas()
    {
        return $this->solicitudes_asignadas;
    }
}
