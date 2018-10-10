<?php

namespace Wapp\ProveedorBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Proveedor
 *
 * @ORM\Table(name="proveedor", uniqueConstraints={@ORM\UniqueConstraint(name="nit", columns={"nit"})})
 * @ORM\Entity
 */
class Proveedor implements UserInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nit", type="string", length=25, nullable=false)
     */
    private $nit;

    /**
     * @var string
     *
     * @ORM\Column(name="razon_social", type="string", length=250, nullable=false)
     */
    private $razonSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_contacto", type="string", length=250, nullable=false)
     */
    private $nombreContacto;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="contrasena", type="string", length=30, nullable=false)
     */
    private $contrasena;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="actualizacion", type="datetime", nullable=false)
     */
    private $actualizacion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean", nullable=false)
     */
    private $estado = '1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cambio_clave", type="date", nullable=false)
     */
    private $cambioClave;

    /**
     * @var string
     *
     * @ORM\Column(name="ultima_clave", type="string", length=30, nullable=false)
     */
    private $ultimaClave;
	
	/**
     * @var boolean
     *
     * @ORM\Column(name="public", type="boolean", nullable=false)
     */
    private $public = '1';


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
     * Set nit
     *
     * @param string $nit
     *
     * @return Proveedor
     */
    public function setNit($nit)
    {
        $this->nit = $nit;

        return $this;
    }

    /**
     * Get nit
     *
     * @return string
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * Set razonSocial
     *
     * @param string $razonSocial
     *
     * @return Proveedor
     */
    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    /**
     * Get razonSocial
     *
     * @return string
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * Set nombreContacto
     *
     * @param string $nombreContacto
     *
     * @return Proveedor
     */
    public function setNombreContacto($nombreContacto)
    {
        $this->nombreContacto = $nombreContacto;

        return $this;
    }

    /**
     * Get nombreContacto
     *
     * @return string
     */
    public function getNombreContacto()
    {
        return $this->nombreContacto;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Proveedor
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
     * Set contrasena
     *
     * @param string $contrasena
     *
     * @return Proveedor
     */
    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;

        return $this;
    }

    /**
     * Get contrasena
     *
     * @return string
     */
    public function getContrasena()
    {
        return $this->contrasena;
    }

    /**
     * Set actualizacion
     *
     * @param \DateTime $actualizacion
     *
     * @return Proveedor
     */
    public function setActualizacion($actualizacion)
    {
        $this->actualizacion = $actualizacion;

        return $this;
    }

    /**
     * Get actualizacion
     *
     * @return \DateTime
     */
    public function getActualizacion()
    {
        return $this->actualizacion;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Proveedor
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set cambioClave
     *
     * @param \DateTime $cambioClave
     *
     * @return Proveedor
     */
    public function setCambioClave($cambioClave)
    {
        $this->cambioClave = $cambioClave;

        return $this;
    }

    /**
     * Get cambioClave
     *
     * @return \DateTime
     */
    public function getCambioClave()
    {
        return $this->cambioClave;
    }

    /**
     * Set ultimaClave
     *
     * @param string $ultimaClave
     *
     * @return Proveedor
     */
    public function setUltimaClave($ultimaClave)
    {
        $this->ultimaClave = $ultimaClave;

        return $this;
    }
	/**
     * Set public
     *
     * @param boolean $public
     *
     * @return Administrador
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get ultimaClave
     *
     * @return string
     */
    public function getUltimaClave()
    {
        return $this->ultimaClave;
    }
	
	/**
     * Get public
     *
     * @return boolean
     */
    public function getPublic()
    {
        return $this->public;
    }

    public function eraseCredentials() {
      $this->password = null;
    }

    public function getPassword() {
        return $this->getContrasena();
    }

    public function getRoles() {
        return array('ROLE_USER');
    }

    public function getSalt() {
        
    }
    public function getUsername() {
        return $this->getRazonSocial();
    }
	
	public function getContacto() {
        return $this->getNombreContacto();
    }
}
