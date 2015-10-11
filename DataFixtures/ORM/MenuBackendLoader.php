<?php
namespace Argidomin\AppBundle\DataFixtures\ORM;


use Destiny\AppBundle\Entity\BackendGruposSecciones;
use Destiny\AppBundle\Entity\BackendSecciones;
use Destiny\AppBundle\Entity\GruposMenusBackend;
use Destiny\AppBundle\Entity\MenusBackend;

use Destiny\AppBundle\Entity\Secciones;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\AbstractFixture;


class MenuBackendLoader extends AbstractFixture implements  FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
		$grupos = [
					['nombre'    => 'Contenido web',
					 'etiqueta'  => 'configuration.list.content',
				 	 'secciones' => [['destino' => 'menus',
								    'icono'   => '<i class="fa fa-list-alt"></i>',
									'nombre'  => 'Menus',
									'etiqueta' => 'configuration.list.menus']
								  ,['destino' => 'secciones',
							        'icono'   => '<i class="fa fa-file-text"></i>',
				                    'nombre'  => 'Secciones',
						 	        'etiqueta' => 'configuration.list.sections']]],


					['nombre'   => 'Media',
					 'etiqueta' => 'configuration.list.contentMedia',
					 'secciones' => [['destino' => 'adjuntos',
						              'icono'   => '<i class="fa fa-file-pdf-o"></i>',
						              'nombre'  => 'Adjuntos',
						              'etiqueta' => 'configuration.list.pdf']

						            ,['destino' => 'videos',
							          'icono'   => '<i class="fa fa-youtube"></i>',
							          'nombre'  => 'Videos',
						              'etiqueta' => 'configuration.list.videos'],

						            ['destino' => 'imagenes',
							         'icono'   => '<i class="fa fa-file-image-o"></i>',
							         'nombre'  => 'Imagenes',
					                 'etiqueta' => 'configuration.list.images'],

									['destino' => 'sliders',
									 'icono'   => '<i class="fa fa-slideshare"></i>',
									 'nombre'  => 'Sliders',
									 'etiqueta' => 'configuration.list.slider']
					                ]],
					['nombre'   => 'Noticias',
						'etiqueta' => 'configuration.list.news',
						'secciones' => [['destino' => 'noticiasCategorias',
							'icono'   => '<i class="fa fa-list-alt"></i>',
							'nombre'  => 'Categorias Noticias',
							'etiqueta' => 'configuration.list.noticiascategoria']

							,['destino' => 'noticias',
								'icono'   => '<i class="fa fa-newspaper-o"></i>',
								'nombre'  => 'Noticias',
								'etiqueta' => 'configuration.list.noticias'],

						]],
					['nombre'   => 'Usuarios',
						'etiqueta' => 'configuration.list.users',
						'secciones' => [['destino' => 'usuarios',
							'icono'   => '<i class="fa fa-users"></i>',
							'nombre'  => 'Usuarios',
							'etiqueta' => 'configuration.list.users']

							,['destino' => 'usuariosEmails',
								'icono'   => '<i class="fa fa-envelope-o"></i>',
								'nombre'  => 'Emails usuarios',
								'etiqueta' => 'configuration.list.userEmails'],

						]],
					['nombre'   => 'Newsletter',
						'etiqueta' => 'configuration.list.newsletter',
							'secciones' => [['destino' => 'newsletter',
							'icono'   => '<i class="fa fa-newspaper-o"></i>',
							'nombre'  => 'Newsletter',
							'etiqueta' => 'configuration.list.newsletter']

						]],

			['nombre'    => 'Gestion backend',
				'etiqueta'  => 'configuration.list.backend',
				'secciones' => [
					['destino' => 'BackendSecciones',
						'icono'   => '<i class="fa fa-file-text"></i>',
						'nombre'  => 'Secciones backend',
						'etiqueta' => 'configuration.list.menusBackend'],
					['destino' => 'BackendPermisos',
						'icono'   => '<i class="fa fa-lock"></i>',
						'nombre'  => 'Permisos',
						'etiqueta' => 'configuration.list.permisos']
				]],
			];


	    foreach($grupos as $menu)
	    {
		    $grupo = new BackendGruposSecciones();
		    $grupo->setNombre($menu['nombre'])->setEtiqueta($menu['etiqueta'])->setEstado(true)->setLimite(0);

		    $manager->persist($grupo);

		    foreach($menu['secciones'] as $seccion)
		    {

			    $seccionBackend = new BackendSecciones();
			    $seccionBackend->setNombre($seccion['nombre'])
				               ->setDestino($seccion['destino'])
				               ->setIcono($seccion['icono'])
				               ->setEtiqueta($seccion['etiqueta'])
                               ->setZona('principal')
				               ->setGrupo($grupo)
			                   ->setEstado(TRUE);

			    $manager->persist($seccionBackend);
		    }

	    }

        $manager->flush();
    }

    public function getOrder()
    {
        return 23; // the order in which fixtures will be loaded
    }
}