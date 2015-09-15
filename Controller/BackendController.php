<?php

namespace Destiny\AppBundle\Controller;


use Destiny\AppBundle\Entity\Idiomas;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\ParamConverterListener;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class BackendController
 * @package Destiny\AppBundle\Controller
 * @Route("backend")
 *
 */
class BackendController extends Controller
{


	/**
	 * @Route("/",name="portadaBackend")
	 */
	public function indexAction ()
	{
		$em = $this->getDoctrine()->getManager();

		return $this->render ('DestinyAppBundle:Backend:index.html.twig',
			[
				'cantCreate'  => null,
				'activeUsers' => $em->getRepository('DestinyAppBundle:Usuarios')->getActiveUsers(),
				'messages'    => $this->get('backend')->listElements('mensajes'),
				'group'       => false

			]);
	}

	/**
	 * @Route("/list/{entity}/",name="listBackend")
     * @Route("/list-content/{type}/{entity}",name="listContentBackend")
	 */
	public function listBackendAction ($entity, $type = null)
	{
        $backend = $this->get('backend');

        if (!is_null($type))
        {
            $element = $backend->getElements($type,'one',$entity);
            $list = $backend->getElements($type.'Contenido','content',$entity,$element->getSlug());
            $entity = $type .'Contenido';
        }


        $permiso = $this->get('backend')->checkPermisions('view',$this->get($entity)->newEntity());

         if (false === $permiso)  throw $this->createAccessDeniedException('Unauthorized access!');

        return $this->render ('DestinyAppBundle:Backend:list.html.twig',
            [
                'entity'       => $backend->removeContenidos($entity),
                'group'        => $backend->methodExist($this->get($entity),'groups',$entity),
                'listElements' => $backend->methodExist($this->get($entity),'listElements'),
                'cantCreate'   => $backend->methodExist($this->get($entity),'cantCreate',$entity),
                'cantDelete'   => $backend->methodExist($this->get($entity),'cantDelete',$entity),
                'listButton'   => $backend->methodExist($this->get($entity),'listButton',$entity),
                'list'         => isset($element) ? $list : $backend->listElements($entity),
                'section'      => isset($element) ? $element : null,
                'type'         => $type,

            ]);


	}


	/**
	 * @Route("/create/{entity}/{group}", name="createBackend")
     * @Route("/add-content/{type}/{group}/{entity}", name="createContentBackend")
	 */
	public function createBackendAction (Request $request, $entity ,$group = null, $type =null)
	{
        $element = null;
        $backend = $this->get('backend');

        if (!is_null($type))
        {
            $element = $backend->getElements($type,'one',$group);
            $entity = $entity .'Contenido';
            $list = $backend->getElements($type.'Contenido','content',$group);

        }

		$new = $this->get(strtolower($entity))->newEntity($group, $type);

        $permiso = $this->get('backend')->checkPermisions('create',$new);

        if (false === $permiso)  throw $this->createAccessDeniedException('Unauthorized access!');

		$formulario = $this->createForm ($this->get (strtolower ($entity)), $new);

		$formulario->handleRequest ($request);

		if (($formulario->isSubmitted ()) && ($formulario->isValid ()))
		{

            $backend->postCreate($new,$entity,$type,$element);
            $backend->processForm($new);


			$this->get ('session')->getFlashBag()->set ('success', [
				'title'   => $this->get('translator')->trans ('flash.edit.title'),
				'message' => $this->get('translator')->trans ('flash.edit.message', ['entidad' => $new])
			]);


            $url = (is_null($type))
                ? $this->generateUrl('editBackend', ['entity' => $entity,
                                                     'element'=> $new->getSlug(),])

                :$this->generateUrl('editContentBackend', ['type'=>$group,
                                                           'entity' => $type,
                                                           'element'=> $new->getSlug(),
                                                           'group' => $this->get('backend')->removeContenidos($entity)
                ]);


            return $this->redirect($url);

        }

		return $this->render ('DestinyAppBundle:Backend:editCreate.html.twig',
			[

                'group'        => $backend->methodExist($this->get($entity),'groups',$entity),
                'listElements' => $backend->methodExist($this->get($entity),'listElements'),
                'cantCreate'   => $backend->methodExist($this->get($entity),'cantCreate',$entity),
                'notList'      => $backend->methodExist($this->get($entity),'notList',$entity),
                'listButton'   => $backend->methodExist($this->get($entity),'listButton',$entity),
                'section'      => isset($element) ? $element : null,
                'entity'       => (is_null($type)) ? $entity : $type,
                'list'         => (is_null($type)) ? $backend->listElements($entity) : $list,
                'form'         => $formulario->createView (),
                'type'         => $type,

			]);


	}

