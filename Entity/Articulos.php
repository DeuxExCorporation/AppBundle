<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Articulo
 *
 * @ORM\Table(name="articulos")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\ArticulosRepository")
 */
class Articulos
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
	 * @ORM\Column(name="titulo", type="string", length=255)
	 * @Assert\NotBlank(message="articulo.titulo.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 150,
	 *      minMessage = "articulo.titulo.min",
	 *      maxMessage = "articulo.titulo.max"
	 * )
	 */
	private $titulo;


	/**
	 * @var string
	 * @Gedmo\Slug(fields={"titulo"})
	 * @ORM\Column(name="slug", type="string", length=255)
	 */
	private $slug;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="descripcion", type="text")
	 * @Assert\NotBlank(message="articulo.descripcion.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      minMessage = "articulo.descripcion.min",
	 * )
	 */
    private $descripcion;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="posicion", type="integer")
	 */
	private $posicion;

	/**
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Secciones",
	 *     cascade={"persist"}, inversedBy="contenidos")
	 * @ORM\JoinColumn(name="seccion_id", nullable=true, referencedColumnName="id", onDelete="CASCADE")
	 **/
	private $seccion;

	/**
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Noticias",
	 *     cascade={"persist"})
	 * @ORM\JoinColumn(name="noticia_id", nullable=true, referencedColumnName="id", onDelete="CASCADE")
	 **/
	private $noticia;

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
     * @ORM\OneToMany(targetEntity="Destiny\AppBundle\Entity\ArticulosTraducciones", mappedBy="canonica")
     **/
    private $traducciones;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

	public function __toString()
	{
		return $this->getTitulo();
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

	public function getType()
	{
		return 'articulos';
	}

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Articulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Articulo
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
     * Set posicion
     *
     * @param string $posicion
     * @return Articulo
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;

        return $this;
    }

    /**
     * Get posicion
     *
     * @return string 
     */
    public function getPosicion()
    {
        return $this->posicion;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Articulos
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
     * @return Articulos
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
     * @return Articulos
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
     * @return Articulos
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
     * Set seccion
     *
     * @param \Destiny\AppBundle\Entity\Secciones $seccion
     * @return Articulos
     */
    public function setSeccion(\Destiny\AppBundle\Entity\Secciones $seccion)
    {
        $this->seccion = $seccion;

        return $this;
    }

    /**
     * Get seccion
     *
     * @return \Destiny\AppBundle\Entity\Secciones 
     */
    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * Set noticia
     *
     * @param \Destiny\AppBundle\Entity\Noticias $noticia
     * @return Articulos
     */
    public function setNoticia(\Destiny\AppBundle\Entity\Noticias $noticia = null)
    {
        $this->noticia = $noticia;

        return $this;
    }

    /**
     * Get noticia
     *
     * @return \Destiny\AppBundle\Entity\Noticias 
     */
    public function getNoticia()
    {
        return $this->noticia;
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
     * Constructor
     */
    public function __construct()
    {
        $this->traducciones = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add traducciones
     *
     * @param \Destiny\AppBundle\Entity\ArticulosTraducciones $traducciones
     * @return Articulos
     */
    public function addTraduccione(\Destiny\AppBundle\Entity\ArticulosTraducciones $traducciones)
    {
        $this->traducciones[] = $traducciones;

        return $this;
    }

    /**
     * Remove traducciones
     *
     * @param \Destiny\AppBundle\Entity\ArticulosTraducciones $traducciones
     */
    public function removeTraduccione(\Destiny\AppBundle\Entity\ArticulosTraducciones $traducciones)
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
}
