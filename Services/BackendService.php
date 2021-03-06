<?php
namespace Destiny\AppBundle\Services;



use Destiny\AppBundle\Entity\Idiomas;
use Doctrine\ORM\EntityManager;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Filesystem\Filesystem;

use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;


class BackendService
{

	protected $em, $security, $container, $translator, $user, $sesion, $cheker;


    public function __construct (EntityManager $EntityManager, Container $container, Translator $translator, TokenStorage $user, Session $session, AuthorizationChecker $checker)

	{
		$this->em         = $EntityManager;
        $this->security   = $container->get('security.authorization_checker');
        $this->container  = $container;
        $this->translator = $translator;
        $this->user       = $user;
        $this->sesion     = $session;
        $this->cheker     = $checker;

	}

	public function getMenu($zona = null)
	{
		$menu = (is_null($zona))
            ? $this->em->getRepository('DestinyAppBundle:BackendSecciones')
                    ->getActiveMenusBackend($this->user->getToken()->getUser())
            : $this->em->getRepository('DestinyAppBundle:BackendSecciones')
                    ->getActiveMenusBackendSuperior();

        return $menu;
	}

    public function checkPermisions($metodo, $entidad, $usuario = null)
    {
        return $this->security->isGranted($metodo,$entidad,$usuario);
    }

    public function listElements ($entity,$element =null)
    {


        if (method_exists ($this->container->get($entity), 'groups'))
        {
            foreach ($this->container->get($entity)->groups() as $group)
            {
                $group = (is_object($group)) ? $group->getSlug() : $group['nombre'];
                $list[$group] = $this->getElements ($entity, 'group',$element, $group);
            }

        }else{

            $list = $this->getElements ($entity,$element);

        }



        return $list;
    }
    public function existClass($entity)
    {
        foreach($this->em->getRepository('DestinyAppBundle:BundlesActivos')->findAll() as $bundle)
        {
            if (class_exists('Destiny\\'.$bundle.'\\Entity\\' .ucfirst($entity)))
            {
                return 'Destiny'.$bundle.':' .ucfirst($entity);
            }
        }

    }

    public function getElements ($entity, $typeList = 'list',$element =null, $group = null)
    {
        $repository = $this->em->getRepository ($this->existClass($entity));

        $orden =  ($this->sesion->get('order-by')['entidad'] === $entity)
                        ?  $this->sesion->get('order-by') : ['order' => 'nombre', 'asc' => 'ASC'];

        switch ($typeList) {

            case ($typeList === 'list'):


                $lista =  (method_exists ($repository, 'getAll'))
                            ? $repository->getAll ($element, $this->user->getToken(),$this->cheker ,$orden)
                            : $repository->findBy ([],[$orden['order'] => $orden['asc']]);


                return $lista;

                break;

           case ($typeList === 'one'):

                return (method_exists ($repository, 'getOne'))
                    ? $repository->getOne ($element, $group)
                    : $repository->findOneBySlug ($element);
                break;

           case ($typeList === 'group'):
                return $repository->getAllByGroup ($group,$orden);
                break;

           case ($typeList === 'content'):

                return $repository->getContent ($element);
                break;
        }


    }

    public function getTranslations($entity,$element,Idiomas $language)
    {

        $repository = $this->em->getRepository ('DestinyAppBundle:' . ucfirst ($entity).'Traducciones');

        $edit = $repository->getTranslation ($element,$language->getIsoCode());

        if (is_null($edit))
        {
            $edit = $this->container->get($entity.'-traducciones')->newEntity();

            $canonica = $this->getElements($entity,'one',$element);

            $edit->setCanonica($canonica);
            $edit->setIdioma($language);
        }


        return $edit;
    }

