<?php
namespace Argidomin\AppBundle\DataFixtures\ORM;


use Destiny\AppBundle\Entity\Imagenes;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\AbstractFixture;


class ImagenesLoader extends AbstractFixture implements  FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

	    for ($i=1;$i<=8;$i++)
	    {
		    $imagen = new Imagenes();
			$imagen->setNombre('Imagen '.$i);
		    $imagen->setRuta('imagen-'.$i.'.jpg');
			$imagen->setAlt('Texto alternativo de la imagen '.$i);
			$imagen->setDescripcion('Descripición de la imagen '.$i);
		    $imagen->setEstado(true);
		    $manager->persist($imagen);
	    }



        $manager->flush();
    }

    public function getOrder()
    {
        return 7; // the order in which fixtures will be loaded
    }
}