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
            'user[password]' => array(
				'first' => 'Lucas Plein',
				'second' => 'Lucas Plein'
			)
        ), 'POST');

        // submit the form
        $client->submit($form);

        // redirecting?
        $this->assertEquals(301, $client->getResponse()->getStatusCode());
		$this->assertTrue($client->getResponse()->isRedirect('/login'));
        $user = null;
        try {
            $user = $this->em->getRepository('AppBundle:User')->findUserByEmail('nucl3ar5nake@ovase.no');
            $this->assertNotNull($user);
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
        $user = null;
        try {
            $user = $this->em->getRepository('AppBundle:User')->findUserByEmail('nucl3ar5nake@ovase.no');
        } catch (NoResultException $t) {
			$this->em->close();
			return;
		}
        if ($user) {
			$this->em->remove($user);
			$this->em->flush();
		}
		$this->em->close();
    }
}
