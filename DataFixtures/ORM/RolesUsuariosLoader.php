<?php
namespace Argidomin\AppBundle\DataFixtures\ORM;


use Destiny\AppBundle\Entity\BackendPermisos;
use Destiny\AppBundle\Entity\RolesUsuarios;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\Validator\Constraints\True;

class RolesUsuariosLoader extends AbstractFixture implements  FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
		$entidades =[['nombre' => 'Gestores',
                     'grupo'=> 'ROLE_GESTORES'],
        ];

	    foreach ($entidades as $entidad)
	    {
		    $permiso = new RolesUsuarios();
			$permiso->setNombre($entidad['nombre'])->setGrupo($entidad['grupo'])->setEstado(true);

		    $manager->persist($permiso);
	    }



        $manager->flush();
    }

    public function getOrder()
    {
        return 3000; // the order in which fixtures will be loaded
    }
}