<?php

namespace AppBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ActorControllerTest extends WebTestCase
{
    function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

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
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('company[save]')->form();
        $name = $this->generateRandomString(10);
        $form['company[name]'] = $name;
        $form['company[email]'] = "{$this->generateRandomString(10)}@{$this->generateRandomString(10)}.com";
        $form['company[type]'] = $this->generateRandomString(10);
        $form['company[org_nr]'] = $this->generateRandomString(10);
        $crawler = $client->submit($form);

        $crawler = $client->followRedirect();
        $this->assertContains($name, $client->getResponse()->getContent());
    }


    public function testCreatePerson()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/actor');
        $links = $crawler
            ->filter('a:contains("Lag person")');
        $this->assertEquals(1, $links->count());

        $link = $links
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('person[save]')->form();
        $name = $this->generateRandomString(10);
        $form['person[firstName]'] = $name;
        $form['person[lastName]'] = $this->generateRandomString(20);
        $form['person[email]'] = "{$this->generateRandomString(10)}@{$this->generateRandomString(10)}.com";
        $crawler = $client->submit($form);

        $crawler = $client->followRedirect();
        $this->assertContains($name, $client->getResponse()->getContent());
    }
}