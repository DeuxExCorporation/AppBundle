<?php

namespace Destiny\AppBundle\Controller;

use Destiny\AppBundle\Entity\BackendPermisos;
use Destiny\AppBundle\Entity\EmpresaContacto;
use Destiny\AppBundle\Entity\EmpresaEmails;
use Destiny\AppBundle\Entity\EmpresaRedesSociales;
use Destiny\AppBundle\Entity\EmpresaWeb;
use Destiny\AppBundle\Entity\Idiomas;
use Destiny\AppBundle\Entity\Menus;
use Destiny\AppBundle\Entity\Secciones;
use Destiny\AppBundle\Entity\SeccionesTipo;
use Destiny\AppBundle\Entity\Usuarios;
use Destiny\AppBundle\Entity\UsuariosEmails;
use Destiny\AppBundle\Entity\BackendGruposSecciones;
use Destiny\AppBundle\Entity\BackendSecciones;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("insatalaccion-")
 *
 */
class InstalaccionController extends Controller
{
    /**
     * @Route("datos-empresa-web/", name="portadaInstalacion")
     * @Template()
     */
    public function datosEmpresaAction(Request $request)
    {
	    $em = $this->getDoctrine()->getManager();

	    $empresa = new EmpresaWeb();

	    $formulario = $this->createForm($this->get('empresaWeb'),$empresa);
		$formulario->remove('estado');
        $formulario->add ('plantilla', 'text', ['label' => $this->get('translator')->trans ('empresa.form.plantilla')]);
	    $formulario->handleRequest($request);

	    if (($formulario->isSubmitted ()) && ($formulario->isValid ()))
	    {
			$empresa->upload();
			$empresa->setEstado(true);
		    $em->persist($empresa);
		    $em->flush ();

		    $traductor = $this->get('translator');

		    $this->get ('session')->getFlashBag()->set ('success', [
			    'title' => $traductor->trans ('flash.datosEmpresa.title'),
			    'message' => $traductor->trans ('flash.datosEmpresa.message', ['entidad' => $empresa])
		    ]);

		    return $this->redirect($this->generateUrl('empresaContacto',['empresa' => $empresa->getSlug()]));
	    }

	    $traductor = $this->get('translator');

	    $this->get ('session')->getFlashBag()->set ('info', [
		    'title' => $traductor->trans ('flash.instalacion.title'),
		    'message' => $traductor->trans ('flash.instalacion.message')
	    ]);

		return $this->render('DestinyAppBundle:Instalaccion:datosEmpresa.html.twig',
							['form' => $formulario->createView()]
							);
    }

    /**
     * @Route("empresa-contacto/{empresa}",name="empresaContacto")
     * @ParamConverter("empresa", class="DestinyAppBundle:EmpresaWeb",
     * options={"empresa" = "slug", "repository_method" = "findOneBySlug"})
     */
    public function datosEmpresaContactoAction(EmpresaWeb $empresa, Request $request)
    {
	    $em = $this->getDoctrine()->getManager();
	    $contacto = new EmpresaContacto();

	    $formulario = $this->createForm($this->get('empresacontacto'),$contacto);
	    $formulario->handleRequest($request);

	    if (($formulario->isSubmitted ()) && ($formulario->isValid ()))
	    {
		    $em->persist ($contacto);
		    $em->flush ();

		    $traductor = $this->get('translator');

		    $this->get ('session')->getFlashBag()->set ('success', [
			    'title' => $traductor->trans ('flash.datosContacto.title'),
			    'message' => $traductor->trans ('flash.datosContacto.message', ['entidad' => $empresa])
		    ]);

		    return $this->redirect($this->generateUrl('empresaRedesSociales',
			        [
				        'empresa'  => $empresa->getSlug(),
				        'contacto' => $contacto->getSlug()
			        ]));
	    }
	    return $this->render ('DestinyAppBundle:Instalaccion:datosEmpresaContacto.html.twig',
		    [
			    'empresa' => $empresa,
			    'form'    => $formulario->createView()
		    ]
	    );
    }

