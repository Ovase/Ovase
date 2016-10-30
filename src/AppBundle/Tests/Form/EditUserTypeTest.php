<?php

// src/AppBundle/Tests/Form/EditUserTypeTest.php
namespace AppBundle\Tests\Form;

use AppBundle\Form\EditUserType;
use AppBundle\Entity\User;
use Symfony\Component\Form\Test\TypeTestCase;

class EditUserTypeTest extends TypeTestCase
{
	public function testSubmitValidData()
	{
		$formData = array(
			'email' => 'nucl3ar5nake@ovase.no',
			'lastName' => 'Adminsen',
			'firstName' => 'Gunnar',
			'phone' => '45133754',
		);

		$form = $this->factory->create(EditUserType::class);

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
