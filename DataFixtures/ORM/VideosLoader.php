<?php
namespace Argidomin\AppBundle\DataFixtures\ORM;


use Destiny\AppBundle\Entity\Videos;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\AbstractFixture;


class VideosLoader extends AbstractFixture implements  FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
		$urls = ['https://www.youtube.com/watch?v=mj6R6iWTR-E',
				 'https://www.youtube.com/watch?v=NXuNMEz8_9k',
				 'https://www.youtube.com/watch?v=VWkLH97mMdU',
			     'https://www.youtube.com/watch?v=Lq-hO0gGUjw'
		        ];
	    $i = 1;
	    foreach ($urls as $url)
	    {
		    $videos = new Videos();
		    $videos->setNombre('Video '.$i);
		    $videos->setUrl($url);
		    $videos->setAlt('Texto alternativo del video '.$i);
		    $videos->setDescripcion('Descripición del video '.$i);
		    $videos->setEstado(true);
		    $manager->persist($videos);
		    $i++;
	    }



        $manager->flush();
    }

    public function getOrder()
    {
        return 8; // the order in which fixtures will be loaded
    }
}