<?php

namespace Destiny\AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BackendControllerTest extends WebTestCase
{
	public function testLogin()
	{
		$client = static::createClient();

		$crawler = $client->request('GET', '/login');

		$form = $crawler->selectButton('submit')->form();

		$form['username'] = 'root';
		$form['password'] = 'root';

		$crawler = $client->submit($form);
		$client->followRedirects();


		$this->assertGreaterThan(
			0,
			$crawler->filter('html:contains("Destiny Dashboard")')->count()
		);

	}
}
