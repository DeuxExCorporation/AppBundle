<?php

namespace Destiny\AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * IdiomasRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IdiomasRepository extends EntityRepository
{
	public function findOneBySlug($idioma)
	{
		$em = $this->getEntityManager();

		$query = $em->createQueryBuilder();

		return $query->select(['i'])
			->from('DestinyAppBundle:Idiomas', 'i')
			->where($query->expr()->eq('i.isoCode',':idioma'))
			->setParameters(['idioma' => $idioma])
			->getQuery()->getOneOrNullResult();
	}

	public function getAllLanguagesBackend()
	{
		$em = $this->getEntityManager();

		$query = $em->createQueryBuilder();

		return $query->select(['i'])
			->from('DestinyAppBundle:Idiomas', 'i')
			->orderBy('i.defecto','DESC')
			->getQuery()->getResult();

	}

	public function getLanguageDefault()
	{
		$em = $this->getEntityManager();

		$query = $em->createQueryBuilder();

		return $query->select(['i'])
			->from('DestinyAppBundle:Idiomas', 'i')
			->where($query->expr()->eq('i.defecto',':idioma'))
			->setParameters(['idioma' => true])
			->getQuery()->getOneOrNullResult();
	}


}
