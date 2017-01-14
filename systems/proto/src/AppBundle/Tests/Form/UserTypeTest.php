<?php

// src/AppBundle/Tests/Form/UserTypeTest.php
namespace AppBundle\Tests\Form;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
	public function testSubmitValidData()
	{
		$formData = array(
			'email' => 'nucl3ar5nake@ovase.no',
			'lastName' => 'Adminsen',
			'firstName' => 'Gunnar',
			'phone' => '45133754',
		);

		$form = $this->factory->create(UserType::class, null, array(
        'environment' => 'test',
    	));

		$user = new User();
		$user->fromArray($formData);
		//$user = User::fromArray();

		// submit the data to the form directly
		$form->submit($formData);

		$this->assertTrue($form->isSynchronized());
		$this->assertEquals($user, $form->getData());

		$view = $form->createView();
		$children = $view->children;

		foreach (array_keys($formData) as $key) {
			$this->assertArrayHasKey($key, $children);
		}
	}
}
