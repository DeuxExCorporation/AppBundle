<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * AdjuntosTraducciones
 *
 * @ORM\Table(name="adjuntos_traducciones")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\AdjuntosTraduccionesRepository")
 */
class AdjuntosTraducciones
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
	 * @Assert\NotBlank(message="adjunto.name.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 50,
	 *      minMessage = "adjunto.name.min",
	 *      maxMessage = "adjunto.name.max"
	 * )
	 *
	 * @Assert\Regex(
	 *     pattern="/\d/",
	 *     match=false,
	 *     message="adjunto.name.notnumber"
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
     * @ORM\Column(name="alt", type="string", length=255)
     * @Assert\NotBlank(message="adjunto.alt.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 150,
     *      minMessage = "adjunto.alt.min",
     *      maxMessage = "adjunto.alt.max"
     * )
     *
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="adjunto.alt.notnumber"
     * )
     */
    private $alt;

    /**
     * @var string
     * @ORM\Column(name="descripcion", type="string", length=255)
     * @Assert\NotBlank(message="adjunto.descripcion.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 200,
     *      minMessage = "adjunto.descripcion.min",
     *      maxMessage = "adjunto.descripcion.max"
     * )
     */
    private $descripcion;


    /**
     * @return string
     * @Assert\File(maxSize="12M",mimeTypes = {
     *          "application/pdf",
     *          "application/x-pdf"
     * })
     *
     */
    private $archivo;

    /**
     * @ORM\Column(name="ruta", type="string", nullable=true)
     */
    private $ruta;


	/**
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Adjuntos",
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



        return 'asset/frontend/pdf';
    }

	public function getType()
	{
		return 'adjuntos';
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
        $clean = $this->getCanonica()->getNombre();
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

        $nombreArchivo = $clean.'-'.$this->getIdioma().'.' .$this->getArchivo()->getClientOriginalExtension();


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
     * @return Adjuntos
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
     * @return Adjuntos
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
     * @return Adjuntos
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
     * @return Adjuntos
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
     * @return Adjuntos
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
     * @return Adjuntos
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
     * @return Adjuntos
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
        return $this->getCanonica()->getEstado();
    }

    /**
     * Set canonica
     *
     * @param \Destiny\AppBundle\Entity\Adjuntos $canonica
     * @return AdjuntosTraducciones
     */
    public function setCanonica(\Destiny\AppBundle\Entity\Adjuntos $canonica)
    {
        $this->canonica = $canonica;

        return $this;
    }

    /**
     * Get canonica
     *
     * @return \Destiny\AppBundle\Entity\Adjuntos 
     */
    public function getCanonica()
    {
        return $this->canonica;
    }

    /**
     * Set idioma
     *
     * @param \Destiny\AppBundle\Entity\Idiomas $idioma
     * @return AdjuntosTraducciones
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

    /**
     * Set slug
     *
     * @param string $slug
     * @return AdjuntosTraducciones
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}
