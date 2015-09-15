<?php
namespace Argidomin\AppBundle\DataFixtures\ORM;


use Destiny\AppBundle\Entity\Usuarios;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraints\True;

class UsuariosLoader extends AbstractFixture implements  FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
	private $container;

	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}
	public function load(ObjectManager $manager)
	{
		for ($i=0; $i<2; $i++)
		{
			$usuario = new Usuarios();

			$usuario->setUsername('usuario'.$i);

			$usuario->setEmail('usuario'.$i.'@localhost.dev');

			$encoder = $this->container->get('security.encoder_factory')
				->getEncoder($usuario);
			$usuario->setRoles(['ROLE_NORMALUSER']);

			$password = $encoder->encodePassword('pass'.$i, $usuario->getSalt());
			$usuario->setPassword($password);

			$manager->persist($usuario);
		}

		$usuarios = ['Gonzalo' => ['username' => 'Zalo-Sayayin',
			                       'password' => 'SoyUnaLenteja',
			                       'email'    => 'SoyUnaLenteja',],

					'Alba'     =>[ 'username' => 'AlbaDeAlba',
								   'password' => 'AlbaDeAlba',
						           'email'    => 'AlbaDeAlba'
								],

			        'Root'     =>[ 'username' => 'root',
				                   'password' => 'root',
				                   'email'    => 'carlos.sgude'
			                     ],
					];


		foreach ($usuarios as $datos)
		{
			$usuario = new Usuarios();

			$encoder = $this->container->get('security.encoder_factory')
				->getEncoder($usuario);

			$usuario->setUsername($datos['username']);
			$password = $encoder->encodePassword($datos['password'], $usuario->getSalt());
			$usuario->setPassword($password);
			$usuario->setEmail($datos['email'] .'@gmail.com');
			$usuario->setRoles(['ROLE_ROOT']);

			$usuario->setEnabled(true);
			$manager->persist($usuario);
		}



		$manager->flush();
	}

	public function getOrder()
	{
		return 4; // the order in which fixtures will be loaded
	}
}