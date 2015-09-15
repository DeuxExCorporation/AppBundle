<?php

namespace Destiny\AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InstalaccionControllerTest extends WebTestCase
{
    public function testDatosempresa()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testDatosempresacontacto()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/empresa-contacto');
    }

    public function testDatosempresaredessocial()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/empresa-redes-sociales');
    }

    public function testIdiomadefecto()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/idioma-defecto');
    }

    public function testCrearusuarioadmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'crear-usuario-admin');
    }

}
