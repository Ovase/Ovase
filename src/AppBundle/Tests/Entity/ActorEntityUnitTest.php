<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Actor;


class ActorEntityUnitTest extends \PHPUnit_Framework_TestCase {
    
	// Check whether the setPassword function is working correctly
	public function testKeyKnowledges(){
		
		// new entity
		$a = new Actor();
		
		$keyKnowledges = array("water engineering","energy","rain gardening","spray ponds","systems administration","multifunctional playground", "green roof");
		
		// Use the setPassword method 
		$a->setKeyKnowledges($keyKnowledges);
		
		// Assert the result 

	}
	// Check whether the setTlf function is working correctly
	public function testSetTlf(){
		
		// new entity
		$a = new Actor();
		
		// Use the setPhone method 
		$a->setTlf("12312312");
		
		// Assert the result 
		$this->assertEquals("12312312", $a->getTlf());
		
	}

}