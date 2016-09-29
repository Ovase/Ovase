<?php

namespace AppBundle\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectListControllerTest extends WebTestCase
{
    public function testProjectList(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/anlegg');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1,$crawler->filter('input[type=search]')->count());
        $this->assertEquals(1,$crawler->filter('title')->first());
    }
}