    /**
     *
     * @Route("/edit/{entity}/{element}", name="editBackend")
     * @Route("/edit-content/{entity}/{type}/{group}/{element}/", name="editContentBackend")
     */
	public function editBackendAction (Request $request, $entity, $element,$group = null, $type =null)
	{

        $backend = $this->get('backend');
        $actual = (is_null($type)) ? $entity : $group;
        $edit = $backend->getElements($actual,'one',$element, $group);

		$formulario = $this->createForm ($this->get($actual),$edit,['read_only' => $backend->checkPermisions('edit',$edit)]);

        $backend->preEdit($edit, $actual, $formulario);

        $formulario->handleRequest($request);

		if (($formulario->isSubmitted ()) && ($formulario->isValid ()))
		{
            $backend->processForm($edit);
            $backend->postEdit($edit,$entity,$type,$element);
			$traductor = $this->get('translator');

			$this->get ('session')->getFlashBag()->set ('success', [
				'title'   => $traductor->trans ('flash.edit.title'),
				'message' => $traductor->trans ('flash.edit.message', ['entidad' => $edit])
			]);
		}

		return $this->render ('DestinyAppBundle:Backend:editCreate.html.twig',
			[
                'list'         => (!is_null($type))
                                    ?  $this->get('backend')->getElements($entity.'Contenido','content',$type)
                                    : $this->get('backend')->listElements($entity),
                'group'        => $backend->methodExist($this->get($entity),'groups',$entity),
                'listElements' => $backend->methodExist($this->get((is_null($type)) ? $entity : $entity .'Contenido'),'listElements'),
                'cantCreate'   => $backend->methodExist($this->get($entity),'cantCreate',$entity),
                'listButton'   => $backend->methodExist($this->get($entity),'listButton',$entity),
                'translatable' => (property_exists($this->get((is_null($type) ? $entity : $group)),'translatable')) ? true : false,
                'notBack'      => (property_exists($this->get ($entity), 'notBack')) ? True : false,
                'notList'      => (property_exists($this->get ($actual), 'notList')) ? True : false,
                'section'      => !is_null($type) ? $this->get('backend')->getElements($entity,'one',$type) : null,
                'type'         => $type,
                'entity'       => $this->get('backend')->removeContenidos($entity),
                'form'         => $formulario->createView(),
			]);
	}

	/**
	 * @Route("/delete/{entity}/{element}",name="deleteBackend")
     * @Route("/delete-content/{entity}/{type}/{group}/{element}/", name="deleteContentBackend")
	 */
	public function deleteBackendAction(Request $request, $entity, $element,$group = null, $type =null)
	{
        $actual = (is_null($type)) ? $entity : $entity.'Contenido';
		$delete = (!is_null($type))
            ? $this->get('backend')->getElements($actual,'one',$element,$type)
            : $this->get('backend')->getElements($actual,'one',$element);

        $permiso = $this->get('backend')->checkPermisions('create',$delete);

        if (false === $permiso)  throw $this->createAccessDeniedException('Unauthorized access!');

        if ($this->get('backend')->isDeleteable($actual,$delete))
        {
            $this->get('backend')->deleteElementAndFile($delete,$actual);

        } else {

            $traductor = $this->get ('translator');

            $this->get ('session')->getFlashBag ()->set ('danger', [
                'title' => $traductor->trans ('flash.cantDelete.title'),
                'message' => $traductor->trans ('flash.cantDelete.message', ['entidad' => $delete])
            ]);
        }


		return $this->redirect($request->headers->get('referer'));

	}

