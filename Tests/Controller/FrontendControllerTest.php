<?php

namespace Destiny\AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontendControllerTest extends WebTestCase
{
    public function testPortada()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

}
