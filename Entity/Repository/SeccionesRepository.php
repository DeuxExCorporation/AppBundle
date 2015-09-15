<?php

namespace Destiny\AppBundle\Entity\Repository;

use Destiny\AppBundle\Entity\Idiomas;
use Destiny\AppBundle\Entity\SeccionesTraducciones;
use Doctrine\ORM\EntityRepository;

/**
 * SeccionesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SeccionesRepository extends EntityRepository
{
	public function getAllByGroup($group)
	{

		$em = $this->getEntityManager ();

		$query = $em->createQueryBuilder ();

		return $query->select(['s','m','t'])
			->from('DestinyAppBundle:Secciones','s')
			->innerJoin('s.menu','m')
			->innerJoin('s.tipo','t')
			->where($query->expr()->eq('m.slug',':menu'))
			->andWhere($query->expr()->isNull('s.padre'))
			->setParameters([':menu' => $group,])
			->orderBy('s.posicion')
			->getQuery()->getResult();


	}


	public function getChangePosition($seccion,$position)
	{

		$em = $this->getEntityManager ();
		$query = $em->createQueryBuilder();

		return $query->select(['s','m'])
			->from('DestinyAppBundle:Secciones','s')
			->innerJoin('s.menu','m')
			->where($query->expr()->eq('m.slug',':menu'))
			->andWhere($query->expr()->eq('s.posicion',':posicion'))
			->setParameters([':menu'     => $seccion->getMenu()->getSlug(),
						     ':posicion' => $position])
			->getQuery()->getOneOrNullResult();
	}

	public function getSeccionesBackend($menu)
	{
		$em = $this->getEntityManager ();

		$query = $em->createQueryBuilder ();

		return $query->select(['s','m'])
			->from('DestinyAppBundle:Secciones','s')
			->innerJoin('s.menu','m')
			->where($query->expr()->eq('m.slug',':menu'))
			->andWhere($query->expr()->isNull('s.padre'))
			->setParameters([':menu' => $menu])
			->orderBy('s.posicion')
			->getQuery()->getResult();
	}

	public function getPortada(Idiomas $language)
	{
		$em = $this->getEntityManager ();

		$query = $em->createQueryBuilder ();

		if ($language->getDefecto() == false)
		{
			return $this->getseccionPortadaTraducida($language);
		}

		return $query->select(['s','m','t'])
						->from('DestinyAppBundle:Secciones','s')
						->innerJoin('s.menu','m')
						->innerJoin('s.tipo','t')
						->andWhere($query->expr()->eq('s.portada',':portada'))
						->setParameters([':portada' => true])
						->getQuery()->getOneOrNullResult();


	}

	public function getSectionFront($section,Idiomas $language)
	{
		$em = $this->getEntityManager ();
		$query = $em->createQueryBuilder ();

		if ($language->getDefecto() == false)
		{
			return $this->getSeccionTraducida($section, $language);
		}

		return $query->select(['s'])
			->from('DestinyAppBundle:Secciones','s')
			->where($query->expr()->eq('s.url',':seccion'))
			->setParameters([':seccion' => $section])
			->getQuery()->getOneOrNullResult();


	}

	public function getseccionPortadaTraducida(Idiomas $language)
	{
		$em = $this->getEntityManager ();
		$query = $em->createQueryBuilder();

		$seccionTraducida = $query->select(['s','c','i'])
								->from('DestinyAppBundle:SeccionesTraducciones','s')
								->innerJoin('s.canonica','c')
								->innerJoin('s.idioma','i')
								->where($query->expr()->eq('i.isoCode',':idioma'))
								->andWhere($query->expr()->eq('c.portada',':portada'))
								->setParameters([':portada' => true,':idioma' => $language->getIsoCode()])
								->getQuery()->getOneOrNullResult();



		($seccionTraducida != null)
			?$seccionTraducida->setContenidos($this->getAlterneContent($seccionTraducida, $language))
			: NULL;

		return $seccionTraducida;
	}

	public function getSeccionTraducida( $section,Idiomas $language)
	{
		$em = $this->getEntityManager ();
		$query = $em->createQueryBuilder();

		$seccionTraducida =  $query->select(['s','i'])
									->from('DestinyAppBundle:SeccionesTraducciones','s')
									->innerJoin('s.idioma','i')
									->where($query->expr()->eq('s.url',':seccion'))
									->andWhere($query->expr()->eq('i.isoCode',':idioma'))
									->setParameters([':seccion' => $section,
													 ':idioma' => $language->getIsoCode()])
									->getQuery()->getOneOrNullResult();

		($seccionTraducida != null)
			?$seccionTraducida->setContenidos($this->getAlterneContent($seccionTraducida, $language))
			: NULL;

		 return $seccionTraducida;
	}

	public function getAlterneContent($seccionTraducida, $language)
	{
		$contenido = array();
		foreach ($seccionTraducida->getCanonica()->getContenidos()->getValues() as $contenidoSeccion)
		{
			if ($contenidoSeccion->getEntity() != null)
			{
				foreach ($contenidoSeccion->getEntity()->getTraducciones() as $traduccion)
				{
					if ($traduccion->getIdioma()->getIsoCode() == $language->getIsoCode())
					{
						$contenido[] = $traduccion;
					}
				}
			}
		}



		return $contenido;

	}

}
