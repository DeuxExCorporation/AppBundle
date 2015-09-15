<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;



/**
 * SeccionesContenido
 *
 * @ORM\Table(name="secciones_contenido")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\SeccionesContenidoRepository")
 *
 */
class SeccionesContenido
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
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Secciones",
	 *     cascade={"persist"}, inversedBy="contenidos")
	 * @ORM\JoinColumn(name="seccion_id", nullable=false, referencedColumnName="id", onDelete="CASCADE")
     *
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
     *
	 */
	private $posicion;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="estado", type="boolean")
	 */
	private $estado;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="changablePostion", type="boolean")
	 */
	private $changablePostion;

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


	public function __construct()
	{
		$this->tags = new ArrayCollection();
		$this->changablePostion = true;
        $this->estado = true;
	}

	public function __toString()
	{


		switch($this){
			case (!(is_null($this->getVideos())));
				return $this->getVideos()->getNombre();
				break;

			case (!(is_null($this->getImagenes())));
				return $this->getImagenes()->getNombre();
				break;

			case (!(is_null($this->getSliders())));
				return $this->getSliders()->getNombre();
				break;

			case (!(is_null($this->getAdjuntos())));
				return $this->getAdjuntos()->getNombre();
				break;

			case (!(is_null($this->getArticulos())));
				return $this->getArticulos()->getTitulo();
				break;
		}
	}

	public function getType()
	{

		switch($this){
			case (!(is_null($this->getVideos())));
				return $this->getVideos()->getType();
				break;
			case (!(is_null($this->getImagenes())));
				return $this->getImagenes()->getType();
				break;

			case (!(is_null($this->getAdjuntos())));
				return $this->getAdjuntos()->getType();
				break;

			case (!(is_null($this->getSliders())));
				return $this->getSliders()->getType();
				break;

			case (!(is_null($this->getArticulos())));
				return $this->getArticulos()->getType();
				break;
		}

	}

	public function getEntity()
	{
		switch($this){
			case (!(is_null($this->getVideos())));
				return $this->getVideos();
				break;
			case (!(is_null($this->getImagenes())));
				return $this->getImagenes();
				break;

			case (!(is_null($this->getAdjuntos())));
				return $this->getAdjuntos();
				break;

			case (!(is_null($this->getSliders())));
				return $this->getSliders();
				break;

			case (!(is_null($this->getArticulos())));
				return $this->getArticulos();
				break;
		}


	}

	public function getSlug()
	{
		switch($this){
			case (!(is_null($this->getVideos())));
				return $this->getVideos()->getSlug();
				break;
			case (!(is_null($this->getImagenes())));
				return $this->getImagenes()->getSlug();
				break;

			case (!(is_null($this->getAdjuntos())));
				return $this->getAdjuntos()->getSlug();
				break;

			case (!(is_null($this->getSliders())));
				return $this->getSliders()->getSlug();
				break;

			case (!(is_null($this->getArticulos())));
				return $this->getArticulos()->getSlug();
				break;
		}
	}

    /**
     * Set seccion
     *
     * @param \Destiny\AppBundle\Entity\Secciones $seccion
     * @return SeccionesContenido
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
     * Set posicion
     *
     * @param integer $posicion
     * @return SeccionesContenido
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;

        return $this;
    }

    /**
     * Get posicion
     *
     * @return integer
     */
    public function getPosicion()
    {
        return $this->posicion;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     * @return SeccionesContenido
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
     * @return SeccionesContenido
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
     * @return SeccionesContenido
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
     * Set articulos
     *
     * @param \Destiny\AppBundle\Entity\Articulos $articulos
     * @return SeccionesContenido
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
     * @return SeccionesContenido
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
     * @return SeccionesContenido
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
     * @return SeccionesContenido
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
     * @return SeccionesContenido
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

    /**
     * Set changablePostion
     *
     * @param boolean $changablePostion
     * @return SeccionesContenido
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

	public function getListado()
	{
		if (!is_null($this->getSeccion())){
			return $this->getSeccion();
		}

		if (!is_null($this->getNoticia())){
			return $this->getNoticia();
		}
	}
}