    public function preEdit($entidad, $serivicio, $formulario)
    {
        $this->methodExist($this->container->get($serivicio),'preEdit',$entidad);

        (method_exists($entidad,'upload'))
            ? $formulario->add('archivo','file',
            ['required' => FALSE,'label'=> $this->translator->trans($serivicio.'.form.file')])
            : null;


        (property_exists($entidad,'plainPassword'))
            ? $formulario->add('plainPassword','password',
            ['required' => FALSE,'label'=> $this->translator->trans($serivicio.'.form.password')])
            : null;
    }

    public function postCreate($entidad,$serivicio,$tipo,$seccion)
    {

        (method_exists ($this->container->get($serivicio), 'postCreate'))
            ? $this->container->get($serivicio)->postCreate($entidad,$seccion,$tipo) : null;
    }

    public function postEdit($entidad,$serivicio,$tipo,$seccion)
    {
        (method_exists ($this->container->get($serivicio), 'postEdit'))
            ? $this->container->get($serivicio)->postEdit($entidad,$seccion,$tipo) : null;
    }

    public function postChange($entidad,$serivicio,$tipo,$seccion)
    {

        (method_exists ($this->container->get($serivicio), 'postChange'))
            ? $this->container->get($serivicio)->postChange($entidad,$seccion,$tipo) : null;
    }

    public function processForm($entidad)
    {
        $this->methodExist($entidad,'upload');
        $this->em->persist($entidad);
        $this->em->flush();
    }

    public function deleteElementAndFile($delete,$entidad)
    {
        $this->methodExist($this->container->get($entidad),'postDelete',$delete);

        $this->em->remove ($delete);
        $this->em->flush ();

        $fs = new Filesystem();

        //En el caso de que la emtidad tenga una imagen, la elimina.
        ((method_exists ($delete, 'getWebPath')) and ($fs->exists ($delete->getWebPath ())))
            ? $fs->remove ($delete->getWebPath ())
            : null;


        $this->container->get ('session')->getFlashBag ()->set ('success', [
            'title'   => $this->translator->trans ('flash.delete.title'),
            'message' => $this->translator->trans ('flash.delete.message', ['entidad' => $delete])
        ]);
    }

    public function changeEstatus($entidad,$servicio)
    {
        $status = ($entidad->getEstado () === TRUE) ? FALSE : TRUE;
        $entidad->setEstado ($status);

        $this->em->persist ($entidad);
        $this->em->flush ();

        $this->methodExist($servicio,'postChange',$entidad);

        $this->container->get('session')->getFlashBag ()->set ('success', [
            'title'   => $this->translator->trans ('flash.change.title'),
            'message' => $this->translator->trans ('flash.change.message', ['entidad' => $entidad])
        ]);
    }

    public function changePosition($entidad,$antigua,$posicion,$tipo)
    {
        $entidadActual = (!is_null($tipo)) ? $entidad.'Contenido' : $entidad;
        $antigua = (!is_null($tipo))
                        ? $this->getElements($entidad.'Contenido','one',$antigua,$tipo)
                        : $this->getElements($entidad,'one',$antigua);

        $nueva = $this->em->getRepository ($this->existClass($entidadActual))->getChangePosition($antigua,$posicion);

        $nueva->setPosicion($antigua->getPosicion());

        $antigua->setPosicion($posicion);

        $this->em->persist ($antigua);
        $this->em->persist ($nueva);

        $this->em->flush ();

        $traductor = $this->translator;
        $this->container->get ('session')->getFlashBag ()->set ('success', [
            'title'   => $traductor->trans ('flash.changePosition.title'),
            'message' => $traductor->trans ('flash.changePosition.message', ['entidad' => $antigua])
        ]);
    }

    public function isDeletable($entidad,$delete)
    {

        return   $this->methodExist($this->container->get($entidad),'isDeletable',$delete);
    }

    public function removeContenidos($entity)
    {
        if (strstr($entity,'Contenido') )
        {
            $entity = explode('Contenido',$entity);
            $entity = $entity[0];
        }

        return $entity;
    }

    public function methodExist($class,$metodo,$variable = null)
    {

        return (method_exists($class,$metodo)) ? $class->$metodo($variable) : null;
    }


}
