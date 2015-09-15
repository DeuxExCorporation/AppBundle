<?php

namespace Destiny\AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * NoticiasTraducciones
 *
 * @ORM\Table(name="noticias_traducciones")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\NoticiasTraduccionesRepository")
 * @UniqueEntity("titulo")
 */
class NoticiasTraducciones
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
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Noticias",
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

    private $contenidos;

	public function __toString()
	{
		return $this->getCanonica()->getTitulo();
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
     * Set titulo
     *
     * @param string $titulo
     * @return NoticiasTraducciones
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
     * Set tituloSeo
     *
     * @param string $tituloSeo
     * @return NoticiasTraducciones
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
     * @return NoticiasTraducciones
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
     * Set canonica
     *
     * @param \Destiny\AppBundle\Entity\Noticias $canonica
     * @return NoticiasTraducciones
     */
    public function setCanonica(\Destiny\AppBundle\Entity\Noticias $canonica)
    {
        $this->canonica = $canonica;

        return $this;
    }

    /**
     * Get canonica
     *
     * @return \Destiny\AppBundle\Entity\Noticias 
     */
    public function getCanonica()
    {
        return $this->canonica;
    }

    /**
     * Set idioma
     *
     * @param \Destiny\AppBundle\Entity\Idiomas $idioma
     * @return NoticiasTraducciones
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

    public function getContenidos()
    {
        return $this->contenidos;
    }

    public function setContenidos($contenidos)
    {
        $this->contenidos = $contenidos;
        return $this;
    }
}
