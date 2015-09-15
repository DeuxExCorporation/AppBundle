<?php
namespace Argidomin\AppBundle\DataFixtures\ORM;


use Destiny\AppBundle\Entity\EmpresaContacto;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class EmpresaContactoLoader extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
	public function load (ObjectManager $manager)
	{
		$empresa = new EmpresaContacto();

		$empresa->setNombre ('Destiny Proyect');
		$empresa->setDireccion ('Calle falsa 123');
		$empresa->setCiudad ('Cambados');
		$empresa->setProvincia ('Pontevedra');
		$empresa->setPais ('España');

		$empresa->setTelefono ('666.666.666');
		$empresa->setMovil ('666.666.666');
		$empresa->setFax ('666.666.666');
		$empresa->setEstado (TRUE);

		$manager->persist ($empresa);

		$manager->flush ();
	}

	public function getOrder ()
	{
		return 6; // the order in which fixtures will be loaded
	}
}