<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 06/04/2015
 * Time: 12:52
 */
namespace Destiny\AppBundle\Services;


use Doctrine\ORM\EntityManager;


class DatosEmpresaService
{
	protected $entityManager;
	public $web, $contacto, $redesSociales;

	public function __construct (EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
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

    public function getPlantilla()
    {
        return $this->getEmpresa()->getPlantilla();
    }




}
