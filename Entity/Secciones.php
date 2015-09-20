<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Secciones
 *
 * @ORM\Table(name="secciones")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\SeccionesRepository")
 * @UniqueEntity("nombre")

 */
class Secciones
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

     * @ORM\Column(name="nombre", type="string", length=255)
     * @Assert\NotBlank(message="secciones.name.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "secciones.name.min",
     *      maxMessage = "secciones.name.max"
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
     * @var string
     *
     * @ORM\Column(name="etiquetaMenu", type="string", length=255)

     * @Assert\NotBlank(message="secciones.etiquetaMenu.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "secciones.etiquetaMenu.min",
     *      maxMessage = "secciones.etiquetaMenu.max"
     * )
     */
    private $etiquetaMenu;

    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255,nullable=true)

     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="tituloWeb", type="string", length=255)
     * @Assert\NotBlank(message="secciones.tituloWeb.notblank")
     * @Assert\Length(
     *      min = 10,
     *      max = 150,
     *      minMessage = "secciones.tituloWeb.min",
     *      maxMessage = "secciones.tituloWeb.max"
     * )
     */
    private $tituloWeb;

    /**
     * @var string
     * @ORM\Column(name="tituloSeccion", type="string", length=255)
     * @Assert\NotBlank(message="secciones.tituloSeccion.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 150,
     *      minMessage = "secciones.tituloSeccion.min",
     *      maxMessage = "secciones.tituloSeccion.max"
     * )
     */
    private $tituloSeccion;

    /**
     * @var string
     * @ORM\Column(name="tituloSeo", type="string", length=255)
     * @Assert\NotBlank(message="secciones.tituloSeo.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 150,
     *      minMessage = "secciones.tituloSeo.min",
     *      maxMessage = "secciones.tituloSeo.max"
     * )
     */
    private $tituloSeo;

    /**
     * @var string
     * @ORM\Column(name="descripcionSeo", type="string", length=255)
     * @Assert\NotBlank(message="secciones.descripcionSeo.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 175,
     *      minMessage = "secciones.descripcionSeo.min",
     *      maxMessage = "secciones.descripcionSeo.max"
     * )
     */
    private $descripcionSeo;

    /**
     * @var integer
     *
     * @ORM\Column(name="posicion", type="integer")
     */
    private $posicion;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="estado", type="boolean")
	 */
	private $estado;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="portada", type="boolean")
	 */
	private $portada = false;

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
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Menus",
	 *     cascade={"persist"},inversedBy="secciones")
	 * @ORM\JoinColumn(name="menu_id", nullable=false, referencedColumnName="id", onDelete="CASCADE")
	 **/
	private $menu;

	/**
	 * @ORM\OneToMany(targetEntity="Destiny\AppBundle\Entity\SeccionesContenido", mappedBy="seccion")
	 **/
	private $contenidos;

	/**
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\SeccionesTipo",
	 *     cascade={"persist"})
	 * @ORM\JoinColumn(name="tipo_id", nullable=false, referencedColumnName="id", onDelete="CASCADE")
	 **/
	private $tipo;

	/**
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Secciones",
	 *     cascade={"persist"},inversedBy="subSecciones")
	 * @ORM\JoinColumn(name="padre_id", nullable=true, referencedColumnName="id", onDelete="CASCADE", )
	 **/
	private $padre;

	/**
	 * @ORM\OneToMany(targetEntity="Destiny\AppBundle\Entity\Secciones", mappedBy="padre")
	 **/
	private $subSecciones;

	/**
	 * @ORM\OneToMany(targetEntity="Destiny\AppBundle\Entity\SeccionesTraducciones", mappedBy="canonica")
	 **/
	private $traducciones;

	public function __construct() {
		$this->contenidos = new ArrayCollection();
		$this->changablePostion = true;
	}

	public function __toString()
	{
		return $this->getNombre();
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
     * @return Secciones
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
     * @return Secciones
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
     * Set etiquetaMenu
     *
     * @param string $etiquetaMenu
     * @return Secciones
     */
    public function setEtiquetaMenu($etiquetaMenu)
    {
        $this->etiquetaMenu = $etiquetaMenu;

        return $this;
    }

    /**
     * Get etiquetaMenu
     *
     * @return string 
     */
    public function getEtiquetaMenu()
    {
        return $this->etiquetaMenu;
    }

    /**
     * Set tituloWeb
     *
     * @param string $tituloWeb
     * @return Secciones
     */
    public function setTituloWeb($tituloWeb)
    {
        $this->tituloWeb = $tituloWeb;

        return $this;
    }

    /**
     * Get tituloWeb
     *
     * @return string 
     */
    public function getTituloWeb()
    {
        return $this->tituloWeb;
    }

    /**
     * Set tituloSeccion
     *
     * @param string $tituloSeccion
     * @return Secciones
     */
    public function setTituloSeccion($tituloSeccion)
    {
        $this->tituloSeccion = $tituloSeccion;

        return $this;
    }

    /**
     * Get tituloSeccion
     *
     * @return string 
     */
    public function getTituloSeccion()
    {
        return $this->tituloSeccion;
    }

    /**
     * Set tituloSeo
     *
     * @param string $tituloSeo
     * @return Secciones
     */
    public function setTituloSeo($tituloSeo)
    {
        $this->tituloSeo = $tituloSeo;

        return $this;
    }

    /**
     * Get tituloSeo
     *
     * @return string 
     */
    public function getTituloSeo()
    {
        return $this->tituloSeo;
    }

    /**
     * Set descripcionSeo
     *
     * @param string $descripcionSeo
     * @return Secciones
     */
    public function setDescripcionSeo($descripcionSeo)
    {
        $this->descripcionSeo = $descripcionSeo;

        return $this;
    }

    /**
     * Get descripcionSeo
     *
     * @return string 
     */
    public function getDescripcionSeo()
    {
        return $this->descripcionSeo;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     * @return Secciones
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
     * @return Secciones
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
     * @return Secciones
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
     * @return Secciones
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
     * Set menu
     *
     * @param \Destiny\AppBundle\Entity\Menus $menu
     * @return Secciones
     */
    public function setMenu(\Destiny\AppBundle\Entity\Menus $menu)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \Destiny\AppBundle\Entity\Menus 
     */
    public function getMenu()
    {
        return $this->menu;
    }

	/**
	 * Get secciones
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getContenidos()
	{
		return $this->contenidos;
	}

    /**
     * Add contenidos
     *
     * @param \Destiny\AppBundle\Entity\SeccionesContenido $contenidos
     * @return Secciones
     */
    public function addContenido(\Destiny\AppBundle\Entity\SeccionesContenido $contenidos)
    {
        $this->contenidos[] = $contenidos;

        return $this;
    }

    /**
     * Remove contenidos
     *
     * @param \Destiny\AppBundle\Entity\SeccionesContenido $contenidos
     */
    public function removeContenido(\Destiny\AppBundle\Entity\SeccionesContenido $contenidos)
    {
        $this->contenidos->removeElement($contenidos);
    }

    /**
     * Set seccion
     *
     * @param \Destiny\AppBundle\Entity\SeccionesTipo $seccion
     * @return Secciones
     */
    public function setSeccion(\Destiny\AppBundle\Entity\SeccionesTipo $seccion)
    {
        $this->seccion = $seccion;

        return $this;
    }

    /**
     * Get seccion
     *
     * @return \Destiny\AppBundle\Entity\SeccionesTipo 
     */
    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * Set tipo
     *
     * @param \Destiny\AppBundle\Entity\SeccionesTipo $tipo
     * @return Secciones
     */
    public function setTipo(\Destiny\AppBundle\Entity\SeccionesTipo $tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \Destiny\AppBundle\Entity\SeccionesTipo 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set changablePostion
     *
     * @param boolean $changablePostion
     * @return Secciones
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
     * Set padre
     *
     * @param \Destiny\AppBundle\Entity\Secciones $padre
     * @return Secciones
     */
    public function setPadre(\Destiny\AppBundle\Entity\Secciones $padre = null)
    {
        $this->padre = $padre;

        return $this;
    }

    /**
     * Get padre
     *
     * @return \Destiny\AppBundle\Entity\Secciones 
     */
    public function getPadre()
    {
        return $this->padre;
    }

    /**
     * Add subSecciones
     *
     * @param \Destiny\AppBundle\Entity\Secciones $subSecciones
     * @return Secciones
     */
    public function addSubSeccione(\Destiny\AppBundle\Entity\Secciones $subSecciones)
    {
        $this->subSecciones[] = $subSecciones;

        return $this;
    }

    /**
     * Remove subSecciones
     *
     * @param \Destiny\AppBundle\Entity\Secciones $subSecciones
     */
    public function removeSubSeccione(\Destiny\AppBundle\Entity\Secciones $subSecciones)
    {
        $this->subSecciones->removeElement($subSecciones);
    }

    /**
     * Get subSecciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubSecciones()
    {
        return $this->subSecciones;
    }

    /**
     * Set portada
     *
     * @param boolean $portada
     * @return Secciones
     */
    public function setPortada($portada)
    {
        $this->portada = $portada;

        return $this;
    }

    /**
     * Get portada
     *
     * @return boolean 
     */
    public function getPortada()
    {
        return $this->portada;
    }

	public function setTranslatableLocale($locale)
	{
		$this->locale = $locale;
	}

    /**
     * Add traducciones
     *
     * @param \Destiny\AppBundle\Entity\SeccionesTraducciones $traducciones
     * @return Secciones
     */
    public function addTraduccione(\Destiny\AppBundle\Entity\SeccionesTraducciones $traducciones)
    {
        $this->traducciones[] = $traducciones;

        return $this;
    }

    /**
     * Remove traducciones
     *
     * @param \Destiny\AppBundle\Entity\SeccionesTraducciones $traducciones
     */
    public function removeTraduccione(\Destiny\AppBundle\Entity\SeccionesTraducciones $traducciones)
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
     * Set url
     *
     * @param string $url
     * @return Secciones
     */
    public function setUrl($url)
    {
        $this->url = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $url));

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->url));
    }
}
