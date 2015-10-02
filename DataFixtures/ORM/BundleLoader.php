<?php
namespace Argidomin\KobuBundle\DataFixtures\ORM;

use Destiny\AppBundle\Entity\BundlesActivos;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\AbstractFixture;

class BundlesActivosLoader extends AbstractFixture implements  FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $bundle = new BundlesActivos();
        $bundle->setNombre('AppBundle')->setEstado(true);
        $manager->persist($bundle);

        $manager->flush();



    }

    public function getOrder()
    {
        return 0; // the order in which fixtures will be loaded
    }
}