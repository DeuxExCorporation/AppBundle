<?php

namespace Destiny\AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MensajesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MensajesRepository extends EntityRepository
{
	public function getMensajesSinLeer()
	{
		$em = $this->getEntityManager();

		$query = $em->createQueryBuilder();

		return $query->select(['m'])
			->from('DestinyAppBundle:Mensajes', 'm')
			->where($query->expr()->eq('m.estado',':estado'))
			->setParameters(['estado' => false])
			->getQuery()->getResult();
	}

    public function getAll()
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder();

        return $query->select(['m'])
            ->from('DestinyAppBundle:Mensajes', 'm')
            ->getQuery()->getResult();
    }


}
