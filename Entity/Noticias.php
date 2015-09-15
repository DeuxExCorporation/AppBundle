<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Noticias
 *
 * @ORM\Table(name="noticias")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\NoticiasRepository")
 * @UniqueEntity("titulo")
 */
class Noticias
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
     *
     * @Assert\NotBlank(message="noticias.tituloWeb.notblank")
     * @Assert\Length(
     *      min = 10,
     *      max = 150,
     *      minMessage = "noticias.titulo.min",
     *      maxMessage = "noticias.titulo.max"
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
     * @ORM\Column(name="tituloSeo", type="string", length=255)
     * @Assert\NotBlank(message="noticias.tituloSeo.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 150,
     *      minMessage = "noticias.tituloSeo.min",
     *      maxMessage = "noticias.tituloSeo.max"
     * )
     */
    private $tituloSeo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcionSeo", type="string", length=255)
     * @Assert\NotBlank(message="noticias.descripcionSeo.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 175,
     *      minMessage = "noticias.descripcionSeo.min",
     *      maxMessage = "noticias.descripcionSeo.max"
     * )
     */
    private $descripcionSeo;

	/**
	 * @var string
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


	/**
	 * @ORM\OneToMany(targetEntity="Destiny\AppBundle\Entity\NoticiasContenido", mappedBy="seccion")
	 **/
	private $contenidos;

	/**
	 * @ORM\ManyToMany(targetEntity="Destiny\AppBundle\Entity\NoticiasCategorias")
	 * @ORM\JoinTable(name="noticias_listado_categorias",
	 *      joinColumns={@ORM\JoinColumn(name="noticias_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="categorias_id", referencedColumnName="id")}
	 *      )
	 **/
	private $categorias;

	/**
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\SeccionesTipo",
	 *     cascade={"persist"})
	 * @ORM\JoinColumn(name="tipo_id", nullable=false, referencedColumnName="id", onDelete="CASCADE")
	 **/
	private $tipo;


    /**
     * @ORM\OneToMany(targetEntity="Destiny\AppBundle\Entity\NoticiasTraducciones", mappedBy="canonica")
     **/
    private $traducciones;

	public function __construct() {
		$this->contenidos = new ArrayCollection();

	}

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


    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Noticias
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
     * @return Noticias
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
     * @return Noticias
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
     * @return Noticias
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
     * @return Noticias
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
     * @return Noticias
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
     * @return Noticias
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
     * Set estado
     *
     * @param boolean $estado
     * @return Noticias
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
     * @return Noticias
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
     * @return Noticias
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
     * Add contenidos
     *
     * @param \Destiny\AppBundle\Entity\NoticiasContenido $contenidos
     * @return Noticias
     */
    public function addContenido(\Destiny\AppBundle\Entity\NoticiasContenido $contenidos)
    {
        $this->contenidos[] = $contenidos;

        return $this;
    }

    /**
     * Remove contenidos
     *
     * @param \Destiny\AppBundle\Entity\NoticiasContenido $contenidos
     */
    public function removeContenido(\Destiny\AppBundle\Entity\NoticiasContenido $contenidos)
    {
        $this->contenidos->removeElement($contenidos);
    }

    /**
     * Get contenidos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContenidos()
    {
        return $this->contenidos;
    }

    /**
     * Add categorias
     *
     * @param \Destiny\AppBundle\Entity\NoticiasCategorias $categorias
     * @return Noticias
     */
    public function addCategoria(\Destiny\AppBundle\Entity\NoticiasCategorias $categorias)
    {
        $this->categorias[] = $categorias;

        return $this;
    }

    /**
     * Remove categorias
     *
     * @param \Destiny\AppBundle\Entity\NoticiasCategorias $categorias
     */
    public function removeCategoria(\Destiny\AppBundle\Entity\NoticiasCategorias $categorias)
    {
        $this->categorias->removeElement($categorias);
    }

    /**
     * Get categorias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategorias()
    {
        return $this->categorias;
    }

    /**
     * Set tipo
     *
     * @param \Destiny\AppBundle\Entity\SeccionesTipo $tipo
     * @return Noticias
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
     * Set titulo
     *
     * @param string $titulo
     * @return Noticias
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
     * Add traducciones
     *
     * @param \Destiny\AppBundle\Entity\NoticiasTraducciones $traducciones
     * @return Noticias
     */
    public function addTraduccione(\Destiny\AppBundle\Entity\NoticiasTraducciones $traducciones)
    {
        $this->traducciones[] = $traducciones;

        return $this;
    }

    /**
     * Remove traducciones
     *
     * @param \Destiny\AppBundle\Entity\NoticiasTraducciones $traducciones
     */
    public function removeTraduccione(\Destiny\AppBundle\Entity\NoticiasTraducciones $traducciones)
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
