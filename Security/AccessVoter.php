<?php

namespace Destiny\AppBundle\Security;


use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Doctrine\ORM\EntityRepository;

class AccessVoter extends AbstractVoter
{
    const VIEW   = 'view';
    const EDIT   = 'edit';
    const CREATE = 'create';
    const DELETE = 'delete';

    public $permisos;

    public function __construct(entityRepository $entityRepository)
    {
        $this->permisos = $entityRepository;

    }

    protected function getSupportedAttributes()
    {
        return array(self::VIEW, self::EDIT, self::CREATE, self::DELETE);
    }

    protected function getSupportedClasses()
    {
        foreach($this->permisos->findAll() as $entidad)
        {
            $entidades[] = 'Destiny\AppBundle\Entity\\'. $entidad->getEntidad();
        }


        return $entidades;
    }

    protected function isGranted($accion, $entidad, $user = null)
    {

        $entidad = $this->permisos->findOneByEntidad($this->getClassName($entidad));


        switch($accion) {
            case self::VIEW:

                $resultado = ($entidad->getEstado() === true) ? true : false;

                return $resultado;
                break;

            case self::EDIT:
                $resultado = ($entidad->getEditar() === true) ? false : true;

                return $resultado;

                break;

            case self::DELETE:
                $resultado = ($entidad->getBorrar() === true) ? true : false;
                return $resultado;
                break;

            case self::CREATE:
                $resultado = ($entidad->getCrear() === true) ? true : false;
                return $resultado;
                break;

        }

        return true;
    }

    protected function getClassName($class)
    {
        $class = explode('\\', get_class($class));
        return array_pop($class);
    }
}
