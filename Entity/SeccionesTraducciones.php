<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * SeccionesTraducciones
 *
 * @ORM\Table(name="secciones_traducciones")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\SeccionesTraduccionesRepository")
 */
class SeccionesTraducciones
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
     * @ORM\Column(name="etiquetaMenu", type="string", length=255)

     * @Assert\NotBlank(message="secciones.etiquetaMenu.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "secciones.etiquetaMenu.min",
     *      maxMessage = "secciones.etiquetaMenu.max"
     * )
     */
    private $etiquetaMenu;

    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;


    /**
     * @var string
     *
     * @ORM\Column(name="tituloWeb", type="string", length=255)
     * @Assert\NotBlank(message="secciones.tituloWeb.notblank")
     * @Assert\Length(
     *      min = 10,
     *      max = 150,
     *      minMessage = "secciones.tituloWeb.min",
     *      maxMessage = "secciones.tituloWeb.max"
     * )
     */
    private $tituloWeb;

    /**
     * @var string
     * @ORM\Column(name="tituloSeccion", type="string", length=255)
     * @Assert\NotBlank(message="secciones.tituloSeccion.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 150,
     *      minMessage = "secciones.tituloSeccion.min",
     *      maxMessage = "secciones.tituloSeccion.max"
     * )
     */
    private $tituloSeccion;

    /**
     * @var string
     * @ORM\Column(name="tituloSeo", type="string", length=255)
     * @Assert\NotBlank(message="secciones.tituloSeo.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 150,
     *      minMessage = "secciones.tituloSeo.min",
     *      maxMessage = "secciones.tituloSeo.max"
     * )
     */
    private $tituloSeo;

    /**
     * @var string
     * @ORM\Column(name="descripcionSeo", type="string", length=255)
     * @Assert\NotBlank(message="secciones.descripcionSeo.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 175,
     *      minMessage = "secciones.descripcionSeo.min",
     *      maxMessage = "secciones.descripcionSeo.max"
     * )
     */
    private $descripcionSeo;

	/**
	 * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\Secciones",
	 *     cascade={"persist"}, inversedBy="traducciones")
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
     * Set etiquetaMenu
     *
     * @param string $etiquetaMenu
     * @return SeccionesTraducciones
     */
    public function setEtiquetaMenu($etiquetaMenu)
    {
        $this->etiquetaMenu = $etiquetaMenu;

        return $this;
    }

    /**
     * Get etiquetaMenu
     *
     * @return string 
     */
    public function getEtiquetaMenu()
    {
        return $this->etiquetaMenu;
    }

    /**
     * Set tituloWeb
     *
     * @param string $tituloWeb
     * @return SeccionesTraducciones
     */
    public function setTituloWeb($tituloWeb)
    {
        $this->tituloWeb = $tituloWeb;

        return $this;
    }

    /**
     * Get tituloWeb
     *
     * @return string 
     */
    public function getTituloWeb()
    {
        return $this->tituloWeb;
    }

    /**
     * Set tituloSeccion
     *
     * @param string $tituloSeccion
     * @return SeccionesTraducciones
     */
    public function setTituloSeccion($tituloSeccion)
    {
        $this->tituloSeccion = $tituloSeccion;

        return $this;
    }

    /**
     * Get tituloSeccion
     *
     * @return string 
     */
    public function getTituloSeccion()
    {
        return $this->tituloSeccion;
    }

    /**
     * Set tituloSeo
     *
     * @param string $tituloSeo
     * @return SeccionesTraducciones
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
     * @return SeccionesTraducciones
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
     * @param \Destiny\AppBundle\Entity\Secciones $canonica
     * @return SeccionesTraducciones
     */
    public function setCanonica(\Destiny\AppBundle\Entity\Secciones $canonica)
    {
        $this->canonica = $canonica;

        return $this;
    }

    /**
     * Get canonica
     *
     * @return \Destiny\AppBundle\Entity\Secciones 
     */
    public function getCanonica()
    {
        return $this->canonica;
    }

    /**
     * Set idioma
     *
     * @param \Destiny\AppBundle\Entity\Idiomas $idioma
     * @return SeccionesTraducciones
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
     * Set url
     *
     * @param string $url
     * @return Secciones
     */
    public function setUrl($url)
    {
        $this->url = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $url));

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {

        return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->url));
    }

    public function getTipo()
    {
        return $this->getCanonica()->getTipo();
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

    public function getFechaModificacion()
    {
        return $this->getCanonica()->getFechaModificacion();
    }

    public function getPortada()
    {
        return $this->getCanonica()->getPortada();
    }


}
