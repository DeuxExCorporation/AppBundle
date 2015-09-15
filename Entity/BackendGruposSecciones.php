<?php

namespace Destiny\AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * BackendGruposSecciones
 *
 * @ORM\Table(name="backend_grupos_secciones")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\BackendGruposSeccionesRepository")
 * @UniqueEntity("nombre")
 */
class BackendGruposSecciones
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
     * @ORM\Column(name="etiqueta", type="string", length=255)
     */
    private $etiqueta;

    /**
     * @var string
     *
     * @ORM\Column(name="limite", type="integer")
     */
    private $limite = 0;
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

    /**
     * @ORM\OneToMany(targetEntity="Destiny\AppBundle\Entity\BackendSecciones", mappedBy="grupo")
     **/
    private $secciones;

	public function __toString()
	{
		return $this->getNombre();
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
     * @return GruposMenusBackend
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
     * Set etiqueta
     *
     * @param string $etiqueta
     * @return GruposMenusBackend
     */
    public function setEtiqueta($etiqueta)
    {
        $this->etiqueta = $etiqueta;

        return $this;
    }

    /**
     * Get etiqueta
     *
     * @return string 
     */
    public function getEtiqueta()
    {
        return $this->etiqueta;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     * @return GruposMenusBackend
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
     * @return GruposMenusBackend
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
     * @return GruposMenusBackend
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
     * Constructor
     */
    public function __construct()
    {
        $this->secciones = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get secciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSecciones()
    {
        return $this->secciones;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return GruposMenusBackend
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
     * Set limite
     *
     * @param integer $limite
     * @return GruposMenusBackend
     */
    public function setLimite($limite)
    {
        $this->limite = $limite;

        return $this;
    }

    /**
     * Get limite
     *
     * @return integer
     */
    public function getLimite()
    {
        return $this->limite;
    }

    /**
     * Add secciones
     *
     * @param \Destiny\AppBundle\Entity\BackendSecciones $secciones
     * @return BackendGruposSecciones
     */
    public function addSeccione(\Destiny\AppBundle\Entity\BackendSecciones $secciones)
    {
        $this->secciones[] = $secciones;

        return $this;
    }

    /**
     * Remove secciones
     *
     * @param \Destiny\AppBundle\Entity\BackendSecciones $secciones
     */
    public function removeSeccione(\Destiny\AppBundle\Entity\BackendSecciones $secciones)
    {
        $this->secciones->removeElement($secciones);
    }
}
