<?php

namespace Wapp\ProveedorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EstadoCuenta
 *
 * @ORM\Table(name="estado_cuenta", indexes={@ORM\Index(name="acreedor", columns={"proveedor_id"}), @ORM\Index(name="proveedor_id", columns={"proveedor_id"})})
 * @ORM\Entity
 */
class EstadoCuenta
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=512, nullable=false)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="referencia", type="string", length=512, nullable=false)
     */
    private $referencia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_pago", type="date", nullable=false)
     */
    private $fechaPago = '0000-00-00';

    /**
     * @var string
     *
     * @ORM\Column(name="numero_documento", type="string", length=512, nullable=false)
     */
    private $numeroDocumento;

    /**
     * @var string
     *
     * @ORM\Column(name="clase", type="string", length=512, nullable=false)
     */
    private $clase;

    /**
     * @var string
     *
     * @ORM\Column(name="bloqueo_pago", type="string", length=512, nullable=false)
     */
    private $bloqueoPago;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_documento", type="date", nullable=false)
     */
    private $fechaDocumento = '0000-00-00';

    /**
     * @var string
     *
     * @ORM\Column(name="vencimiento_neto", type="string", length=512, nullable=false)
     */
    private $vencimientoNeto;

    /**
     * @var string
     *
     * @ORM\Column(name="importe_mi", type="string", length=512, nullable=false)
     */
    private $importeMi;

    /**
     * @var string
     *
     * @ORM\Column(name="dv", type="string", length=512, nullable=false)
     */
    private $dv;

    /**
     * @var string
     *
     * @ORM\Column(name="texto", type="text", length=65535, nullable=false)
     */
    private $texto;

    /**
     * @var \Proveedor
     *
     * @ORM\ManyToOne(targetEntity="Proveedor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proveedor_id", referencedColumnName="id")
     * })
     */
    private $proveedor;



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
     * Set estado
     *
     * @param string $estado
     *
     * @return EstadoCuenta
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set referencia
     *
     * @param string $referencia
     *
     * @return EstadoCuenta
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get referencia
     *
     * @return string
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Set fechaPago
     *
     * @param \DateTime $fechaPago
     *
     * @return EstadoCuenta
     */
    public function setFechaPago($fechaPago)
    {
        $this->fechaPago = $fechaPago;

        return $this;
    }

    /**
     * Get fechaPago
     *
     * @return \DateTime
     */
    public function getFechaPago()
    {
        return $this->fechaPago;
    }

    /**
     * Set numeroDocumento
     *
     * @param string $numeroDocumento
     *
     * @return EstadoCuenta
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numeroDocumento = $numeroDocumento;

        return $this;
    }

    /**
     * Get numeroDocumento
     *
     * @return string
     */
    public function getNumeroDocumento()
    {
        return $this->numeroDocumento;
    }

    /**
     * Set clase
     *
     * @param string $clase
     *
     * @return EstadoCuenta
     */
    public function setClase($clase)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase
     *
     * @return string
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Set bloqueoPago
     *
     * @param string $bloqueoPago
     *
     * @return EstadoCuenta
     */
    public function setBloqueoPago($bloqueoPago)
    {
        $this->bloqueoPago = $bloqueoPago;

        return $this;
    }

    /**
     * Get bloqueoPago
     *
     * @return string
     */
    public function getBloqueoPago()
    {
        return $this->bloqueoPago;
    }

    /**
     * Set fechaDocumento
     *
     * @param \DateTime $fechaDocumento
     *
     * @return EstadoCuenta
     */
    public function setFechaDocumento($fechaDocumento)
    {
        $this->fechaDocumento = $fechaDocumento;

        return $this;
    }

    /**
     * Get fechaDocumento
     *
     * @return \DateTime
     */
    public function getFechaDocumento()
    {
        return $this->fechaDocumento;
    }

    /**
     * Set vencimientoNeto
     *
     * @param string $vencimientoNeto
     *
     * @return EstadoCuenta
     */
    public function setVencimientoNeto($vencimientoNeto)
    {
        $this->vencimientoNeto = $vencimientoNeto;

        return $this;
    }

    /**
     * Get vencimientoNeto
     *
     * @return string
     */
    public function getVencimientoNeto()
    {
        return $this->vencimientoNeto;
    }

    /**
     * Set importeMi
     *
     * @param string $importeMi
     *
     * @return EstadoCuenta
     */
    public function setImporteMi($importeMi)
    {
        $this->importeMi = $importeMi;

        return $this;
    }

    /**
     * Get importeMi
     *
     * @return string
     */
    public function getImporteMi()
    {
        return $this->importeMi;
    }

    /**
     * Set dv
     *
     * @param string $dv
     *
     * @return EstadoCuenta
     */
    public function setDv($dv)
    {
        $this->dv = $dv;

        return $this;
    }

    /**
     * Get dv
     *
     * @return string
     */
    public function getDv()
    {
        return $this->dv;
    }

    /**
     * Set texto
     *
     * @param string $texto
     *
     * @return EstadoCuenta
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set proveedor
     *
     * @param \Wapp\ProveedorBundle\Entity\Proveedor $proveedor
     *
     * @return EstadoCuenta
     */
    public function setProveedor(\Wapp\ProveedorBundle\Entity\Proveedor $proveedor = null)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor
     *
     * @return \Wapp\ProveedorBundle\Entity\Proveedor
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }
}
