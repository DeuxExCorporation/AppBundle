<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mensajes
 *
 * @ORM\Table(name="Mensajes")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\MensajesRepository")
 *
 */
class Mensajes
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
	 * @ORM\Column(name="email", type="string", length=255)
	 * @Assert\NotBlank(message="message.notblank")
	 * @Assert\Email(message="message.email")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 100,
	 *      minMessage = "message.email.min",
	 *      maxMessage = "message.email.max"
	 * )
	 *
	 */
	private $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="asunto", type="string", length=255)
	 * @Assert\NotBlank(message="message.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 100,
	 *      minMessage = "message.subject.min",
	 *      maxMessage = "message.subject.max"
	 * )
	 */
	private $asunto;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="cuerpo", type="string", length=255)
	 * @Assert\NotBlank(message="message.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      minMessage = "message.body.min",
	 * )
	 */
	private $cuerpo;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="telefono", type="string", length=255, nullable= true)
	 * @Assert\Length(
	 *      min = 9,
	 *      minMessage = "message.telephone.min",
	 * )
	 * @Assert\Regex(
	 *     pattern="/[0-9]/",
	 *     match=true,
	 *     message="messages.telephone.number"
	 * )
	 */
	private $telefono;

	/**
	 * @var string
	 * @Gedmo\Slug(fields={"email"})
	 * @ORM\Column(name="slug", type="string", length=255)
	 */
	private $slug;

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

	public function __toString()
	{
		return $this->getEmail();
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
     * Set email
     *
     * @param string $email
     * @return Newsletter
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
     * Set slug
     *
     * @param string $slug
     * @return Newsletter
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
     * Set estado
     *
     * @param boolean $estado
     * @return Newsletter
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
     * @return Newsletter
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
     * @return Newsletter
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
     * Set asunto
     *
     * @param string $asunto
     * @return Mensajes
     */
    public function setAsunto($asunto)
    {
        $this->asunto = $asunto;

        return $this;
    }

    /**
     * Get asunto
     *
     * @return string 
     */
    public function getAsunto()
    {
        return $this->asunto;
    }

    /**
     * Set cuerpo
     *
     * @param string $cuerpo
     * @return Mensajes
     */
    public function setCuerpo($cuerpo)
    {
        $this->cuerpo = $cuerpo;

        return $this;
    }

    /**
     * Get cuerpo
     *
     * @return string 
     */
    public function getCuerpo()
    {
        return $this->cuerpo;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Mensajes
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

}
