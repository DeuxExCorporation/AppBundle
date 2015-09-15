<?php

namespace Destiny\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;


use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * EmpresaEmails
 *
 * @ORM\Table(name="empresa_emails")
 * @ORM\Entity(repositoryClass="Destiny\AppBundle\Entity\Repository\EmpresaEmailsRepository")
 */
class EmpresaEmails
{
    /**
     * @var string
     *
     * @ORM\Column(name="Nombre", type="string", length=255)
     * @Assert\NotBlank(message="acciones.name.notblank")
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "acciones.name.min",
     *      maxMessage = "acciones.name.max"
     * )
     */
    private $nombre = 'defecto';

    /**
     * @var string
     * @Gedmo\Slug(fields={"nombre"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

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
     * @ORM\Column(name="textoCabecera", type="text")
     */
    private $textoCabecera;

    /**
     * @var string
     *
     * @ORM\Column(name="textoPie", type="text")
     */
    private $textoPie;

    /**
     * @return string
     * @Assert\File(maxSize="1M",mimeTypes = {
     *          "image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *          "image/gif"})
     *
     */
    private $archivo;

    /**
     * @ORM\Column(name="ruta", type="string")
     */
    private $ruta;

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

    public function getType()
    {
        return 'image';
    }

    public function getAbsolutePath()
    {
        return null === $this->ruta
            ? null
            : $this->getUploadRootDir().'/'.$this->ruta;
    }

    public function getWebPath()
    {
        return null === $this->ruta
            ? null
            : $this->getUploadDir().'/'.$this->ruta;
    }

    protected function getUploadRootDir()
    {
        // la ruta absoluta del directorio donde se deben
        // guardar los archivos cargados
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // se deshace del __DIR__ para no meter la pata
        // al mostrar el documento/imagen cargada en la vista.

        return 'asset/backend/img';
    }

    public function setArchivo(UploadedFile $archivo)
    {
        $this->archivo = $archivo;

        return $this;
    }

    public function getArchivo()
    {
        return $this->archivo;

    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getArchivo()) {
            return;
        }


        // aqu� usa el nombre de archivo original pero lo debes
        // sanear al menos para evitar cualquier problema de seguridad

        // move takes the target directory and then the
        // target filename to move to
        $clean = $this->getNombre();
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

        $nombreArchivo = $clean.'.' .$this->getArchivo()->getClientOriginalExtension();


        $this->getArchivo()->move(
            $this->getUploadRootDir(),
            $nombreArchivo
        );

        // set the path property to the filename where you've saved the file
        $this->ruta = $nombreArchivo;

        // limpia la propiedad �file� ya que no la necesitas m�s
        $this->archivo = null;
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
     * Set textoCabecera
     *
     * @param string $textoCabecera
     * @return EmpresaEmails
     */
    public function setTextoCabecera($textoCabecera)
    {
        $this->textoCabecera = $textoCabecera;

        return $this;
    }

    /**
     * Get textoCabecera
     *
     * @return string 
     */
    public function getTextoCabecera()
    {
        return $this->textoCabecera;
    }

    /**
     * Set textoPie
     *
     * @param string $textoPie
     * @return EmpresaEmails
     */
    public function setTextoPie($textoPie)
    {
        $this->textoPie = $textoPie;

        return $this;
    }

    /**
     * Get textoPie
     *
     * @return string 
     */
    public function getTextoPie()
    {
        return $this->textoPie;
    }

    /**
     * Set ruta
     *
     * @param string $ruta
     * @return EmpresaEmails
     */
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;

        return $this;
    }

    /**
     * Get ruta
     *
     * @return string 
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return EmpresaEmails
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
     * @return EmpresaEmails
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
     * Set nombre
     *
     * @param string $nombre
     * @return EmpresaEmails
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
     * Set slug
     *
     * @param string $slug
     * @return EmpresaEmails
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
}
