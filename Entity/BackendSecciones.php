<?php

namespace Destiny\AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * BackendSecciones
 *
 * @ORM\Table(name="backend_secciones")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\BackendSeccionesRepository")
 * @UniqueEntity("nombre")
 */
class BackendSecciones
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
     * @ORM\ManyToOne(targetEntity="Destiny\AppBundle\Entity\BackendGruposSecciones",
     *     cascade={"persist"},inversedBy="secciones")
     * @ORM\JoinColumn(name="grupo_id", nullable=false, referencedColumnName="id", onDelete="CASCADE")
     */
    private $grupo;

    /**
     * @var string
     *
     * @ORM\Column(name="destino", type="string", length=255)
     */
    private $destino;

    /**
     * @var string
     *
     * @ORM\Column(name="zona", type="string", length=255)
     */
    private $zona;

    /**
     * @var string
     *
     * @ORM\Column(name="icono", type="string", length=255)
     */
    private $icono;

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
     * @ORM\ManyToMany(targetEntity="Destiny\AppBundle\Entity\RolesUsuarios")
     * @ORM\JoinTable(name="backend_secciones_roles",
     *      joinColumns={@ORM\JoinColumn(name="secciones_backend_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="grupos_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     **/
    private $permisos;

    public function __toString()
    {
        return $this->getNombre();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->permisos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->zona = 'principal';

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
     * @return MenusBackend
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
     * Set grupo
     *
     * @param string $grupo
     * @return MenusBackend
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return string 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set destino
     *
     * @param string $destino
     * @return MenusBackend
     */
    public function setDestino($destino)
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * Get destino
     *
     * @return string 
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * Set icono
     *
     * @param string $icono
     * @return MenusBackend
     */
    public function setIcono($icono)
    {
        $this->icono = $icono;

        return $this;
    }

    /**
     * Get icono
     *
     * @return string 
     */
    public function getIcono()
    {
        return $this->icono;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     * @return MenusBackend
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
     * @return MenusBackend
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
     * @return MenusBackend
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
     * Set etiqueta
     *
     * @param string $etiqueta
     * @return MenusBackend
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
     * Set slug
     *
     * @param string $slug
     * @return MenusBackend
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
     * Add permisos
     *
     * @param \Destiny\AppBundle\Entity\RolesUsuarios $permisos
     * @return BackendSecciones
     */
    public function addPermisos(\Destiny\AppBundle\Entity\RolesUsuarios $permisos)
    {
        $this->permisos[] = $permisos;

        return $this;
    }

    /**
     * Remove permisos
     *
     * @param \Destiny\AppBundle\Entity\RolesUsuarios $permisos
     */
    public function removePermisos(\Destiny\AppBundle\Entity\RolesUsuarios $permisos)
    {
        $this->permisos->removeElement($permisos);
    }

    /**
     * Get permisos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPermisos()
    {
        return $this->permisos;
    }

    /**
     * Add permisos
     *
     * @param \Destiny\AppBundle\Entity\RolesUsuarios $permisos
     * @return BackendSecciones
     */
    public function addPermiso(\Destiny\AppBundle\Entity\RolesUsuarios $permisos)
    {
        $this->permisos[] = $permisos;

        return $this;
    }

    /**
     * Remove permisos
     *
     * @param \Destiny\AppBundle\Entity\RolesUsuarios $permisos
     */
    public function removePermiso(\Destiny\AppBundle\Entity\RolesUsuarios $permisos)
    {
        $this->permisos->removeElement($permisos);
    }

    /**
     * Set zona
     *
     * @param string $zona
     * @return BackendSecciones
     */
    public function setZona($zona)
    {
        $this->zona = $zona;

        return $this;
    }

    /**
     * Get zona
     *
     * @return string 
     */
    public function getZona()
    {
        return $this->zona;
    }
}
