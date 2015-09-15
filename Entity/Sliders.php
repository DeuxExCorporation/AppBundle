<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sliders
 *
 * @ORM\Table(name="sliders")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\SlidersRepository")
 * @UniqueEntity("nombre")
 */
class Sliders
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
     * @Assert\NotBlank(message="sliders.alt.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 150,
     *      minMessage = "sliders.alt.min",
     *      maxMessage = "sliders.alt.max"
     * )
     */
    private $nombre;

	/**
	 * @var string
	 * @ORM\Column(name="slug", type="string", length=255)
	 * @Gedmo\Slug(fields={"nombre"})
	 */
	private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     * @Assert\NotBlank(message="sliders.descripcion.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 200,
     *      minMessage = "sliders.descripcion.min",
     *      maxMessage = "sliders.descripcion.max"
     * )
     */
    private $descripcion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

	/**
	 * @ORM\ManyToMany(targetEntity="Destiny\AppBundle\Entity\Imagenes")
	 * @ORM\JoinTable(name="slider_imagen",
	 *      joinColumns={@ORM\JoinColumn(name="slider_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="imagen_id", referencedColumnName="id")}
	 *      )
	 **/
	private $group;

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
     * @ORM\OneToMany(targetEntity="Destiny\AppBundle\Entity\SlidersTraducciones", mappedBy="canonica")
     **/
    private $traducciones;

	public function __toString()
	{
		return $this->getNombre();
	}

	public function getType()
	{
		return 'sliders';
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
     * @return Sliders
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Sliders
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     * @return Sliders
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
     * Constructor
     */
    public function __construct()
    {
        $this->group = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Sliders
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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Sliders
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
     * @return Sliders
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
     * Add group
     *
     * @param \Destiny\AppBundle\Entity\Imagenes $group
     * @return Sliders
     */
    public function addGroup(\Destiny\AppBundle\Entity\Imagenes $group)
    {
        $this->group[] = $group;

        return $this;
    }

    /**
     * Remove group
     *
     * @param \Destiny\AppBundle\Entity\Imagenes $group
     */
    public function removeGroup(\Destiny\AppBundle\Entity\Imagenes $group)
    {
        $this->group->removeElement($group);
    }

    /**
     * Get group
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroup()
    {
        return $this->group;
    }

	public function getListado()
	{
		if (!is_null($this->getSeccion())){
			return $this->getSeccion();
		}

		if (!is_null($this->getNoticia())){
			return $this->getNoticia();
		}
	}

    /**
     * Add traducciones
     *
     * @param \Destiny\AppBundle\Entity\VideosTraducciones $traducciones
     * @return Sliders
     */
    public function addTraducciones(\Destiny\AppBundle\Entity\SlidersTraducciones $traducciones)
    {
        $this->traducciones[] = $traducciones;

        return $this;
    }

    /**
     * Remove traducciones
     *
     * @param \Destiny\AppBundle\Entity\VideosTraducciones $traducciones
     */
    public function removeTraducciones(\Destiny\AppBundle\Entity\SlidersTraducciones $traducciones)
    {
        $this->traducciones->removeElement($traducciones);
    }

    /**
     * Get traducciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTraducciones()
    {
        return $this->traducciones;
    }

    /**
     * Add traducciones
     *
     * @param \Destiny\AppBundle\Entity\SlidersTraducciones $traducciones
     * @return Sliders
     */
    public function addTraduccione(\Destiny\AppBundle\Entity\SlidersTraducciones $traducciones)
    {
        $this->traducciones[] = $traducciones;

        return $this;
    }

    /**
     * Remove traducciones
     *
     * @param \Destiny\AppBundle\Entity\SlidersTraducciones $traducciones
     */
    public function removeTraduccione(\Destiny\AppBundle\Entity\SlidersTraducciones $traducciones)
    {
        $this->traducciones->removeElement($traducciones);
    }
}
