<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sliders
 *
 * @ORM\Table(name="sliders_traducciones")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\SlidersTraduccionesRepository")
 * @UniqueEntity("nombre")
 */
class SlidersTraducciones
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
     * @Assert\NotBlank(message="sliders.alt.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 150,
     *      minMessage = "sliders.alt.min",
     *      maxMessage = "sliders.alt.max"
     * )
     */
    private $nombre;


    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     * @Assert\NotBlank(message="sliders.descripcion.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 200,
     *      minMessage = "sliders.descripcion.min",
     *      maxMessage = "sliders.descripcion.max"
     * )
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Sliders",
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


	public function getType()
	{
		return 'slider';
	}
    public function getEstado()
    {
        return $this->getCanonica()->getEstado();
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
     * @return SlidersTraducciones
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return SlidersTraducciones
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
     * @param \Destiny\AppBundle\Entity\Sliders $canonica
     * @return SlidersTraducciones
     */
    public function setCanonica(\Destiny\AppBundle\Entity\Sliders $canonica)
    {
        $this->canonica = $canonica;

        return $this;
    }

    /**
     * Get canonica
     *
     * @return \Destiny\AppBundle\Entity\Sliders 
     */
    public function getCanonica()
    {
        return $this->canonica;
    }

    /**
     * Set idioma
     *
     * @param \Destiny\AppBundle\Entity\Idiomas $idioma
     * @return SlidersTraducciones
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

    public function getGroup()
    {
        return $this->getCanonica()->getGroup();
    }
}
