<?php

namespace Destiny\AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * EmpresaRedesSociales
 *
 * @ORM\Table(name="empresa_redessociales")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\EmpresaRedesSocialesRepository")
 * @UniqueEntity("nombre")
 */
class EmpresaRedesSociales
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
	 * @ORM\Column(name="nombre", type="string")
	 * @ORM\Column(name="nombre", type="string", length=255)
	 * @Assert\NotBlank(message="redes.name.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 10,
	 *      minMessage = "redes.name.min",
	 *      maxMessage = "redes.name.max"
	 * )
	 */
	private $nombre;

	/**
	 * @var string
	 * @Gedmo\Slug(fields={"nombre"})
	 * @ORM\Column(name="slug", type="string", length=255)
	 */
	private $slug;

	/**
	 * @ORM\Column(name="url", type="string")
	 */
	private $url;

	/**
	 * @ORM\Column(name="iconoFA", type="string")
	 */
	private $iconoFA;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="estado", type="boolean")
	 */
	private $estado;

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

	public function __toString ()
	{
		return $this->getIconoFA () . ' ' . $this->getNombre ();
	}

	/**
	 * Get iconoFA
	 *
	 * @return string
	 */
	public function getIconoFA ()
	{
		return $this->iconoFA;
	}

	/**
	 * Set iconoFA
	 *
	 * @param string $iconoFA
	 *
	 * @return EmpresaRedesSociales
	 */
	public function setIconoFA ($iconoFA)
	{
		$this->iconoFA = $iconoFA;

		return $this;
	}

	/**
	 * Get nombre
	 *
	 * @return string
	 */
	public function getNombre ()
	{
		return $this->nombre;
	}

	/**
	 * Set nombre
	 *
	 * @param string $nombre
	 *
	 * @return EmpresaRedesSociales
	 */
	public function setNombre ($nombre)
	{
		$this->nombre = $nombre;

		return $this;
	}

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId ()
	{
		return $this->id;
	}

	/**
	 * Get url
	 *
	 * @return string
	 */
	public function getUrl ()
	{
		return $this->url;
	}

	/**
	 * Set url
	 *
	 * @param string $url
	 *
	 * @return EmpresaRedesSociales
	 */
	public function setUrl ($url)
	{
		$this->url = $url;

		return $this;
	}

	/**
	 * Get estado
	 *
	 * @return boolean
	 */
	public function getEstado ()
	{
		return $this->estado;
	}

	/**
	 * Set estado
	 *
	 * @param boolean $estado
	 *
	 * @return EmpresaRedesSociales
	 */
	public function setEstado ($estado)
	{
		$this->estado = $estado;

		return $this;
	}

	/**
	 * Get fechaCreacion
	 *
	 * @return \DateTime
	 */
	public function getFechaCreacion ()
	{
		return $this->fechaCreacion;
	}

	/**
	 * Set fechaCreacion
	 *
	 * @param \DateTime $fechaCreacion
	 *
	 * @return EmpresaRedesSociales
	 */
	public function setFechaCreacion ($fechaCreacion)
	{
		$this->fechaCreacion = $fechaCreacion;

		return $this;
	}

	/**
	 * Get fechaModificacion
	 *
	 * @return \DateTime
	 */
	public function getFechaModificacion ()
	{
		return $this->fechaModificacion;
	}

	/**
	 * Set fechaModificacion
	 *
	 * @param \DateTime $fechaModificacion
	 *
	 * @return EmpresaRedesSociales
	 */
	public function setFechaModificacion ($fechaModificacion)
	{
		$this->fechaModificacion = $fechaModificacion;

		return $this;
	}

	/**
	 * Get slug
	 *
	 * @return string
	 */
	public function getSlug ()
	{
		return $this->slug;
	}

	/**
	 * Set slug
	 *
	 * @param string $slug
	 *
	 * @return EmpresaRedesSociales
	 */
	public function setSlug ($slug)
	{
		$this->slug = $slug;

		return $this;
	}
}
