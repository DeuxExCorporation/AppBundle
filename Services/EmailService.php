<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 06/04/2015
 * Time: 12:52
 */
namespace Destiny\AppBundle\Services;


use Destiny\AppBundle\Entity\EmpresaContacto;
use Destiny\AppBundle\Entity\EmpresaWeb;
use Destiny\AppBundle\Entity\Mensajes;
use Destiny\AppBundle\Entity\Usuarios;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\Container;
use Trt\SwiftCssInlinerBundle\Plugin\CssInlinerPlugin;

/**
 * Class EmailService
 * @package Destiny\AppBundle\Services
 *
 */

class EmailService
{
	protected $twig, $mailer, $entityManager, $container, $email, $empresa;

	public function __construct (\Swift_Mailer $mailer,
	                             EngineInterface $templating,
	                             EntityManager $entityManager,
	                             Container $container)
	{
		$this->mailer = $mailer;
		$this->twig = $templating;
		$this->entityManager = $entityManager;
		$this->container = $container;
		$this->email = $this->entityManager->getRepository('DestinyAppBundle:EmpresaEmails')->getOne();
        $this->empresa = $this->entityManager->getRepository('DestinyAppBundle:EmpresaWeb')->getEmpresaActiva();
	}

	/**
	 * @param $message
	 *
	 */
	public function enviarEmailContacto (Mensajes $message)
	{

		$email = \Swift_Message::newInstance ()
			->setSubject ('Contacto')
            ->setFrom([$this->empresa->getEmail()=> $this->empresa->getNombre()])
			->setTo ($message->getEmail ())
			->setBody ($this->twig
				->render ('DestinyAppBundle:Email:contacto.html.twig',
										['email' => $this->email,
										 'message' => $message]),'text/html');

        $email->getHeaders()->addTextHeader(CssInlinerPlugin::CSS_HEADER_KEY_AUTODETECT);


        $this->mailer->send ($email);

	}

	public function enviarEmailUsuario ($metodo,Usuarios $usuario)
	{
		$email = $this->entityManager
						->getRepository('DestinyAppBundle:UsuariosEmails')
						->findOneBySlug($metodo);

		$email = \Swift_Message::newInstance ()
				->setSubject ($email->getAsunto())
				->setTo ($usuario->getEmail ())
				->setFrom([$this->empresa->getEmail()=> $this->empresa->getNombre()])
				->setBody ($this->twig->render ('DestinyAppBundle:Email:usuario.html.twig',
						['email' => $this->email,
						 'cuerpo' => $email,
						 'usuario' => $usuario,
						 'metodo' => $metodo]),'text/html');

		$email->getHeaders()->addTextHeader(CssInlinerPlugin::CSS_HEADER_KEY_AUTODETECT);

		$this->mailer->send ($email);

	}

	public function enviarEmailInstalacion (EmpresaWeb $empresa, Usuarios $usuario, $contacto, $redes)
	{

		$email = \Swift_Message::newInstance ()
			->setSubject ('Instalacion completada')
			->setTo ($usuario->getEmail (),$empresa->getEmail())
			->setFrom([$empresa->getEmail()=> $empresa->getNombre()])
			->setBody ($this->twig
				->render ('DestinyAppBundle:Email:instalacion.html.twig',
					['usuario' => $usuario,
						'empresa' => $empresa,
						'contacto' => $contacto,
						'redes' => $redes
					]),'text/html');
		$email->getHeaders()->addTextHeader(CssInlinerPlugin::CSS_HEADER_KEY_AUTODETECT);

		$this->mailer->send ($email);
	}


}
