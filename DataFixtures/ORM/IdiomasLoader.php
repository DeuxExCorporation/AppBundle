<?php
namespace Argidomin\AppBundle\DataFixtures\ORM;

use Destiny\AppBundle\Entity\Idiomas;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\AbstractFixture;

class IdiomasLoader extends AbstractFixture implements  FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $idiomas = new Idiomas();
        $idiomas->setNombre('English');
        $idiomas->setIsoCode('en');
        $idiomas->setEstado(true);
        $idiomas->setDefecto(true);
        $idiomas->setRuta('en.gif');

        $manager->persist($idiomas);

        $idiomas = new Idiomas();
        $idiomas->setNombre('Swahili');
        $idiomas->setIsoCode('sw');
        $idiomas->setEstado(true);
        $idiomas->setDefecto(false);
        $idiomas->setRuta('sw.gif');

        $manager->persist($idiomas);

	    $idiomas = new Idiomas();
	    $idiomas->setNombre('Spanish');
	    $idiomas->setIsoCode('es');
	    $idiomas->setEstado(true);
	    $idiomas->setDefecto(false);
	    $idiomas->setRuta('es.gif');

	    $manager->persist($idiomas);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}