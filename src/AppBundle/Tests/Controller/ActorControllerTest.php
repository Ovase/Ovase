<?php

namespace AppBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ActorControllerTest extends WebTestCase
{
    public function testCreateCompany()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/actor');
        $links = $crawler
            ->filter('a:contains("Lag company")');
        $this->assertEquals(1, $links->count());

        $link = $links
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals(210, $client->getResponse()->getStatusCode());
        $crawler->selectButton();
    }
}