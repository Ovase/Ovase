<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\NoResultException;
use AppBundle\Form\UserType;

class UserControllerTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
    }

    public function testRegister()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //$this->assertEquals(1, $crawler->filter('h1:contains("Registrer bruker")')->count());

        // Get form
        $form = $crawler->selectButton('Registrer bruker')->form(array(
            'user[email]' => 'nucl3ar5nake@ovase.no',
            'user[lastName]' => 'Adminsen',
            'user[firstName]' => 'Gunnar',
            'user[phone]' => '45133754',
        ));

        /* set form values
        $form['form_name[email]']='nucl3ar5nake@ovase.no';
        $form['form_name[lastName]']='Adminsen';
        $form['form_name[firstName]']='Gunnar';
        $form['form_name[phone]']='45133754';
        $form['form_name[password]']='Lucas Plein';
            'user[password]' => 'Lucas Plein',
                    ,
        */


        // submit the form
        $client->submit($form);

        // redirecting?
        $this->assertEquals(301, $client->getResponse()->getStatusCode());

        // Follow the redirect
        //$crawler = $client->followRedirect();

        // Assert that the response status code is 2xx
        $this->assertFalse($client->getResponse()->isSuccessful());

        $user = null;
        try {
            $user = $this->em->getRepository('AppBundle:User')->findUserByEmail('nucl3ar5nake@ovase.no');
            $this->assertTrue($user);
        } catch (NoResultException $t) {
            $this->assertNull($user);
        }
        $this->tearDown();
    }

        /**
         * {@inheritdoc}
         */
        protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }
}
