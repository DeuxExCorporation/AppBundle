<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Idiomas
 *
 * @ORM\Table(name="idiomas")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\IdiomasRepository")
 * @UniqueEntity("nombre")
 * @UniqueEntity("isoCode")
 */
class Idiomas
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
	 * @Assert\NotBlank(message="language.name.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 50,
	 *      minMessage = "language.name.min",
	 *      maxMessage = "language.name.max"
	 * )
	 *
	 * @Assert\Regex(
	 *     pattern="/\d/",
	 *     match=false,
	 *     message="language.name.notnumber"
	 * )
	 */
	private $nombre;

	/**
	 * @var string
	 * @Gedmo\Slug(fields={"isoCode"})
	 * @ORM\Column(name="slug", type="string", length=255)
	 */
	private $slug;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="isoCode", type="string", length=255)
	 * 	 * @Assert\NotBlank(message="language.isocode.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 5,
	 *      minMessage = "language.isocode.min",
	 *      maxMessage = "language.isocode.max"
	 * )
	 *
	 * @Assert\Regex(
	 *     pattern="/\d/",
	 *     match=false,
	 *     message="language.isocode.notnumber"
	 * )
	 */
	private $isoCode;

	/**
	 * @return string
	 * @Assert\File(maxSize="1M",maxSizeMessage="language.flag.maxSize")
	 * @Assert\Image(mimeTypesMessage="language.flag.notimage")
	 *
	 */
	private $archivo;

	/**
	 * @ORM\Column(name="ruta", type="string")
	 */
	private $ruta;


	/**
	 * @var string
	 *
	 * @ORM\Column(name="estado", type="boolean")
	 */
	private $estado;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="defecto", type="boolean")
	 */
	private $defecto;

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

	protected function getUploadDir()
	{
		// se deshace del __DIR__ para no meter la pata
		// al mostrar el documento/imagen cargada en la vista.
		return 'asset/common/img/lang';
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
		$nombreArchivo = $this->getIsoCode().'.' .$this->getArchivo()->getClientOriginalExtension();



		$this->getArchivo()->move(
			$this->getUploadRootDir(),
			$nombreArchivo
		);

		// set the path property to the filename where you've saved the file
		$this->ruta = $nombreArchivo;

		// limpia la propiedad «file» ya que no la necesitas más
		$this->archivo = null;
	}

	public function getType()
	{
		return 'image';
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
	 * @return Idiomas
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
	 * @return Idiomas
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
	 * Set isoCode
	 *
	 * @param string $isoCode
	 * @return Idiomas
	 */
	public function setIsoCode($isoCode)
	{
		$this->isoCode = $isoCode;

		return $this;
	}

	/**
	 * Get isoCode
	 *
	 * @return string
	 */
	public function getIsoCode()
	{
		return $this->isoCode;
	}

	/**
	 * Set altImagen
	 *
	 * @param string $altImagen
	 * @return Idiomas
	 */
	public function setAltImagen($altImagen)
	{
		$this->altImagen = $altImagen;

		return $this;
	}

	/**
	 * Get altImagen
	 *
	 * @return string
	 */
	public function getAltImagen()
	{
		return $this->altImagen;
	}

	/**
	 * Set nombreImagen
	 *
	 * @param string $nombreImagen
	 * @return Idiomas
	 */
	public function setNombreImagen($nombreImagen)
	{
		$this->nombreImagen = $nombreImagen;

		return $this;
	}

	/**
	 * Get nombreImagen
	 *
	 * @return string
	 */
	public function getNombreImagen()
	{
		return $this->nombreImagen;
	}

	/**
	 * Set tituloImagen
	 *
	 * @param string $tituloImagen
	 * @return Idiomas
	 */
	public function setTituloImagen($tituloImagen)
	{
		$this->tituloImagen = $tituloImagen;

		return $this;
	}

	/**
	 * Get tituloImagen
	 *
	 * @return string
	 */
	public function getTituloImagen()
	{
		return $this->tituloImagen;
	}

	/**
	 * Set ruta
	 *
	 * @param string $ruta
	 * @return Idiomas
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
	 * Set estado
	 *
	 * @param boolean $estado
	 * @return Idiomas
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
	 * Set defecto
	 *
	 * @param boolean $defecto
	 * @return Idiomas
	 */
	public function setDefecto($defecto)
	{
		$this->defecto = $defecto;

		return $this;
	}

	/**
	 * Get defecto
	 *
	 * @return boolean
	 */
	public function getDefecto()
	{
		return $this->defecto;
	}

	/**
	 * Set fechaCreacion
	 *
	 * @param \DateTime $fechaCreacion
	 * @return Idiomas
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
	 * @return Idiomas
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
