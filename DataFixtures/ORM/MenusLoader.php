<?php
namespace Argidomin\AppBundle\DataFixtures\ORM;


use Destiny\AppBundle\Entity\Menus;

use Destiny\AppBundle\Entity\Secciones;
use Destiny\AppBundle\Entity\SeccionesContenido;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\AbstractFixture;


class MenusLoader extends AbstractFixture implements  FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
	    $menus = [['nombre' =>'Portada','limite'=> 1,'subsecciones' => false],
		          ['nombre' =>'Principal','limite'=> 5,'subsecciones' => true],
		          ['nombre' =>'Legal','limite'=> 4,'subsecciones' => false]];


		foreach($menus as $listadoMenus)
		{
			$menu = new Menus();
			$menu->setNombre($listadoMenus['nombre']);
			$menu->setHaveSubsecciones($listadoMenus['subsecciones']);
            $menu->setLimite($listadoMenus['limite']);
			$menu->setEstado(true);

			$manager->persist($menu);



			for ($i=1;$i<=$listadoMenus['limite'];$i++)
			{
				$seccion = new Secciones();
				($listadoMenus['nombre'] === 'Portada') ? $seccion->setPortada(true) :'';
					$seccion->setNombre('Seccion '.$i.' '.$menu->getNombre());
				$seccion->setEtiquetaMenu($menu->getNombre() .' '.$i);
				$seccion->setTituloSeccion('Seccion '.$i.' '.$menu->getNombre());
				$seccion->setTituloSeo('Seccion '.$i.' '.$menu->getNombre());
				$seccion->setDescripcionSeo('Seccion '.$i.' '.$menu->getNombre());
				$seccion->setTituloWeb('Seccion '.$i.' '.$menu->getNombre());
				$seccion->setMenu($menu);
				$seccion->setUrl($menu->getNombre() .' '.$i);
				$seccion->setPosicion($i);
				$seccion->setEstado(true);
				$seccion->setTipo($manager->getRepository('DestinyAppBundle:SeccionesTipo')->findOneBySlug('contenido'));

				$manager->persist($seccion);


				if ($listadoMenus['nombre'] === 'Principal' and $i == $listadoMenus['limite'] - 1)
				{
					$i++;
					$tipo = $manager->getRepository('DestinyAppBundle:SeccionesTipo')->findOneBySlug('listado-de-noticias');
					$seccion = new Secciones();
					$seccion->setNombre($tipo);
					$seccion->setUrl($tipo);
					$seccion->setEtiquetaMenu($tipo);
					$seccion->setTituloSeccion($tipo);
					$seccion->setTituloSeo($tipo);
					$seccion->setDescripcionSeo($tipo);
					$seccion->setTituloWeb($tipo);
					$seccion->setMenu($menu);
					$seccion->setPosicion($i);
					$seccion->setEstado(true);
					$seccion->setTipo($tipo);


					$manager->persist($seccion);



				}
			}

		}

        $manager->flush();
    }

    public function getOrder()
    {
        return 12; // the order in which fixtures will be loaded
    }
}