    /**
     * @Route("empresa-redes-sociales/{empresa}/{contacto}",name="empresaRedesSociales")
     * @ParamConverter("empresa", class="DestinyAppBundle:EmpresaWeb",
     * options={"empresa" = "slug", "repository_method" = "findOneBySlug"})
     * @ParamConverter("contacto", class="DestinyAppBundle:EmpresaContacto",
     * options={"contacto" = "slug", "repository_method" = "findOneBySlug"})
     */
    public function datosEmpresaRedesSocialAction(EmpresaWeb $empresa, EmpresaContacto $contacto, Request $request)
    {
	    $em = $this->getDoctrine()->getManager();
	    $social = new EmpresaRedesSociales();

	    $formulario = $this->createForm($this->get('empresaredessociales'),$social);
	    $formulario->handleRequest($request);

	    if (($formulario->isSubmitted ()) && ($formulario->isValid ()))
	    {
		    $em->persist ($social);
		    $em->flush ();


		    $traductor = $this->get('translator');

		    $this->get ('session')->getFlashBag()->set ('success', [
			    'title' => $traductor->trans ('flash.datosSocial.title'),
			    'message' => $traductor->trans ('flash.datosSocial.message', ['entidad' => $social->getNombre()])
		    ]);

			return $this->redirect($this->generateUrl('empresaRedesSociales',
				[
					'empresa'  => $empresa->getSlug(),
					'contacto' => $contacto->getSlug()
				]));

	    }
	    return $this->render ('DestinyAppBundle:Instalaccion:datosEmpresaRedesSocial.html.twig',
		    [
			    'empresa' => $empresa,
			    'contacto' => $contacto,
			    'redes'   => $em->getRepository("DestinyAppBundle:EmpresaRedesSociales")->findAll(),
			    'form'    => $formulario->createView()
		    ]
	    );
    }

    /**
     * @Route("/empresa-idioma-defecto/{empresa}/{contacto}",name="empresaIdiomaDefecto")
     * @ParamConverter("empresa", class="DestinyAppBundle:EmpresaWeb",
     * options={"empresa" = "slug", "repository_method" = "findOneBySlug"})
     * @ParamConverter("contacto", class="DestinyAppBundle:EmpresaContacto",
     * options={"contacto" = "slug", "repository_method" = "findOneBySlug"})
     */
    public function idiomaDefectoAction(EmpresaWeb $empresa, EmpresaContacto $contacto, Request $request)
    {
	    $em = $this->getDoctrine()->getManager();
	    $idioma = new Idiomas();

	    $formulario = $this->createForm($this->get('idiomas'),$idioma);
	    $formulario->remove('estado');
	    $formulario->handleRequest($request);

	    if (($formulario->isSubmitted ()) && ($formulario->isValid ()))
	    {
		    $idioma->upload();
		    $idioma->setDefecto(true);
		    $idioma->setEstado(true);
		    $em->persist ($idioma);
		    $em->flush ();

		    $traductor = $this->get('translator');

		    $this->get ('session')->getFlashBag()->set ('success', [
			    'title' => $traductor->trans ('flash.idioma.title'),
			    'message' => $traductor->trans ('flash.idioma.message', ['entidad' => $idioma])
		    ]);

            $this->createMenusBackend();
            $this->createPermisos();

		    return $this->redirect($this->generateUrl('empresaUsuarioAdmin',
			    [
				    'empresa'  => $empresa->getSlug(),
				    'contacto' => $contacto->getSlug(),
				    'idioma'   => $idioma->getSlug()
			    ]));

	    }

	    return $this->render ('DestinyAppBundle:Instalaccion:idiomaDefecto.html.twig',
		    [
			    'empresa' => $empresa,
			    'contacto' => $contacto,
			    'redes'   => $em->getRepository("DestinyAppBundle:EmpresaRedesSociales")->findAll(),
			    'form'    => $formulario->createView()
		    ]
	    );
    }

