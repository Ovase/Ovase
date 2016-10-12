<?php

namespace AppBundle\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectListControllerTest extends WebTestCase
{
	public function testProjectList(){
		$client = static::createClient();
		$crawler = $client->request('GET', '/anlegg');
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$this->assertTrue($crawler->filter('title:contains("Anlegg")')->count() > 0);
	}
}