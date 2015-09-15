<?php
namespace Argidomin\AppBundle\DataFixtures\ORM;


use Destiny\AppBundle\Entity\Menus;

use Destiny\AppBundle\Entity\NoticiasCategorias;
use Destiny\AppBundle\Entity\Secciones;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\AbstractFixture;


class CategoriasNoticiasLoader extends AbstractFixture implements  FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {



			for ($i=1;$i<=10;$i++) {
				$categoria = new NoticiasCategorias();
				$categoria->setNombre ('Categoría ' . $i);

				$categoria->setEstado (TRUE);

				$manager->persist ($categoria);


			}

        $manager->flush();
    }

    public function getOrder()
    {
        return 13; // the order in which fixtures will be loaded
    }
}