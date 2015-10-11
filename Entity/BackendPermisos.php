<?php

namespace Destiny\AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Permisos
 *
 * @ORM\Table(name="backend_permisos")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\BackendPermisosRepository")
 * @UniqueEntity("entidad")
 */
class BackendPermisos
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
     *
     * @ORM\Column(name="entidad", type="string", length=255)
     */
    private $entidad;

    /**
     * @var string
     * @Gedmo\Slug(fields={"entidad"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="crear", type="boolean")
     */
    private $crear;

    /**
     * @var boolean
     *
     * @ORM\Column(name="editar", type="boolean")
     */
    private $editar;

    /**
     * @var boolean
     *
     * @ORM\Column(name="borrar", type="boolean")
     */
    private $borrar;

    /**
     * @ORM\ManyToMany(targetEntity="Destiny\AppBundle\Entity\RolesUsuarios")
     * @ORM\JoinTable(name="grupos_permisos",
     *      joinColumns={@ORM\JoinColumn(name="permisos_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="grupos_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     **/
    private $grupos;

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
        return $this->getNombre();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->grupos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return BackendPermisos
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
     * Set entidad
     *
     * @param string $entidad
     * @return BackendPermisos
     */
    public function setEntidad($entidad)
    {
        $this->entidad = $entidad;

        return $this;
    }

    /**
     * Get entidad
     *
     * @return string 
     */
    public function getEntidad()
    {
        return $this->entidad;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return BackendPermisos
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
     * Set crear
     *
     * @param boolean $crear
     * @return BackendPermisos
     */
    public function setCrear($crear)
    {
        $this->crear = $crear;

        return $this;
    }

    /**
     * Get crear
     *
     * @return boolean 
     */
    public function getCrear()
    {
        return $this->crear;
    }

    /**
     * Set editar
     *
     * @param boolean $editar
     * @return BackendPermisos
     */
    public function setEditar($editar)
    {
        $this->editar = $editar;

        return $this;
    }

    /**
     * Get editar
     *
     * @return boolean 
     */
    public function getEditar()
    {
        return $this->editar;
    }

    /**
     * Set borrar
     *
     * @param boolean $borrar
     * @return BackendPermisos
     */
    public function setBorrar($borrar)
    {
        $this->borrar = $borrar;

        return $this;
    }

    /**
     * Get borrar
     *
     * @return boolean 
     */
    public function getBorrar()
    {
        return $this->borrar;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     * @return BackendPermisos
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
     * @return BackendPermisos
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
     * @return BackendPermisos
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
     * Add grupos
     *
     * @param \Destiny\AppBundle\Entity\RolesUsuarios $grupos
     * @return BackendPermisos
     */
    public function addGrupo(\Destiny\AppBundle\Entity\RolesUsuarios $grupos)
    {
        $this->grupos[] = $grupos;

        return $this;
    }

    /**
     * Remove grupos
     *
     * @param \Destiny\AppBundle\Entity\RolesUsuarios $grupos
     */
    public function removeGrupo(\Destiny\AppBundle\Entity\RolesUsuarios $grupos)
    {
        $this->grupos->removeElement($grupos);
    }

    /**
     * Get grupos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrupos()
    {
        return $this->grupos;
    }
}
