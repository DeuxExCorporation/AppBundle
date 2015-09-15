<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EmpresaWeb
 *
 * @ORM\Table(name="empresa_web")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\EmpresaWebRepository")
 * @UniqueEntity("nombre")
 */
class EmpresaWeb
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
     * @Assert\NotBlank(message="empresa.name.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "empresa.name.min",
     *      maxMessage = "empresa.name.max"
     * )
     *
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
	 * @ORM\Column(name="email", type="string", length=255)
	 * @Assert\NotBlank(message="empresa.email.notblank")
	 * @Assert\Email(message="empresa.email.email")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 100,
	 *      minMessage = "empresa.email.min",
	 *      maxMessage = "empresa.email.max"
	 * )
	 *
	 */
    private $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="slogan", type="string", length=255)
	 * @Assert\NotBlank(message="empresa.slogan.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 150,
	 *      minMessage = "empresa.slogan.min",
	 * )
	 *
	 */
	private $slogan;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="mensajeBloqueo", type="text")
     * @Assert\NotBlank(message="empresa.mensajeBloqueo.notblank")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "empresa.mensajeBloqueo.min",
     * )
     *
     */
    private $mensajeBloqueo;

	/**
	 * @return string
	 * @Assert\File(maxSize="5M",maxSizeMessage="empresa.logo.maxSize")
	 * @Assert\Image(mimeTypesMessage="empresa.logo.notimage")
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

	public function getType()
	{
		return 'image';
	}

	protected function getUploadDir()
	{
		// se deshace del __DIR__ para no meter la pata
		// al mostrar el documento/imagen cargada en la vista.
		return 'asset/common/img/logo';
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
		$nombreArchivo = $this->getNombre().'.' .$this->getArchivo()->getClientOriginalExtension();



		$this->getArchivo()->move(
			$this->getUploadRootDir(),
			$nombreArchivo
		);

		// set the path property to the filename where you've saved the file
		$this->ruta = $nombreArchivo;

		// limpia la propiedad «file» ya que no la necesitas más
		$this->archivo = null;
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
     * @return EmpresaWeb
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
     * @return EmpresaWeb
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
     * Set email
     *
     * @param string $email
     * @return EmpresaWeb
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     * @return EmpresaWeb
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
     * Set mensajeBloqueo
     *
     * @param string $mensajeBloqueo
     * @return EmpresaWeb
     */
    public function setMensajeBloqueo($mensajeBloqueo)
    {
        $this->mensajeBloqueo = $mensajeBloqueo;

        return $this;
    }

    /**
     * Get mensajeBloqueo
     *
     * @return string 
     */
    public function getMensajeBloqueo()
    {
        return $this->mensajeBloqueo;
    }

    /**
     * Set slogan
     *
     * @param string $slogan
     * @return EmpresaWeb
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;

        return $this;
    }

    /**
     * Get slogan
     *
     * @return string 
     */
    public function getSlogan()
    {
        return $this->slogan;
    }

    /**
     * Set ruta
     *
     * @param string $ruta
     * @return EmpresaWeb
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
     * @return EmpresaWeb
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
     * @return EmpresaWeb
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
}
