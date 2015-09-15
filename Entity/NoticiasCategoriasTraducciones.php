<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Secciones
 *
 * @ORM\Table(name="noticias_categorias_traducciones")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\NoticiasCategoriasTraduccionesRepository")
 * @UniqueEntity("nombre")
 */
class NoticiasCategoriasTraducciones
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
	 * @ORM\Column(name="Nombre", type="string", length=255)
	 * @Assert\NotBlank(message="categoriasNoticias.name.notblank")
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 100,
	 *      minMessage = "categoriasNoticias.name.min",
	 *      maxMessage = "categoriasNoticias.name.max"
	 * )
	 */
	private $nombre;

	/**
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\NoticiasCategorias",
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
     * Set nombre
     *
     * @param string $nombre
     * @return NoticiasCategorias
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
     * Set canonica
     *
     * @param \Destiny\AppBundle\Entity\NoticiasCategorias $canonica
     * @return NoticiasCategoriasTraducciones
     */
    public function setCanonica(\Destiny\AppBundle\Entity\NoticiasCategorias $canonica)
    {
        $this->canonica = $canonica;

        return $this;
    }

    /**
     * Get canonica
     *
     * @return \Destiny\AppBundle\Entity\NoticiasCategorias 
     */
    public function getCanonica()
    {
        return $this->canonica;
    }

    /**
     * Set idioma
     *
     * @param \Destiny\AppBundle\Entity\Idiomas $idioma
     * @return NoticiasCategoriasTraducciones
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
