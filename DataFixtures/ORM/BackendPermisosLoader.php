<?php
namespace Argidomin\AppBundle\DataFixtures\ORM;


use Destiny\AppBundle\Entity\BackendPermisos;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\Validator\Constraints\True;

class BackendPermisosLoader extends AbstractFixture implements  FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
		$entidades =[['nombre' => 'Menus (Front)',
                      'entidad'=> 'Menus'],
                    ['nombre' => 'Secciones(Front)',
                     'entidad'=> 'Secciones'],
                ['nombre' => 'Contenido secciones(Front)',
                    'entidad'=> 'SeccionesContenido'],
                    ['nombre' => 'Videos',
                        'entidad'=> 'Videos'],
                    ['nombre' => 'Adjuntos(PDF)',
                        'entidad'=> 'Adjuntos'],
                    ['nombre' => 'Imagenes',
                        'entidad'=> 'Imagenes'],
                    ['nombre' => 'Sliders',
                        'entidad'=> 'Sliders'],
            ['nombre' => 'Articulos',
                'entidad'=> 'Articulos'],
            ['nombre' => 'Noticias',
                'entidad'=> 'Noticias'],
            ['nombre' => 'Contenido noticias(Front)',
                'entidad'=> 'NoticiasContenido'],
                    ['nombre' => 'Categorias de las Noticias',
                        'entidad'=> 'NoticiasCategorias'],

                    ['nombre' => 'Usuarios',
                        'entidad'=> 'Usuarios'],
                    ['nombre' => 'Emails',
                        'entidad'=> 'UsuariosEmail'],
                    ['nombre' => 'Newsletter',
                        'entidad'=> 'Newsletter'],
                    ['nombre' => 'Secciones del Backend',
                        'entidad'=> 'BackendSecciones'],
                    ['nombre' => 'Permisos',
                        'entidad'=> 'BackendPermisos'],
                    ['nombre' => 'Idiomas',
                        'entidad'=> 'Idiomas'],
            ['nombre' => 'Mensajes de la web',
                'entidad'=> 'Mensajes'],
            ['nombre' => 'Redes Sociales',
                'entidad'=> 'EmpresaRedesSociales'],
        ];

	    foreach ($entidades as $entidad)
	    {
		    $permiso = new BackendPermisos();
			$permiso->setNombre($entidad['nombre'])->setEntidad($entidad['entidad'])->setCrear(true)->setEditar(true)->setBorrar(true)->setEstado(true);

		    $manager->persist($permiso);
	    }



        $manager->flush();
    }

    public function getOrder()
    {
        return 3000; // the order in which fixtures will be loaded
    }
}