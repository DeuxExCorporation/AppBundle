<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 06/04/2015
 * Time: 12:52
 */
namespace Destiny\AppBundle\Services;


use Destiny\AppBundle\Entity\Idiomas;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;

class PlantillaService
{
	protected $entityManager, $container;


	public function __construct (EntityManager $entityManager,Container $container)
	{
		$this->entityManager = $entityManager;
		$this->container = $container;

	}

	public function getMenu($menu ='portada',Idiomas $language)
	{

		$menu = $this->entityManager->getRepository('DestinyAppBundle:Menus')->getMenuFrontend($menu, $language);


		return $menu;


	}

	public function getIdiomas()
	{
		return $this->entityManager->getRepository('DestinyAppBundle:Idiomas')->getAllLanguagesBackend();
	}

    public function getIdiomaDefecto()
    {
        return $this->entityManager->getRepository('DestinyAppBundle:Idiomas')->getLanguageDefault();
    }






}