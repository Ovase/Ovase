<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\User;


class UserEntityUnitTest extends \PHPUnit_Framework_TestCase {
    
	// Check whether the setPassword function is working correctly
	public function testSetPassword(){
		
		// new entity
		$user = new User();
		
		// dummy password
		$password = password_hash("t¤est75Yø&", PASSWORD_BCRYPT, array('cost' => 12));
		
		// Use the setPassword method 
		$user->setPassword($password);
		
		// Assert the result 
		$this->assertEquals($password, $user->getPassword());
		
	}
	
	// Check whether the setEmail function is working correctly
	public function testSetEmail(){
		
		// new entity
		$user = new User();
		
		// Use the setEmail method 
		$user->setEmail("per@mail.com");
		
		// Assert the result 
		$this->assertEquals("per@mail.com", $user->getEmail());
		
	}
	
	// Check whether the setIsActive function is working correctly
	public function testSetIsActive(){
		
		// new entity
		$user = new User();
		
		// Use the setIsActive method 
		$user->setIsActive(1);
		
		// Assert the result 
		$this->assertEquals(1, $user->getIsActive());
		
	}
	
	// Check whether the setRoles function is working correctly
	public function testSetRoles(){
		
		// new entity
		$user = new User();
		
		// Use the setIsActive method 
		$user->setRoles(array("ROLE_USER"));
		
		// Assert the result 
		$this->assertEquals(1, count($user->getRoles()));
        $this->assertContains("ROLE_USER", $user->getRoles());
		
	}
	
	// Check whether the setLastName function is working correctly
	public function testSetLastName(){
		
		// new entity
		$user = new User();
		
		// Use the setLastName method 
		$user->setLastName("Olsen");
		
		// Assert the result 
		$this->assertEquals("Olsen", $user->getLastName());
		
	}
	
	// Check whether the setFirstname function is working correctly
	public function testSetFirstname(){
		
		// new entity
		$user = new User();
		
		// Use the setFirstname method 
		$user->setFirstName("Per");
		
		// Assert the result 
		$this->assertEquals("Per", $user->getFirstName());
		
	}
	// Check whether the setPicturePath function is working correctly
	public function testSetPicturePath(){
		
		// new entity
		$user = new User();
		
		// Use the setPicturePath method 
		$user->setPicturePath("olsen.jpg");
		
		// Assert the result
		$this->assertEquals("olsen.jpg", $user->getPicturePath());
		
	}


	// Check whether the setPhone function is working correctly
	public function testSetPhone(){
		
		// new entity
		$user = new User();
		
		// Use the setPhone method 
		$user->setPhone("12312312");
		
		// Assert the result 
		$this->assertEquals("12312312", $user->getPhone());
		
	}

	// Check whether the addRole function is working correctly
	public function testAddRole(){
	
		// new entity
		$user = new User();
		
		// New dummy entity 
		$ed = "ROLE_EDITOR";

		// Use the addRole method 
		$user->addRole($ed);
		
		// Roles is stored in an array 
		$roles = $user->getRoles();
        $this->assertContains("ROLE_EDITOR", $roles);
	}
}