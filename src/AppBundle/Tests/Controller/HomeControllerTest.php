<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
	public function testHome()
	{
		$client = static::createClient();

		$crawler = $client->request('GET', '/');

		// Add a couple of html source code checks
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0,$crawler->filter('html:contains("OVASE")')->count());
        $this->assertGreaterThan(0,$crawler->filter('a:contains("PROSJEKTER")')->count());
        $this->assertGreaterThan(0,$crawler->filter('a:contains("AKTØRER")')->count());
        $this->assertGreaterThan(0,$crawler->filter('a:contains("FAGWIKI")')->count());
        $this->assertGreaterThan(0,$crawler->filter('a:contains("Logg inn")')->count());
		// This one actually matters
        $this->assertTrue($client->getResponse()->isSuccessful());
	}
}
