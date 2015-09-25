<?php

namespace Destiny\AppBundle\Entity\Repository;

use Destiny\AppBundle\Entity\Idiomas;
use Doctrine\ORM\EntityRepository;

/**
 * NoticiasRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NoticiasRepository extends EntityRepository
{
	public function getAllFront(Idiomas $language)
	{
		$em = $this->getEntityManager();

		$query = $em->createQueryBuilder();

		if ($language->getDefecto() == FALSE)
		{
			$query->select(['n'])
						->from('DestinyAppBundle:NoticiasTraducciones','n')
						->innerJoin('n.canonica','c')
						->innerJoin('n.idioma','i')
						->where($query->expr()->eq('i.isoCode',':idioma'))
					    ->setParameters([':idioma' => $language->getSlug()])
						->getQuery()->getResult();
		}else{
			$query->select(['n'])
				->from('DestinyAppBundle:Noticias','n')
				->where($query->expr()->eq('n.estado',':estado'))
				->setParameters([':estado' => TRUE])
				->getQuery()->getResult();

		}


        $noticias['noticias'] = $query->getQuery()->getResult();
<<<<<<< HEAD
        $noticias['categorias'] = ($language->getDefecto() === true)
=======
        $noticias['categorias'] = ($language->getDefecto() == true)
>>>>>>> origin/master
                                    ? $em->getRepository('DestinyAppBundle:NoticiasCategorias')->findAll()
                                    : $em->getRepository('DestinyAppBundle:NoticiasCategorias')->getCategoriasIdioma($language);

		return $noticias;
	}

	public function findOneNewsByIsoCode($language, $news)
	{
		$em = $this->getEntityManager();

		$query = $em->createQueryBuilder();

		if ($language->getDefecto() == FALSE)
		{

			$noticiaTraducida =$query->select(['n'])
							         ->from('DestinyAppBundle:NoticiasTraducciones','n')
									 ->innerJoin('n.canonica','c')
									 ->innerJoin('n.idioma','i')
									 ->where($query->expr()->eq('i.isoCode',':language'))
									 ->andWhere($query->expr()->eq('c.slug',':news'))
									 ->setParameters([':language' => $language->getSlug(),':news' => $news])
									->getQuery()->getOneOrNullResult()
									;



			(!is_null($noticiaTraducida))
				?$noticiaTraducida->setContenidos($this->getAlterneContent($noticiaTraducida, $language))
				: NULL;

			return $noticiaTraducida;

		}else{
			return $query->select(['n'])
				->from('DestinyAppBundle:Noticias','n')
				->andWhere($query->expr()->eq('n.slug',':news'))
				->setParameters([':news' => $news])
				->getQuery()->getOneOrNullResult()
				;



		}




	}

	public function getAlterneContent($seccionTraducida, $language)
	{
		$contenido = array();
		foreach ($seccionTraducida->getCanonica()->getContenidos()->getValues() as $contenidoSeccion)
		{
			if (!is_null($contenidoSeccion->getEntity()))
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
