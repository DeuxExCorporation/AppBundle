<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Videos
 *
 * @ORM\Table(name="videos_traducciones")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\VideosTraduccionesRepository")
 * @UniqueEntity("nombre")
 */
class VideosTraducciones
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
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="videos.name.notnumber"
     * )
     */
    private $nombre;

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
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="videos.alt.notnumber"
     * )
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
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

	/**
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Videos",
	 *     cascade={"persist"},inversedBy="traducciones")
	 * @ORM\JoinColumn(name="traduccion_id", nullable=false, referencedColumnName="id", onDelete="CASCADE")
	 **/
	private $canonica;

	/**
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Idiomas",
	 *     cascade={"persist"})
	 * @ORM\JoinColumn(name="idioma_id", nullable=false, referencedColumnName="id", onDelete="CASCADE")
	 **/
	private $idioma;


	public function __toString()
	{
		return $this->getCanonica()->getNombre();
	}

	public function getSlug()
	{
		return $this->getCanonica()->getSlug();
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
     * Set canonica
     *
     * @param \Destiny\AppBundle\Entity\Videos $canonica
     * @return VideosTraducciones
     */
    public function setCanonica(\Destiny\AppBundle\Entity\Videos $canonica)
    {
        $this->canonica = $canonica;

        return $this;
    }

    /**
     * Get canonica
     *
     * @return \Destiny\AppBundle\Entity\Videos 
     */
    public function getCanonica()
    {
        return $this->canonica;
    }

    /**
     * Set idioma
     *
     * @param \Destiny\AppBundle\Entity\Idiomas $idioma
     * @return VideosTraducciones
     */
    public function setIdioma(\Destiny\AppBundle\Entity\Idiomas $idioma)
    {
        $this->idioma = $idioma;

        return $this;
    }

    /**
     * Get idioma
     *
     * @return \Destiny\AppBundle\Entity\Idiomas 
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    public function getEstado()
    {
        return $this->getCanonica()->getEstado();
    }


}
