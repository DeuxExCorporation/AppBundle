<?php
namespace Argidomin\AppBundle\DataFixtures\ORM;

use Destiny\AppBundle\Entity\Idiomas;
use Destiny\AppBundle\Entity\Newsletter;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\Validator\Constraints\True;

class NewsletterLoader extends AbstractFixture implements  FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

	    for ($i=0;$i<=rand(3,10);$i++)
	    {
		    $newsletter = new Newsletter();

		    $newsletter->setEmail('user'.$i.'@localhost.dev');
		    $newsletter->setEstado(true);

		    $manager->persist($newsletter);
	    }



        $manager->flush();
    }

    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}