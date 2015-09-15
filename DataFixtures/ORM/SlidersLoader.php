<?php
namespace Argidomin\AppBundle\DataFixtures\ORM;

use Destiny\AppBundle\Entity\Idiomas;
use Destiny\AppBundle\Entity\Mensajes;
use Destiny\AppBundle\Entity\Newsletter;
use Destiny\AppBundle\Entity\Sliders;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\Validator\Constraints\True;

class SliderLoader extends AbstractFixture implements  FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

	    for ($i=0;$i<=rand(3,10);$i++)
	    {
		    $slider = new Sliders();

		    $slider->setNombre('Slider '.$i);
		    $slider->setDescripcion('Descripición del Slider '.$i);


		    $slider->setEstado(true);

		    $manager->persist($slider);
	    }



        $manager->flush();
    }

    public function getOrder()
    {
        return 10; // the order in which fixtures will be loaded
    }
}