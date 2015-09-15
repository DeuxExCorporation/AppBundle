<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ArticulosTraducciones
 *
 * @ORM\Table(name="articulos_traducciones")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\ArticulosTraduccionesRepository")
 */
class ArticulosTraducciones
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
	 * @Assert\NotBlank(message="articulo.titulo.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 150,
	 *      minMessage = "articulo.titulo.min",
	 *      maxMessage = "articulo.titulo.max"
	 * )
	 */
	private $titulo;


	/**
	 * @var string
	 *
	 * @ORM\Column(name="descripcion", type="text")
	 * @Assert\NotBlank(message="articulo.descripcion.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      minMessage = "articulo.descripcion.min",
	 * )
	 */
    private $descripcion;

	/**
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Articulos",
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
		return $this->getCanonica()->getTitulo();
	}

	public function getSlug()
	{
		return $this->getCanonica()->getSlug();
	}

	public function getSeccion()
	{
		return $this->getCanonica();
	}

	public function getType()
	{
		return $this->getCanonica()->getType();
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
     * @return ArticulosTraducciones
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return ArticulosTraducciones
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
     * Set canonica
     *
     * @param \Destiny\AppBundle\Entity\Articulos $canonica
     * @return ArticulosTraducciones
     */
    public function setCanonica(\Destiny\AppBundle\Entity\Articulos $canonica)
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
     * @return ArticulosTraducciones
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

	public function getListado()
	{
		return $this->getCanonica()->getListado ();
	}

    public function getEstado()
    {
        return $this->getCanonica()->getEstado();
    }

    public function getFechaModificacion()
    {
        return $this->getCanonica()->getFechaModificacion();
    }
}
