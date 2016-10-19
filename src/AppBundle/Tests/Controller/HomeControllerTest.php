<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
	public function testHome()
	{
		$client = static::createClient();

		$crawler = $client->request('GET', '/');

		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$this->assertGreaterThan(0,$crawler->filter('html:contains("Ovase.no")')->count());
		$this->assertCount(5,$crawler->filter('h3'));
		$this->assertTrue($client->getResponse()->isSuccessful());
	}
}
