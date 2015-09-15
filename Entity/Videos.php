<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Videos
 *
 * @ORM\Table(name="videos")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\VideosRepository")
 * @UniqueEntity("nombre")
 */
class Videos
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
     * @Assert\NotBlank(message="videos.name.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "videos.name.min",
     *      maxMessage = "videos.name.max"
     * )
     *
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
     * @ORM\Column(name="alt", type="string", length=255)
     * @Assert\NotBlank(message="videos.alt.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 150,
     *      minMessage = "videos.alt.min",
     *      maxMessage = "videos.alt.max"
     * )
     *
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     * @Assert\NotBlank(message="videos.descripcion.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 200,
     *      minMessage = "videos.descripcion.min",
     *      maxMessage = "videos.descripcion.max"
     * )
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;



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
     * @ORM\OneToMany(targetEntity="Destiny\AppBundle\Entity\VideosTraducciones", mappedBy="canonica")
     **/
    private $traducciones;

    /**
     *
     */
    public function __toString()
    {
        return $this->getNombre();
    }

	public function getType()
	{
		return 'videos';
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Videos
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
     * Set url
     *
     * @param string $url
     * @return Videos
     */
    public function setUrl($url)
    {
       if (strpos($url,'=')){
           $url = explode('=',$url);
           $this->url = $url[1];
       }else{
           $this->url = $url;
       }



        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Videos
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
     * @return Videos
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
     * Set alt
     *
     * @param string $alt
     * @return Videos
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Videos
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
     * @return Videos
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
     * @return Videos
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
     * @param \Destiny\AppBundle\Entity\VideosTraducciones $traducciones
     * @return Videos
     */
    public function addTraduccione(\Destiny\AppBundle\Entity\VideosTraducciones $traducciones)
    {
        $this->traducciones[] = $traducciones;

        return $this;
    }

    /**
     * Remove traducciones
     *
     * @param \Destiny\AppBundle\Entity\VideosTraducciones $traducciones
     */
    public function removeTraduccione(\Destiny\AppBundle\Entity\VideosTraducciones $traducciones)
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
