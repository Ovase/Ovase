<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\NoResultException;

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

        // Get form
        $form=$crawler->selectButton('Registrer bruker')->form();
        $values = $form->getPhpValues();

        // set form values
        $values['email']='nucl3ar5nake@ovase.no';
        $values['lastName']='Adminsen';
        $values['firstName']='Gunnar';
        $values['phone']='45133754';
        $values['password']='Lucas Plein';

        // submit the form
        //$crawler=$client->submit($form);
        $crawler = $client->request($form->getMethod(), $form->getUri(), $values,$form->getPhpFiles());

        // Is the form valid?
        //$this->assertEquals(True, $form->isValid());

        // redirecting?
        $this->assertTrue($client->getResponse()->isRedirect());

        // Follow the redirect
        $crawler = $client->followRedirect();

        // Assert that the response status code is 2xx
        $this->assertTrue($client->getResponse()->isSuccessful());

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