	/**
	 * @Route("empresa-usuario-admin/{empresa}/{contacto}/{idioma}",name="empresaUsuarioAdmin")
	 * @ParamConverter("empresa", class="DestinyAppBundle:EmpresaWeb",
	 * options={"empresa" = "slug", "repository_method" = "findOneBySlug"})
	 * @ParamConverter("contacto", class="DestinyAppBundle:EmpresaContacto",
	 * options={"contacto" = "slug", "repository_method" = "findOneBySlug"})
	 *  @ParamConverter("idioma", class="DestinyAppBundle:Idiomas",
	 * options={"idioma" = "slug", "repository_method" = "findOneBySlug"})
	 */

	public function crearUsuarioAdminAction(EmpresaWeb $empresa, EmpresaContacto $contacto, Idiomas $idioma, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$usuarios = new Usuarios();

		$formulario = $this->createForm($this->get('usuarios'),$usuarios);
		$formulario->remove('estado');
		$formulario->handleRequest($request);
		$redes = $em->getRepository ("DestinyAppBundle:EmpresaRedesSociales")->findAll ();


		if (($formulario->isSubmitted ()) && ($formulario->isValid ()))
		{
            $this->createEmails();
			$usuarios->setRoles(['ROLE_ROOT']);
			$usuarios->setEstado(true);

			$em->persist ($usuarios);
			$em->flush ();


			$traductor = $this->get('translator');

			$this->get ('session')->getFlashBag()->set ('success', [
				'title' => $traductor->trans ('flash.usuarioRoot.title'),
				'message' => $traductor->trans ('flash.usuarioRoot.message', ['entidad' => $usuarios])
			]);



			$this->createMenus();


            return $this->redirect($this->generateUrl('portadaBackend'));

		}

		return $this->render ('DestinyAppBundle:Instalaccion:crearUsuarioAdmin.html.twig',
			[
				'empresa'  => $empresa,
				'contacto' => $contacto,
				'redes'    => $redes,
				'idioma'   => $idioma,
				'form'     => $formulario->createView ()
			]
		);

	}

	private function createMenus()
	{
		$em = $this->getDoctrine()->getManager();
		$menus = [['nombre' => 'Portada'  ,'limite'=> 1  ,'subsecciones' => false],
			      ['nombre' => 'Principal','limite'=> 10 ,'subsecciones' => true],
			      ['nombre' => 'Legal'    ,'limite'=> 4  ,'subsecciones' => false]];

		foreach($menus as $listadoMenus)
		{
			$menu = new Menus();
			$menu->setNombre($listadoMenus['nombre']);
			$menu->setHaveSubsecciones($listadoMenus['subsecciones']);
			$menu->setEstado(true);

			$em->persist($menu);

			if ($menu->getNombre() === 'Portada')
			{
				$this->createTipoSecciones();
				$seccion = new Secciones();

				$seccion->setNombre('Portada')
						->setEtiquetaMenu('Portada')
						->setTituloSeccion('Portada')
						->setTituloSeo('Portada')
						->setDescripcionSeo('Portada')
						->setTituloWeb('Portada')
						->setTipo($em->getRepository('DestinyAppBundle:SeccionesTipo')->findOneBySlug('contenido'))
						->setMenu($menu)
						->setPosicion(1)
			            ->setEstado(true)
				        ->setPortada(true);

				$em->persist($seccion);
			}
		}

		$em->flush ();
	}

	private function createTipoSecciones()
	{
		$em = $this->getDoctrine()->getManager();

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

				$em->persist($tipoSeccion);
			}

			$tipoSeccion = new SeccionesTipo();
			$tipoSeccion->setNombre($tipo['nombre']);


