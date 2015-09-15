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
 * @ORM\Table(name="empresa_web_traducciones")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\EmpresaWebTraduccionesRepository")
 */
class EmpresaWebTraducciones
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
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\EmpresaWeb",
	 *     cascade={"persist"})
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
     * Set slogan
     *
     * @param string $slogan
     * @return EmpresaWebTraducciones
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
     * Set mensajeBloqueo
     *
     * @param string $mensajeBloqueo
     * @return EmpresaWebTraducciones
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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return EmpresaWebTraducciones
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
     * @return EmpresaWebTraducciones
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
     * @param \Destiny\AppBundle\Entity\EmpresaWeb $canonica
     * @return EmpresaWebTraducciones
     */
    public function setCanonica(\Destiny\AppBundle\Entity\EmpresaWeb $canonica)
    {
        $this->canonica = $canonica;

        return $this;
    }

    /**
     * Get canonica
     *
     * @return \Destiny\AppBundle\Entity\EmpresaWeb 
     */
    public function getCanonica()
    {
        return $this->canonica;
    }

    /**
     * Set idioma
     *
     * @param \Destiny\AppBundle\Entity\Idiomas $idioma
     * @return EmpresaWebTraducciones
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
}
