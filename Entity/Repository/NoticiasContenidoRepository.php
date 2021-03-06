<?php

namespace Destiny\AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * NoticiasContenidoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NoticiasContenidoRepository extends EntityRepository
{
	public function getContent($seccion)
	{
		$em = $this->getEntityManager();

		$query = $em->createQueryBuilder();

		return $query->select(['sc','s'])
			->from('DestinyAppBundle:NoticiasContenido', 'sc')
			->innerJoin('sc.seccion','s')

			->where($query->expr()->eq('s.slug',':seccion'))
			->setParameters([':seccion' => $seccion])
			->getQuery()->getResult();
	}

	public function getOne($slug,$id,$elementType)
	{


		$em = $this->getEntityManager ();

		$query = $em->createQueryBuilder ();

		switch($elementType[0]){
			case ($elementType === 'imagenes'):

				return $query->select(['i'])
					->from('DestinyAppBundle:Imagenes', 'i')
					->andWhere($query->expr()->eq('i.slug',':slug'))
					->setParameters([':slug'   => $slug])
					->getQuery()->getOneOrNullResult();
				break;

			case ($elementType === 'videos'):
				return $query->select(['i'])
					->from('DestinyAppBundle:Videos', 'i')
					->andWhere($query->expr()->eq('i.slug',':slug'))
					->setParameters([':slug'   => $slug])
					->getQuery()->getOneOrNullResult();
				break;

			case ($elementType === 'sliders'):
				return $query->select(['i'])
					->from('DestinyAppBundle:Sliders', 'i')
					->andWhere($query->expr()->eq('i.slug',':slug'))
					->setParameters([':slug'   => $slug])
					->getQuery()->getOneOrNullResult();
				break;

			case ($elementType === 'adjuntos'):
				return $query->select(['i'])
					->from('DestinyAppBundle:Adjuntos', 'i')
					->andWhere($query->expr()->eq('i.slug',':slug'))
					->setParameters([':slug'   => $slug])
					->getQuery()->getOneOrNullResult();
				break;

			case ($elementType === 'articulos'):

				return $query->select(['sc'])
					->from('DestinyAppBundle:Articulos', 'sc')
					->andWhere($query->expr()->eq('sc.slug',':slug'))
					->setParameters([':slug' => $slug])
					->getQuery()->getOneOrNullResult();
				break;
		}




	}

	public function getChangePosition($contenido,$position)
	{

		$em = $this->getEntityManager ();

		if (method_exists($contenido,'getType') && $contenido->getType() === 'articulos')
		{
			$query = $em->createQueryBuilder();
			$contenido = $query->select(['sc','a'])
				->from('DestinyAppBundle:NoticiasContenido','sc')
				->innerJoin('sc.articulos','a')
				->where($query->expr()->eq('a.id',':idArticulo'))
				->setParameters([':idArticulo' => $contenido->getId()])
				->getQuery()->getOneOrNullResult();
		}

		$query = $em->createQueryBuilder();

		return $query->select(['sc','s'])
			->from('DestinyAppBundle:NoticiasContenido','sc')
			->innerJoin('sc.seccion','s')
			->where($query->expr()->eq('s.id',':contenido'))
			->andWhere($query->expr()->eq('sc.posicion',':posicion'))
			->setParameters([':contenido'     => $contenido->getSeccion()->getId(),
				':posicion' => $position])
			->getQuery()->getOneOrNullResult();
	}

	public function getAll()
	{
		$em = $this->getEntityManager ();

		$query = $em->createQueryBuilder ();

		return $query->select(['sc'])
			->from('DestinyAppBundle:NoticiasContenido','sc')
			->orderBy('sc.posicion')
			->getQuery()->getResult();
	}
}
