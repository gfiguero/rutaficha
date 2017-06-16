<?php

namespace Sig\FichasocialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Persona
 */
class Persona
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $rut;

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
     * Set rut
     *
     * @param string $rut
     * @return Persona
     */
    public function setRut($rut)
    {
        $this->rut = $rut;

        return $this;
    }

    /**
     * Get rut
     *
     * @return string 
     */
    public function getRut()
    {
        return $this->rut;
    }

    /**
     * Set primer_nombre
     *
     * @param string $primerNombre
     * @return Persona
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
     * @return Persona
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
     * @return Persona
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
     * @return Persona
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Persona
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
     * @return Persona
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
     * @return Persona
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
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $celular;

    /**
     * @var string
     */
    private $telefono;


    /**
     * Set email
     *
     * @param string $email
     * @return Persona
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set celular
     *
     * @param string $celular
     * @return Persona
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string 
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Persona
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
}
