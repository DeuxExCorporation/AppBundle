<?php
namespace Argidomin\AppBundle\DataFixtures\ORM;


use Destiny\AppBundle\Entity\Menus;

use Destiny\AppBundle\Entity\Noticias;
use Destiny\AppBundle\Entity\Secciones;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\AbstractFixture;


class NoticiasLoader extends AbstractFixture implements  FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
			$categoria = $manager->getRepository('DestinyAppBundle:NoticiasCategorias')->findOneById(1);


			for ($i=1;$i<=10;$i++) {
				$noticia = new Noticias();
				$noticia->setNombre ('Noticia ' . $i);
				$noticia->setTituloSeo ('Noticia ' . $i);
				$noticia->setDescripcionSeo ('Noticia ' . $i);
				$noticia->setTitulo ('Noticia ' . $i);
				$noticia->setDescripcion ('Noticia ' . $i);
				$noticia->setEstado (TRUE);
				$noticia->setTipo($manager->getRepository('DestinyAppBundle:SeccionesTipo')->findOneBySlug('noticias'));
				$noticia->addCategoria($categoria);
				$manager->persist ($noticia);


			}

        $manager->flush();
    }

    public function getOrder()
    {
        return 14; // the order in which fixtures will be loaded
    }
}