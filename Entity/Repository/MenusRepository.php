<?php

namespace Destiny\AppBundle\Entity\Repository;

use Destiny\AppBundle\Entity\Idiomas;
use Doctrine\ORM\EntityRepository;

/**
 * MenusRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MenusRepository extends EntityRepository
{
	public function getMenuFrontend($menu, Idiomas $language)
	{
		$em = $this->getEntityManager ();

		$query = $em->createQueryBuilder ();

		if ($language->getDefecto() === false)
		{

		return $this->getMenuAlternativo($menu,$language);

		}
		$menu = $query->select(['m'])
			->from('DestinyAppBundle:Menus','m')
			->where($query->expr()->eq('m.estado',':estado'))
			->andWhere($query->expr()->eq('m.slug',':menu'))
			->setParameters([':menu'=> $menu,
				':estado' => true])

			->getQuery()->getOneOrNullResult()
			;

		return $menu->getSecciones()->getValues();
	}

	public function getMenuAlternativo($menu, Idiomas $language)
	{
		$em = $this->getEntityManager ();

		$query = $em->createQueryBuilder ();

		$menu = $query->select(['m','s','t'])
			->from('DestinyAppBundle:Menus','m')
			->innerJoin('m.secciones','s')
			->innerJoin('s.traducciones','t')
			->innerJoin('t.idioma','i')
			->where($query->expr()->eq('m.estado',':estado'))
			->andWhere($query->expr()->eq('m.slug',':menu'))
			->andWhere($query->expr()->eq('i.isoCode',':isoCode'))
			->setParameters([':menu'=> $menu,
				':isoCode' => $language->getIsoCode(),
				':estado' => true])

			->getQuery()->getOneOrNullResult()
		;

		$menuAlternativo = array();
        if (is_object($menu))
        {
            foreach ($menu->getSecciones()->getValues() as $seccion)
            {
                if ($seccion->getTraducciones()->count() > 0)
                {
                    foreach ($seccion->getTraducciones()->getValues() as $traduccion)
                    {
                        if ($traduccion->getIdioma()->getIsoCode() == $language->getIsoCode())
                        {

                            $menuAlternativo[] = $traduccion;
                        }
                    }
                }
            }
        }


		return $menuAlternativo;
	}
}