	/**
	 * @Route("/change-status/{entity}/{element}/",name="changeStatusBackend")
	 * @Route("/change-status-content/{entity}/{type}/{group}/{element}/",name="changeStatusContentBackend")
	 */
	public function changeStatusBackendAction (Request $request,$entity, $element, $type = null, $group = null)
	{


        $change = (!is_null($type))
                    ? $this->get('backend')->getElements($entity.'Contenido','one',$element,$type)
                    : $this->get('backend')->getElements($entity,'one',$element);

		if ((NULL != $change) && ($this->get ($entity)->isChangeable ($change) == TRUE))
		{

            $this->get('backend')->changeEstatus($change,$entity);

		} else {

			$traductor = $this->get ('translator');

			$this->get ('session')->getFlashBag ()->set ('danger', [
				'title'   => $traductor->trans ('flash.notChangable.title'),
				'message' => $traductor->trans ('flash.notChangable.message', ['entidad' => $change])
			]);
		}

		return $this->redirect($request->headers->get('referer'));

	}


	/**
	 * @Route("/change-position/{entity}/{element}/{position}",name="changePositionBackend")
     * @Route("/change-position-content/{entity}/{type}/{group}/{element}/{position}",name="changeContentPositionBackend")
	 */
	public function changePositionBackendAction (Request $request, $entity, $element, $position, $type = null, $group = null)
	{

        $this->get('backend')->changePosition($entity,$element , $position,$type);

		return $this->redirect($request->headers->get('referer'));

	}

	/**
	 * @Route("/edit-translation/{language}/{entity}/{element}", name="editTraduccionWeb")
	 * @Route("/edit-translation-content/{language}/{entity}/{type}/{group}/{element}/", name="editContentTraduccionWeb")
     *
	 * @ParamConverter("language", class="DestinyAppBundle:Idiomas",
	 * options={"language" = "isoCode", "repository_method" = "findOneByIsoCode"})
	 */
	public function createEditTraduccionAction(Request $request, $entity, $element,Idiomas $language, $type = null, $group = null)
	{
        $backend = $this->get('backend');
        $edit = $backend->getTranslations((!is_null($type)) ? $group : $entity,$element,$language);

        $editable = $backend->checkPermisions('edit',$edit);

		$formulario = $this->createForm ($this->get((is_null($group))
                                                    ? $entity.'-traducciones'
                                                    : $group.'-traducciones'), $edit,['read_only' => $editable]);

		$formulario->handleRequest($request);


		if (($formulario->isSubmitted ()) && ($formulario->isValid ()))
		{

            $this->get('backend')->processForm($edit,$entity);

			$traductor = $this->get('translator');

			$this->get ('session')->getFlashBag()->set ('success', [
				'title'   => $traductor->trans ('flash.traslation.title'),
				'message' => $traductor->trans ('flash.traslation.message', ['entidad' => $edit])
			]);
		}

        $actual = (!is_null($type)) ? $group : $entity;

		return $this->render ('DestinyAppBundle:Backend:editCreate.html.twig',
			[
                'list'         => (!is_null($type))
                                    ?  $this->get('backend')->getElements($entity.'Contenido','content',$type)
                                    : $this->get('backend')->listElements($entity),
                'group'        => $backend->methodExist($this->get($entity),'groups',$entity),
                'listElements' => $backend->methodExist($this->get((is_null($type)) ? $entity : $entity .'Contenido'),'listElements'),
                'cantCreate'   => $backend->methodExist($this->get($entity),'cantCreate',$entity),
                'listButton'   => $backend->methodExist($this->get($entity),'listButton',$entity),
				'notList'      => (property_exists($this->get ($actual), 'notList')) ? True : false,
                'section'      => !is_null($type) ? $this->get('backend')->getElements($entity,'one',$type) : null,
                'translatable' => true,
                'type'         => $type,
                'language'     => $language,
                'entity'       => $entity,
                'form'         => $formulario->createView(),
			]);

	}



}
