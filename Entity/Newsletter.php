<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Newsletter
 *
 * @ORM\Table(name="newsletter")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\NewsletterRepository")
 * @UniqueEntity("email")
 */
class Newsletter
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
	 * @Assert\NotBlank(message="newsletter.email.notblank")
	 * @Assert\Email(message="newsletter.email.email")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 100,
	 *      minMessage = "newsletter.email.min",
	 *      maxMessage = "newsletter.email.max"
	 * )
	 *
	 */
	private $email;

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
     * Get email
     *
     * @return string
     */
	public function getEmail ()
    {
	    return $this->email;
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
     * Get id
     *
     * @return integer
     */
	public function getId ()
    {
	    return $this->id;
    }

    /**
     * Get slug
     *
     * @return string
     */
	public function getSlug ()
	{
		return $this->slug;
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
     * Get estado
     *
     * @return boolean
     */
	public function getEstado ()
    {
	    return $this->estado;
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
     * Get fechaCreacion
     *
     * @return \DateTime
     */
	public function getFechaCreacion ()
    {
	    return $this->fechaCreacion;
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
     * Get fechaModificacion
     *
     * @return \DateTime
     */
	public function getFechaModificacion ()
    {
	    return $this->fechaModificacion;
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
}
