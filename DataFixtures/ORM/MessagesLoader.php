<?php
namespace Argidomin\AppBundle\DataFixtures\ORM;

use Destiny\AppBundle\Entity\Idiomas;
use Destiny\AppBundle\Entity\Mensajes;
use Destiny\AppBundle\Entity\Newsletter;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\Validator\Constraints\True;

class MessagesLoader extends AbstractFixture implements  FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

	    for ($i=0;$i<=rand(3,10);$i++)
	    {
		    $mensaje = new Mensajes();

		    $mensaje->setEmail('user'.$i.'@localhost.dev');
		    $mensaje->setEstado(false);
		    $mensaje->setAsunto('Asunto '.$i);
		    $mensaje->setCuerpo('Cuerpo '.$i);

		    $manager->persist($mensaje);
	    }



        $manager->flush();
    }

    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}