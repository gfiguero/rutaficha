<?php

namespace Sig\FichasocialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * Usuario
 */
class Usuario extends BaseUser
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    private $primer_nombre;

    /**
     * @var string
     */
    private $segundo_nombre;

    /**
     * @var string
     */
    private $primer_apellido;

    /**
     * @var string
     */
    private $segundo_apellido;

    /**
     * @var string
     */
    private $telefono;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set primer_nombre
     *
     * @param string $primerNombre
     * @return Usuario
     */
    public function setPrimerNombre($primerNombre)
    {
        $this->primer_nombre = $primerNombre;

        return $this;
    }

    /**
     * Get primer_nombre
     *
     * @return string 
     */
    public function getPrimerNombre()
    {
        return $this->primer_nombre;
    }

    /**
     * Set segundo_nombre
     *
     * @param string $segundoNombre
     * @return Usuario
     */
    public function setSegundoNombre($segundoNombre)
    {
        $this->segundo_nombre = $segundoNombre;

        return $this;
    }

    /**
     * Get segundo_nombre
     *
     * @return string 
     */
    public function getSegundoNombre()
    {
        return $this->segundo_nombre;
    }

    /**
     * Set primer_apellido
     *
     * @param string $primerApellido
     * @return Usuario
     */
    public function setPrimerApellido($primerApellido)
    {
        $this->primer_apellido = $primerApellido;

        return $this;
    }

    /**
     * Get primer_apellido
     *
     * @return string 
     */
    public function getPrimerApellido()
    {
        return $this->primer_apellido;
    }

    /**
     * Set segundo_apellido
     *
     * @param string $segundoApellido
     * @return Usuario
     */
    public function setSegundoApellido($segundoApellido)
    {
        $this->segundo_apellido = $segundoApellido;

        return $this;
    }

    /**
     * Get segundo_apellido
     *
     * @return string 
     */
    public function getSegundoApellido()
    {
        return $this->segundo_apellido;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Usuario
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Usuario
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
     * @return Usuario
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
     * @return Usuario
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
}