			$em->persist($tipoSeccion);
		}



		$em->flush();
	}

	private function createEmails()
	{
		$em = $this->getDoctrine()->getManager();

		$email = new EmpresaEmails();
		$email->setnombre('Email')->setTextocabecera('cabecera')->setTextoPie('pie')->setRuta ('destiny-proyect.jpg');
		$em->persist ($email);

		$usuarioEmail = new UsuariosEmails();
		$usuarioEmail->setNombre('Nuevo usuario')->setAsunto('Nuevo usuario')->setDescripcion('Cuerpo')->setEstado(TRUE);

		$em->persist ($usuarioEmail);

		$usuarioEmail = new UsuariosEmails();
		$usuarioEmail->setNombre('Modificacion usuario')->setAsunto('Modificacion usuario')->setDescripcion('Cuerpo')->setEstado(TRUE);

		$em->persist ($usuarioEmail);

		$em->flush ();
	}

	private function createMenusBackend()
	{
		$grupos = [['nombre'    => 'Contenido',
				   'etiqueta'  => 'configuration.list.content',
				   'secciones' => [['destino'  => 'menus',
					                'icono'    => '<i class="fa fa-list-alt"></i>',
					                'nombre'   => 'Menus',
					                'etiqueta' => 'configuration.list.menus'],
					               ['destino'  => 'secciones',
								    'icono'    => '<i class="fa fa-file-text"></i>',
									'nombre'   => 'Secciones',
									'etiqueta' => 'configuration.list.sections']]],
				  ['nombre'    => 'Gestion backend',
				   'etiqueta'  => 'configuration.list.backend',
				   'secciones' => [['destino' => 'gruposMenusBackend',
					               'icono'    => '<i class="fa fa-list-alt"></i>',
					               'nombre'   => 'Grupos',
					               'etiqueta' => 'configuration.list.gruposMenusBackend'],
					              ['destino'  => 'menusBackend',
						           'icono'    => '<i class="fa fa-file-text"></i>',
						           'nombre'   => 'Secciones backens',
						           'etiqueta' => 'configuration.list.menusBackend']]],

			     ['nombre'   => 'Media',
				  'etiqueta' => 'configuration.list.contentMedia',
				  'secciones' => [['destino' => 'adjuntos',
					               'icono'   => '<i class="fa fa-file-pdf-o"></i>',
					               'nombre'  => 'PDF',
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
			['nombre'   => 'Historias',
				'etiqueta' => 'configuration.list.historias',
				'secciones' => [['destino' => 'historias',
					'icono'   => '<i class="fa fa-leanpub"></i>',
					'nombre'  => 'Historias',
					'etiqueta' => 'configuration.list.historias']

					,['destino' => 'accionesHabilidades',
						'icono'   => '<i class="fa fa-sliders"></i>',
						'nombre'  => 'Habilidades',
						'etiqueta' => 'configuration.list.habilidades'],

					['destino' => 'sistemas',
						'icono'   => '<i class="fa fa-cog"></i>',
						'nombre'  => 'Sistemas',
						'etiqueta' => 'configuration.list.sistema'],


				]] ];

		$em = $this->getDoctrine()->getManager();
		foreach($grupos as $menu)
		{
			$grupo = new BackendGruposSecciones();
			$grupo->setNombre($menu['nombre'])->setEtiqueta($menu['etiqueta'])->setEstado(true);

			$em->persist($grupo);

			foreach($menu['secciones'] as $seccion)
			{

				$seccionBackend = new BackendSecciones();
				$seccionBackend->setNombre($seccion['nombre'])
								->setDestino($seccion['destino'])
								->setIcono($seccion['icono'])
								->setEtiqueta($seccion['etiqueta'])
								->setGrupo($grupo)
								->setEstado(TRUE);

				$em->persist($seccionBackend);
			}

		}

		$em->flush();
	}

	private function createPermisos()
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
		$em = $this->getDoctrine()->getManager();
		foreach ($entidades as $entidad)
		{
			$permiso = new BackendPermisos();
            $permiso->setNombre($entidad['nombre'])->setEntidad($entidad['entidad'])->setCrear(true)->setEditar(true)->setBorrar(true)->setEstado(true);
			$em->persist($permiso);
		}



		$em->flush();
	}

}
