<?php

namespace Destiny\AppBundle\Controller;

use Destiny\AppBundle\Entity\Idiomas;
use Destiny\AppBundle\Entity\Mensajes;


use Destiny\AppBundle\Entity\Newsletter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class FrontendController extends Controller
{

    /**
     * @Route("/sitemap.xml",name="sitemapXml")
     *
     */
    public function sitemapAction()
    {
        return $this->render ('DestinyAppBundle:Frontend:sitemap.xml.twig',
            [
                'urls'   => $this->getSitemap(),

            ]);
    }
	/**
	 * @Route("/", name="_portadaWeb")
	 *
	 */
	public function portadaSinIdiomaAction()
	{

		$em = $this->getDoctrine()->getManager();

		$idioma = $em->getRepository('DestinyAppBundle:Idiomas')->getLanguageDefault();
		$empresa = $em->getRepository('DestinyAppBundle:EmpresaWeb')->getEmpresaActiva();

		if (is_null($idioma) || is_null($empresa)) return $this->redirect($this->generateUrl('portadaInstalacion'));


		return $this->redirect($this->generateUrl('portadaWeb',['language' =>$idioma->getIsoCode() ]));
	}


    /**
	 * @Route("/{language}", name="portadaWeb",requirements={"language" = "([a-z]{2})"})
     *
     * @ParamConverter("language", class="DestinyAppBundle:Idiomas",
     * options={"language" = "isoCode", "repository_method" = "findOneByIsoCode"})
     *
     */
    public function portadaAction(Idiomas $language = null, Request $request)
    {
	    $em = $this->getDoctrine()->getManager();

	    $this->get('translator')->setLocale($language->getIsoCode());
	    $section = $em->getRepository('DestinyAppBundle:Secciones')->getPortada($language);

		if (is_null($language) || is_null($section) ) throw  $this->createNotFoundException();


        return $this->render ('DestinyAppBundle:Frontend:'.$this->get('datosEmpresa')->getPlantilla().'/'.strtolower($section->getTipo()).'.html.twig',
			[
				'seccion'     => $section,
				'language'    => $language,
				'content'     => $section->getContenidos(),
                'typeContent' => $this->getTipoPlantilla($section->getTipo(),$request, $language ),
                'newsletter'  => $this->suscribirseNewsletter($request)
			]);

    }

	/**
	 * @Route("/{language}/{section}/", name="seccionWeb", requirements={"language" = "([a-z]{2})"})
	 *
	 * @ParamConverter("language", class="DestinyAppBundle:Idiomas",
	 * options={"language" = "isoCode", "repository_method" = "findOneByIsoCode"})
	 *
	 * @ParamConverter("section", class="DestinyAppBundle:Secciones",
	 * options={"element" = "action",
	 * "mapping": {"section": "section", "language": "language"},
	 * "repository_method" = "getSectionFront", "map_method_signature" = true})
	 *
	 */
	public function seccionWebAction(Request $request, $section= null , Idiomas $language = null)
	{

		if (is_null($language) || is_null($section)) throw  $this->createNotFoundException();



		$this->get('translator')->setLocale($language->getIsoCode());

		return $this->render ('DestinyAppBundle:Frontend:'.$this->get('datosEmpresa')->getPlantilla().'/'.strtolower($section->getTipo()).'.html.twig',
			[
				'seccion'   => $section,
				'language'  => $language,
				'content'   => $section->getContenidos(),
                'typeContent' => $this->getTipoPlantilla($section->getTipo(),$request, $language ),
                'newsletter'  => $this->suscribirseNewsletter($request),
			]);

	}

	/**
	 * @Route("{section}_{language}/{year}/{news}",
	 * name="newsWeb",
	 * requirements={
	 * 		"year" = "\d{4}",
	 * 		"language" = "([a-z]{2})"}
	 * )
	 *
	 * @ParamConverter("language", class="DestinyAppBundle:Idiomas",
	 * options={"language" = "isoCode", "repository_method" = "findOneByIsoCode"})
	 *
	 * @ParamConverter("section", class="DestinyAppBundle:Secciones",
	 * options={"element" = "action",
	 * "mapping": {"section": "section", "language": "language"},
	 * "repository_method" = "getSectionFront", "map_method_signature" = true})
	 *
	 * @ParamConverter("news", class="DestinyAppBundle:Noticias",
	 * options={"element" = "action",
	 * "mapping": {"language": "language", "news": "news"},
	 * "repository_method" = "findOneNewsByIsoCode", "map_method_signature" = true})
     *
	 *
	 */
	public function newsWebAction($section= null , Idiomas $language = null, $news = null)
	{
		if (is_null($language) || is_null($section) || is_null($news)) throw  $this->createNotFoundException();

		return $this->render ('DestinyAppBundle:Frontend:'.$this->get('datosEmpresa')->getPlantilla().'/noticias.html.twig',
			[
				'seccion' => $section,
				'language'  => $language,
				'news'      => $news,
				'content'   => $news->getContenidos()
			]);



	}

    /**
     * @Route("{section}_{category}_{language}/{year}/",
     *         name="newsCategoryWeb",
     *         requirements={
     *         		"year" = "\d{4}",
     *         		"language" = "([a-z]{2})"}
     *         )
     *
     * @ParamConverter("language", class="DestinyAppBundle:Idiomas",
     * options={"language" = "isoCode", "repository_method" = "findOneByIsoCode"})
     *
     * @ParamConverter("section", class="DestinyAppBundle:Secciones",
     * options={"element" = "action",
     * "mapping": {"section": "section", "language": "language"},
     * "repository_method" = "getSectionFront", "map_method_signature" = true})
     *
     * @ParamConverter("category", class="DestinyAppBundle:NoticiasCategorias",
     * options={"category" = "slug", "repository_method" = "findOneBySlug"})
     */
    public function newsCategoryWebAction($category, Idiomas $language = null, $section = null )
    {
        if (is_null($language) || is_null($section)) throw  $this->createNotFoundException();
        $em = $this->getDoctrine()->getManager();
        return $this->render ('DestinyAppBundle:Frontend:'.$this->get('datosEmpresa')->getPlantilla().'/listado de categorias.html.twig',
            [
                'seccion'    => $section,
                'language'   => $language,
                'content'    => $section->getContenidos(),
                'list'       => $em->getRepository('DestinyAppBundle:NoticiasCategorias')->getNoticiasCategoria($category->getSlug()),
                'categorias' => $em->getRepository('DestinyAppBundle:NoticiasCategorias')->findAll()

            ]);
    }

    private function getTipoPlantilla($tipoSeccion, Request $request, $language)
    {
        switch ($tipoSeccion)
        {
            case($tipoSeccion->getSlug() == 'contacto'):

                return $this->seccionTipoContacto($request);


                break;

            case ($tipoSeccion->getSlug() == 'sitemap'):

                return $this->getSitemap();

                break;

            case(!is_null($tipoSeccion->getEntidad())):

                return $this->getDoctrine()->getManager()->getRepository('DestinyAppBundle:'.$tipoSeccion->getEntidad())->getAllFront($language);

                break;
        }

        return;
    }

	private function seccionTipoContacto(Request $request)
	{

		$mensaje = new Mensajes();

		$formulario = $this->createForm ($this->get ('contacto'), $mensaje);

		$formulario->handleRequest ($request);

		if (($formulario->isSubmitted ()) && ($formulario->isValid ()))
		{
			$em = $this->getDoctrine()->getManager();
			$mensaje->setEstado(false);

           if ($request->getSession()->get('enviado') === true)
            {
                $request->getSession()->set('enviado',true);
                $this->get('email')->enviarEmailContacto($mensaje);

            }


			$em->persist ($mensaje);
			$em->flush ();


			$traductor = $this->get('translator');

			$this->get ('session')->getFlashBag()->set ('success', [
				'title'   => $traductor->trans ('flash.message.front.title'),
				'message' => $traductor->trans ('flash.message.front.message')
			]);


		}

		return $formulario->createView();
	}

    private function suscribirseNewsletter(Request $request)
    {

        $newsletter = new Newsletter();

        $formulario = $this->createForm ($this->get ('newsletter'), $newsletter);

        $formulario->handleRequest ($request);

        if (($formulario->isSubmitted ()) && ($formulario->isValid ()))
        {
            $em = $this->getDoctrine()->getManager();
            $newsletter->setEstado(true);

            $em->persist ($newsletter);
            $em->flush ();


            $traductor = $this->get('translator');

            $this->get ('session')->getFlashBag()->set ('success', [
                'title'   => $traductor->trans ('flash.newsletter.front.title'),
                'message' => $traductor->trans ('flash.newsletter.front.message')
            ]);


        }

        return $formulario->createView();
    }

    private function getSitemap()
    {
        $em = $this->getDoctrine()->getManager();
        $menus = $em->getRepository('DestinyAppBundle:Menus')->findAll();

        foreach($em->getRepository('DestinyAppBundle:Idiomas')->getAllLanguagesBackend() as $idioma)
        {
            foreach ($menus as $menu)
            {
                $urls[$idioma->getIsoCode()][$menu->getSlug()] = ['idioma' => $idioma,
                    'menu' => $menu,
                    'secciones' => $em->getRepository('DestinyAppBundle:Menus')->getMenuFrontend($menu->getSlug(),$idioma)
                ];

            }

        }

        return $urls;
    }

}
