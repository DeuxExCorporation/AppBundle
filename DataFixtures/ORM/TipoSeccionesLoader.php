<?php
namespace Argidomin\AppBundle\DataFixtures\ORM;

use Destiny\AppBundle\Entity\SeccionesTipo;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\Validator\Constraints\True;

class TipoSeccionesLoader extends AbstractFixture implements  FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

	    $tipos = [['nombre' => 'Contenido', 'listable' => true],
		    ['nombre' => 'Contacto' , 'listable' => true],
		    ['nombre' => 'Sitemap' , 'listable' => true],
		    ['nombre' => 'Noticias' , 'listable' => FALSE],
		    ['nombre' => 'Historias' , 'listable' => FALSE],
	    ];

	    foreach ($tipos as $tipo)
	    {
		    if ($tipo['listable'] === FALSE)
		    {
			    $tipoSeccion = new SeccionesTipo();
			    $tipoSeccion->setNombre('Listado de '.$tipo['nombre'])->setEntidad($tipo['nombre']);

			    $manager->persist($tipoSeccion);
		    }

			    $tipoSeccion = new SeccionesTipo();
			    $tipoSeccion->setNombre($tipo['nombre']);


		        $manager->persist($tipoSeccion);
	    }



        $manager->flush();
    }

    public function getOrder()
    {
        return 10; // the order in which fixtures will be loaded
    }
}