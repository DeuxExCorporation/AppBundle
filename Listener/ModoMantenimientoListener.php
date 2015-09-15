<?php

namespace Destiny\AppBundle\Listener;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


/**
 * Class ModoMantenimientoListener
 * @package Destiny\AppBundle\Listener
 */
class ModoMantenimientoListener
{
    private $em, $twig, $userManager, $request;

    /**
     * @param EntityManager $entityManager
     * @param EngineInterface $twig
     * @param TokenStorage $userManager
     * @param RequestStack $request
     */
    public function __construct(EntityManager $entityManager, EngineInterface $twig, TokenStorage $userManager, RequestStack $request)
    {
        $this->em = $entityManager;
        $this->twig = $twig;
        $this->userManager = $userManager;
        $this->request = $request;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {

        $empresa = $this->em->getRepository('DestinyAppBundle:EmpresaWeb')->getEmpresaActiva();
        $usuario = $this->userManager->getToken();

        $ruta = $this->request->getCurrentRequest()->get('_route');

        if ((!is_null($empresa)) && ($empresa->getEstado() === false))
        {

            if ($ruta != "fos_user_security_login")
            {

                if (!(is_object($usuario)) || ($usuario->getUser() === "anon.") || ('ROLE_NORMALUSER' === $usuario->getRoles()[0]->getRole()))
                {
                    $plantilla = $this->twig->render('@DestinyApp/blockWebBase.html.twig',["empresa" => $empresa]);
                    $response = new Response($plantilla, 200);

                    $event->setResponse($response);
                }

            }
        }



    }
}
