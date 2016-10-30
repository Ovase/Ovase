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
		
		// Assertions
        $this->assertContains("energy", $a->getKeyKnowledges());
        $this->assertContains("water engineering", $a->getKeyKnowledges());
        $this->assertNotEmpty($a->getKeyKnowledges());

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
    // Check whether the setCompetence function is working correctly
    public function testSetCompetence(){

        // new entity
        $a = new Actor();
        $competence = 'This actor completely incompetent';

        // Use the setPhone method
        $a->setCompetence($competence);

        // Assert the result
        $this->assertEquals('This actor completely incompetent', $a->getCompetence());

    }
    // Check whether the setEmail function is working correctly
    public function testSetEmail(){

        // new entity
        $user = new Actor();

        // Use the setEmail method
        $user->setEmail("per@mail.com");

        // Assert the result
        $this->assertEquals("per@mail.com", $user->getEmail());

    }

}