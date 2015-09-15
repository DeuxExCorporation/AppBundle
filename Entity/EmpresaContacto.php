<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * EmpresaContacto
 *
 * @ORM\Table(name="empresa_contacto")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\EmpresaContactoRepository")
 * @UniqueEntity("nombre")
 */
class EmpresaContacto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nombre", type="string", length=255)
	 * @Assert\NotBlank(message="contacto.name.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 100,
	 *      minMessage = "contacto.name.min",
	 *      maxMessage = "contacto.name.max"
	 * )
	 *
	 */
	private $nombre;

	/**
	 * @var string
	 * @Gedmo\Slug(fields={"nombre"})
	 * @ORM\Column(name="slug", type="string", length=255)
	 */
	private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     * @Assert\NotBlank(message="contacto.direccion.notblank")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "contacto.direccion.min",
     * )
     *
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="ciudad", type="string", length=255)
     * @Assert\NotBlank(message="contacto.ciudad.notblank")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "contacto.ciudad.min",
     * )
     */
    private $ciudad;

    /**
     * @var string
     *
     * @ORM\Column(name="provincia", type="string", length=255)
     * @Assert\NotBlank(message="contacto.provincia.notblank")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "contacto.provincia.min",
     * )
     */
    private $provincia;

    /**
     * @var string
     *
     * @ORM\Column(name="pais", type="string", length=255)
     * @Assert\NotBlank(message="contacto.pais.notblank")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "contacto.pais.min",
     * )
     */
    private $pais;

    /**
     * @var integer
     *
     * @ORM\Column(name="telefono", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="contacto.numero")
     */
    private $telefono;

    /**
     * @var integer
     *
     * @ORM\Column(name="movil", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="contacto.numero")
     */
    private $movil;

    /**
     * @var integer
     *
     * @ORM\Column(name="fax", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="contacto.numero")
     */
    private $fax;

	/**
	 * @var \DateTime
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(name="fechaCreacion", type="datetime")
	 */
	private $fechaCreacion;

	/**
	 * @var \DateTime
	 * @Gedmo\Timestampable(on="update")
	 * @ORM\Column(name="fechaModificacion", type="datetime")
	 */
	private $fechaModificacion;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="estado", type="boolean")
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

	public function __toString()
	{
		return $this->getNombre();
	}

	public function getDireccionCompleta()
	{
		return $this->getDireccion() .', ' .
			$this->getCiudad() .'( ' .$this->getProvincia() .',' .$this->getPais() .')';
	}
    /**
     * Set nombre
     *
     * @param string $nombre
     * @return EmpresaContacto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return EmpresaContacto
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return EmpresaContacto
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     * @return EmpresaContacto
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string 
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     * @return EmpresaContacto
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set pais
     *
     * @param string $pais
     * @return EmpresaContacto
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string 
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return EmpresaContacto
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
     * Set movil
     *
     * @param integer $movil
     * @return EmpresaContacto
     */
    public function setMovil($movil)
    {
        $this->movil = $movil;

        return $this;
    }

    /**
     * Get movil
     *
     * @return integer 
     */
    public function getMovil()
    {
        return $this->movil;
    }

    /**
     * Set fax
     *
     * @param integer $fax
     * @return EmpresaContacto
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return integer 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return EmpresaContacto
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime 
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return EmpresaContacto
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return \DateTime 
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     * @return EmpresaContacto
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
}
