<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;



/**
 * NoticiasContenido
 *
 * @ORM\Table(name="noticias_contenido")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\NoticiasContenidoRepository")
 */
class NoticiasContenido
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
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Noticias",
	 *     cascade={"persist"}, inversedBy="contenidos")
	 * @ORM\JoinColumn(name="seccion_id", nullable=false, referencedColumnName="id", onDelete="CASCADE")
	 **/
	private $seccion;

    /**
     * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Articulos",
     *     cascade={"persist"})
     * @ORM\JoinColumn(name="articulos_id", nullable=true, referencedColumnName="id", onDelete="CASCADE")
     **/
    private $articulos;

	/**
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Videos",
	 *     cascade={"persist"})
	 * @ORM\JoinColumn(name="videos_id", nullable=true, referencedColumnName="id", onDelete="CASCADE")
	 **/
	private $videos;

	/**
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Imagenes",
	 *     cascade={"persist"})
	 * @ORM\JoinColumn(name="imagenes_id", nullable=true, referencedColumnName="id", onDelete="CASCADE")
	 **/
	private $imagenes;

	/**
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Sliders",
	 *     cascade={"persist"})
	 * @ORM\JoinColumn(name="sliders_id", nullable=true, referencedColumnName="id", onDelete="CASCADE")
	 **/
	private $sliders;

	/**
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Adjuntos",
	 *     cascade={"persist"})
	 * @ORM\JoinColumn(name="adjuntos_id", nullable=true, referencedColumnName="id", onDelete="CASCADE")
	 **/
	private $adjuntos;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="posicion", type="integer")
	 */
	private $posicion;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="estado", type="boolean")
	 */
	private $estado = true;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="changablePostion", type="boolean")
	 */
	private $changablePostion = true;

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


		switch($this){
			case (!(is_null($this->getVideos()))):
				return $this->getVideos()->getNombre();
				break;

			case (!(is_null($this->getImagenes()))):
				return $this->getImagenes()->getNombre();
				break;

			case (!(is_null($this->getSliders()))):
				return $this->getSliders()->getNombre();
				break;

			case (!(is_null($this->getAdjuntos()))):
				return $this->getAdjuntos()->getNombre();
				break;

			case (!(is_null($this->getArticulos()))):
				return $this->getArticulos()->getTitulo();
				break;
		}
	}

	public function getType()
	{

		switch($this){
			case (!(is_null($this->getVideos()))):
				return $this->getVideos()->getType();
				break;
			case (!(is_null($this->getImagenes()))):
				return $this->getImagenes()->getType();
				break;

			case (!(is_null($this->getAdjuntos()))):
				return $this->getAdjuntos()->getType();
				break;

			case (!(is_null($this->getSliders()))):
				return $this->getSliders()->getType();
				break;

			case (!(is_null($this->getArticulos()))):
				return $this->getArticulos()->getType();
				break;
		}

	}

	public function getEntity()
	{
		switch($this){
			case (!(is_null($this->getVideos()))):
				return $this->getVideos();
				break;
			case (!(is_null($this->getImagenes()))):
				return $this->getImagenes();
				break;

			case (!(is_null($this->getAdjuntos()))):
				return $this->getAdjuntos();
				break;

			case (!(is_null($this->getSliders()))):
				return $this->getSliders();
				break;

			case (!(is_null($this->getArticulos()))):
				return $this->getArticulos();
				break;
		}


	}

	public function getSlug()
	{
		switch($this){
			case (!(is_null($this->getVideos()))):
				return $this->getVideos()->getSlug();
				break;
			case (!(is_null($this->getImagenes()))):
				return $this->getImagenes()->getSlug();
				break;

			case (!(is_null($this->getAdjuntos()))):
				return $this->getAdjuntos()->getSlug();
				break;

			case (!(is_null($this->getSliders()))):
				return $this->getSliders()->getSlug();
				break;

			case (!(is_null($this->getArticulos()))):
				return $this->getArticulos()->getSlug();
				break;
		}
	}

	public function getListado()
	{
		return $this->getSeccion();
	}

 
    /**
     * Set posicion
     *
     * @param integer $posicion
     * @return NoticiasContenido
     */
    public function setPosicion($posicion)
    {

	    if (!is_null(($this->getArticulos())))
	    {
		    $this->posicion = $this->getArticulos()->getPosicion();
	    } else
	    {
		    $this->posicion = $posicion;
	    }



        return $this;
    }

    /**
     * Get posicion
     *
     * @return integer 
     */
    public function getPosicion()
    {
        if (!is_null(($this->getArticulos())))
	    {
		    return $this->getArticulos()->getPosicion();
	    }
        return $this->posicion;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     * @return NoticiasContenido
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
     * Set changablePostion
     *
     * @param boolean $changablePostion
     * @return NoticiasContenido
     */
    public function setChangablePostion($changablePostion)
    {
        $this->changablePostion = $changablePostion;

        return $this;
    }

    /**
     * Get changablePostion
     *
     * @return boolean 
     */
    public function getChangablePostion()
    {
        return $this->changablePostion;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return NoticiasContenido
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
     * @return NoticiasContenido
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
     * @param \Destiny\AppBundle\Entity\Noticias $seccion
     * @return NoticiasContenido
     */
    public function setSeccion(\Destiny\AppBundle\Entity\Noticias $seccion)
    {
        $this->seccion = $seccion;

        return $this;
    }

    /**
     * Get seccion
     *
     * @return \Destiny\AppBundle\Entity\Noticias 
     */
    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * Set articulos
     *
     * @param \Destiny\AppBundle\Entity\Articulos $articulos
     * @return NoticiasContenido
     */
    public function setArticulos(\Destiny\AppBundle\Entity\Articulos $articulos = null)
    {
        $this->articulos = $articulos;

        return $this;
    }

    /**
     * Get articulos
     *
     * @return \Destiny\AppBundle\Entity\Articulos 
     */
    public function getArticulos()
    {
        return $this->articulos;
    }

    /**
     * Set videos
     *
     * @param \Destiny\AppBundle\Entity\Videos $videos
     * @return NoticiasContenido
     */
    public function setVideos(\Destiny\AppBundle\Entity\Videos $videos = null)
    {
        $this->videos = $videos;

        return $this;
    }

    /**
     * Get videos
     *
     * @return \Destiny\AppBundle\Entity\Videos 
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Set imagenes
     *
     * @param \Destiny\AppBundle\Entity\Imagenes $imagenes
     * @return NoticiasContenido
     */
    public function setImagenes(\Destiny\AppBundle\Entity\Imagenes $imagenes = null)
    {
        $this->imagenes = $imagenes;

        return $this;
    }

    /**
     * Get imagenes
     *
     * @return \Destiny\AppBundle\Entity\Imagenes 
     */
    public function getImagenes()
    {
        return $this->imagenes;
    }

    /**
     * Set sliders
     *
     * @param \Destiny\AppBundle\Entity\Sliders $sliders
     * @return NoticiasContenido
     */
    public function setSliders(\Destiny\AppBundle\Entity\Sliders $sliders = null)
    {
        $this->sliders = $sliders;

        return $this;
    }

    /**
     * Get sliders
     *
     * @return \Destiny\AppBundle\Entity\Sliders 
     */
    public function getSliders()
    {
        return $this->sliders;
    }

    /**
     * Set adjuntos
     *
     * @param \Destiny\AppBundle\Entity\Adjuntos $adjuntos
     * @return NoticiasContenido
     */
    public function setAdjuntos(\Destiny\AppBundle\Entity\Adjuntos $adjuntos = null)
    {
        $this->adjuntos = $adjuntos;

        return $this;
    }

    /**
     * Get adjuntos
     *
     * @return \Destiny\AppBundle\Entity\Adjuntos 
     */
    public function getAdjuntos()
    {
        return $this->adjuntos;
    }
}
