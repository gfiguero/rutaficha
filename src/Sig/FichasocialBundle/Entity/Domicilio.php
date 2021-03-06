<?php

namespace Sig\FichasocialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Domicilio
 */
class Domicilio
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $calle;

    /**
     * @var integer
     */
    private $numero;

    /**
     * @var string
     */
    private $rol;

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
     * @var \Sig\FichasocialBundle\Entity\Persona
     */
    private $persona;


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
     * Set calle
     *
     * @param string $calle
     * @return Domicilio
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     * @return Domicilio
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set rol
     *
     * @param string $rol
     * @return Domicilio
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return string 
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Domicilio
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
     * @return Domicilio
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
     * @return Domicilio
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
     * Set persona
     *
     * @param \Sig\FichasocialBundle\Entity\Persona $persona
     * @return Domicilio
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
     * @var string
     */
    private $poblacion;

    /**
     * @var string
     */
    private $edificio;

    /**
     * @var string
     */
    private $departamento;

    /**
     * @var string
     */
    private $casa;

    /**
     * @var string
     */
    private $chacra;

    /**
     * @var string
     */
    private $parcela;

    /**
     * @var string
     */
    private $paradero;

    /**
     * @var string
     */
    private $sector;


    /**
     * Set poblacion
     *
     * @param string $poblacion
     * @return Domicilio
     */
    public function setPoblacion($poblacion)
    {
        $this->poblacion = $poblacion;

        return $this;
    }

    /**
     * Get poblacion
     *
     * @return string 
     */
    public function getPoblacion()
    {
        return $this->poblacion;
    }

    /**
     * Set edificio
     *
     * @param string $edificio
     * @return Domicilio
     */
    public function setEdificio($edificio)
    {
        $this->edificio = $edificio;

        return $this;
    }

    /**
     * Get edificio
     *
     * @return string 
     */
    public function getEdificio()
    {
        return $this->edificio;
    }

    /**
     * Set departamento
     *
     * @param string $departamento
     * @return Domicilio
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return string 
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Set casa
     *
     * @param string $casa
     * @return Domicilio
     */
    public function setCasa($casa)
    {
        $this->casa = $casa;

        return $this;
    }

    /**
     * Get casa
     *
     * @return string 
     */
    public function getCasa()
    {
        return $this->casa;
    }

    /**
     * Set chacra
     *
     * @param string $chacra
     * @return Domicilio
     */
    public function setChacra($chacra)
    {
        $this->chacra = $chacra;

        return $this;
    }

    /**
     * Get chacra
     *
     * @return string 
     */
    public function getChacra()
    {
        return $this->chacra;
    }

    /**
     * Set parcela
     *
     * @param string $parcela
     * @return Domicilio
     */
    public function setParcela($parcela)
    {
        $this->parcela = $parcela;

        return $this;
    }

    /**
     * Get parcela
     *
     * @return string 
     */
    public function getParcela()
    {
        return $this->parcela;
    }

    /**
     * Set paradero
     *
     * @param string $paradero
     * @return Domicilio
     */
    public function setParadero($paradero)
    {
        $this->paradero = $paradero;

        return $this;
    }

    /**
     * Get paradero
     *
     * @return string 
     */
    public function getParadero()
    {
        return $this->paradero;
    }

    /**
     * Set sector
     *
     * @param string $sector
     * @return Domicilio
     */
    public function setSector($sector)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return string 
     */
    public function getSector()
    {
        return $this->sector;
    }
    /**
     * @var integer
     */
    private $rolId;


    /**
     * Set rolId
     *
     * @param integer $rolId
     * @return Domicilio
     */
    public function setRolId($rolId)
    {
        $this->rolId = $rolId;

        return $this;
    }

    /**
     * Get rolId
     *
     * @return integer 
     */
    public function getRolId()
    {
        return $this->rolId;
    }
    /**
     * @var integer
     */
    private $unidad;


    /**
     * Set unidad
     *
     * @param integer $unidad
     * @return Domicilio
     */
    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return integer 
     */
    public function getUnidad()
    {
        return $this->unidad;
    }
}
