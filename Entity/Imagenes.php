<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Impuestos
 *
 * @ORM\Table(name="imagenes")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\ImagenesRepository")
 * @UniqueEntity("nombre")
 */
class Imagenes
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
	 * @ORM\Column(name="nombre", type="string", length=255,unique=true)
	 * @Assert\NotBlank(message="imagenes.name.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 50,
	 *      minMessage = "imagenes.name.min",
	 *      maxMessage = "imagenes.name.max"
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
	 * @ORM\Column(name="alt", type="string", length=255)
	 * @Assert\NotBlank(message="imagenes.alt.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 150,
	 *      minMessage = "imagenes.alt.min",
	 *      maxMessage = "imagenes.alt.max"
	 * )
	 *
	 */
	private $alt;

	/**
	 * @var string
	 * @ORM\Column(name="descripcion", type="string", length=255)
	 * @Assert\NotBlank(message="imagenes.descripcion.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 200,
	 *      minMessage = "imagenes.descripcion.min",
	 *      maxMessage = "imagenes.descripcion.max"
	 * )
	 */
	private $descripcion;


    /**
     * @return string
     * @Assert\File(maxSize="1M",mimeTypes = {
     *          "image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *          "image/gif"})
     *
     */
    private $archivo;

    /**
     * @ORM\Column(name="ruta", type="string")
     */
    private $ruta;

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
     * @ORM\OneToMany(targetEntity="Destiny\AppBundle\Entity\ImagenesTraducciones", mappedBy="canonica")
     **/
    private $traducciones;


    public function __toString()
    {
        return $this->getNombre();
    }

    public function getAbsolutePath()
    {
        return null === $this->ruta
            ? null
            : $this->getUploadRootDir().'/'.$this->ruta;
    }

    public function getWebPath()
    {
        return null === $this->ruta
            ? null
            : $this->getUploadDir().'/'.$this->ruta;
    }

    protected function getUploadRootDir()
    {
        // la ruta absoluta del directorio donde se deben
        // guardar los archivos cargados
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // se deshace del __DIR__ para no meter la pata
        // al mostrar el documento/imagen cargada en la vista.

        return 'asset/frontend/img';
    }

	public function getType()
	{
		return 'imagenes';
	}

    public function setArchivo(UploadedFile $archivo)
    {
        $this->archivo = $archivo;

        return $this;
    }

    public function getArchivo()
    {
        return $this->archivo;

    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getArchivo()) {
            return;
        }


        // aquí usa el nombre de archivo original pero lo debes
        // sanear al menos para evitar cualquier problema de seguridad

        // move takes the target directory and then the
        // target filename to move to
        $clean = $this->getNombre();
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

        $nombreArchivo = $clean.'.' .$this->getArchivo()->getClientOriginalExtension();


        $this->getArchivo()->move(
            $this->getUploadRootDir(),
            $nombreArchivo
        );

        // set the path property to the filename where you've saved the file
        $this->ruta = $nombreArchivo;

        // limpia la propiedad «file» ya que no la necesitas más
        $this->archivo = null;
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
     * @return Imagenes
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
     * @return Imagenes
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
     * @return Imagenes
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Imagenes
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
     * Set ruta
     *
     * @param string $ruta
     * @return Imagenes
     */
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;

        return $this;
    }

    /**
     * Get ruta
     *
     * @return string 
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Imagenes
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
     * @return Imagenes
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
     * @return Imagenes
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
     * @param \Destiny\AppBundle\Entity\ImagenesTraducciones $traducciones
     * @return Imagenes
     */
    public function addTraduccione(\Destiny\AppBundle\Entity\ImagenesTraducciones $traducciones)
    {
        $this->traducciones[] = $traducciones;

        return $this;
    }

    /**
     * Remove traducciones
     *
     * @param \Destiny\AppBundle\Entity\ImagenesTraducciones $traducciones
     */
    public function removeTraduccione(\Destiny\AppBundle\Entity\ImagenesTraducciones $traducciones)
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
