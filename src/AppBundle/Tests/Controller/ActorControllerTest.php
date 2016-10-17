<?php

namespace AppBundle\Tests\Controller;

use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ActorControllerTest extends WebTestCase
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $em;

	public function setUp()
	{
		self::bootKernel();
		$this->em = static::$kernel->getContainer()
			->get('doctrine')
			->getManager();
	}

	public function testCreateCompany()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/actor');

		//Check if link to create company exists
		$links = $crawler
			->filter('a:contains("Lag selskap")');
		$this->assertEquals(1, $links->count());

		$link = $links
			->eq(0)
			->link();

		//Click on create company
		$crawler = $client->click($link);
		$this->assertEquals(200, $client->getResponse()->getStatusCode());

		$companyName = 'test selskap';
		//Get the form
		$form = $crawler->selectButton('company[save]')->form(array(
			'company[name]' => $companyName,
			'company[email]' => 'test@selskap.no',
			'company[type]' => 'regnbed',
			'company[org_nr]' => '123123333'
		));
		$client->submit($form);
		$client->followRedirect();

		//Check if the company exists in the list
		$this->assertContains($companyName, $client->getResponse()->getContent());
	}


	public function tearDown()
	{
		parent::tearDown();
		$company = null;
		try {
			$company = $this->em->getRepository('AppBundle:Company')->findCompanyByOrgNr('123123333');
		} catch (NoResultException $t) {
			$this->em->close();
			return;
		}
		if ($company) {
			$this->em->remove($company);
			$this->em->flush();
		}
		$this->em->close();
	}
}