<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLogin()
    {
        // Mock the object to be used in the test
        $client = static::createClient(array(), array(
			'PHP_AUTH_USER' => 'petjo@ovase.no',
			'PHP_AUTH_PW'   => '123456',
		));

        $crawler = $client->request('GET', '/login');

        $this->assertTrue($crawler->filter('html:contains("Brukernavn:")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Passord:")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Ny bruker?")')->count() > 0);

        $form = $crawler->selectButton('Logg inn')->form();

        // Change the value of a field
        $form['_username'] = 'petjo@ovase.no';
        $form['_password'] = '123456'; // submitted values

        // submit the form
        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());

        // Follow the redirect
        $crawler = $client->followRedirect();

        // Assert that the response status code is 2xx
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}
