<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 06/04/2015
 * Time: 12:52
 */
namespace Destiny\AppBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;

class DatosEmpresaService
{
	protected $entityManager, $container;
	public $web, $contacto, $redesSociales;

	public function __construct (EntityManager $entityManager,Container $container)
	{
		$this->entityManager = $entityManager;
		$this->container = $container;
		$this->web = $this->getEmpresa();
		$this->redesSociales = $this->getRedesSociales();
		$this->contacto = $this->getContacto();
	}

	private function getEmpresa()
	{

		return $this->entityManager->getRepository('DestinyAppBundle:EmpresaWeb')->getEmpresaActiva();
	}

	private function getRedesSociales()
	{
		$redes = $this->entityManager->getRepository('DestinyAppBundle:EmpresaRedesSociales')->findAll();

		return $redes;
	}

	private function getContacto()
	{
		$contacto = $this->entityManager->getRepository('DestinyAppBundle:EmpresaContacto')->getOne();

		return $contacto;
	}




}