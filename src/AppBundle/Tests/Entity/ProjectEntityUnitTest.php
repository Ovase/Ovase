<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Project;


class ProjectEntityUnitTest extends \PHPUnit_Framework_TestCase {
    
	// Check whether the setPassword function is working correctly
	public function testKeyKnowledges(){
		
		// new entity
		$p = new Project();
		
		$keyKnowledges = array("water engineering","energy","rain gardening","spray ponds","systems administration","multifunctional playground", "green roof");
		
		// Use the setPassword method 
		$p->setKeyKnowledges($keyKnowledges);
		
		// Assertions
        $this->assertContains("energy", $p->getKeyKnowledges());
        $this->assertContains("water engineering", $p->getKeyKnowledges());
        $this->assertNotEmpty($p->getKeyKnowledges());

	}
	// Check whether the setTlf function is working correctly
	public function testSetTlf(){
		
		// new entity
		$p = new Project();
		
		// Use the setPhone method 
		$p->setTlf("12312312");
		
		// Assert the result 
		$this->assertEquals("12312312", $p->getTlf());
		
	}
    // Check whether the setCompetence function is working correctly
    public function testSetCompetence(){

        // new entity
        $p = new Project();
        $competence = 'This Project completely incompetent';

        // Use the setPhone method
        $p->setCompetence($competence);

        // Assert the result
        $this->assertEquals('This Project completely incompetent', $p->getCompetence());

    }
    // Check whether the setEmail function is working correctly
    public function testSetEmail(){

        // new entity
        $p = new Project();

        // Use the setEmail method
        $p->setEmail("per@mail.com");

        // Assert the result
        $this->assertEquals("per@mail.com", $p->getEmail());

    }
    // Check whether the setField function is working correctly
    public function testSetField(){

        // new entity
        $p = new Project();

        // Use the setEmail method
        $p->setField("engineering");

        // Assert the result
        $this->assertEquals("engineering", $p->getField());
    }
    // Check whether the setLocation function is working correctly
    public function testSetLocation(){

        // new entity
        $p = new Project();

        // Use the setEmail method
        $p->setLocation("Elvebakk, Åfjord");

        // Assert the result
        $this->assertEquals("Elvebakk, Åfjord", $p->getLocation());
    }

}