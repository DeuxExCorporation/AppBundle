<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Menus
 *
 * @ORM\Table(name="menus")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\MenusRepository")
 * @UniqueEntity("nombre")
 */
class Menus
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
	 * @Assert\NotBlank(message="menu.name.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 10,
	 *      minMessage = "menu.name.min",
	 *      maxMessage = "menu.name.max"
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
     * @var boolean
     *
     * @ORM\Column(name="haveSubsecciones", type="boolean")
     */
    private $haveSubsecciones;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="estado", type="boolean")
	 */
	private $estado;

	/**
	 * @ORM\OneToMany(targetEntity="Destiny\AppBundle\Entity\Secciones", mappedBy="menu")
	 **/
	private $secciones;

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

	public function __toString()
	{
		return $this->getNombre();
	}

	public function __construct() {
		$this->secciones = new ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     * @return Menus
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
     * @return Menus
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
     * Set estado
     *
     * @param boolean $estado
     * @return Menus
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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Menus
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
     * @return Menus
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
     * Add secciones
     *
     * @param \Destiny\AppBundle\Entity\Secciones $secciones
     * @return Menus
     */
    public function addSeccione(\Destiny\AppBundle\Entity\Secciones $secciones)
    {
        $this->secciones[] = $secciones;

        return $this;
    }

    /**
     * Remove secciones
     *
     * @param \Destiny\AppBundle\Entity\Secciones $secciones
     */
    public function removeSeccione(\Destiny\AppBundle\Entity\Secciones $secciones)
    {
        $this->secciones->removeElement($secciones);
    }

    /**
     * Get secciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSecciones()
    {
        return $this->secciones;
    }


    /**
     * Set haveSubsecciones
     *
     * @param boolean $haveSubsecciones
     * @return Menus
     */
    public function setHaveSubsecciones($haveSubsecciones)
    {
        $this->haveSubsecciones = $haveSubsecciones;

        return $this;
    }

    /**
     * Get haveSubsecciones
     *
     * @return boolean 
     */
    public function getHaveSubsecciones()
    {
        return $this->haveSubsecciones;
    }
}
