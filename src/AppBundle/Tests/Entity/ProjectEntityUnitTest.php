<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Project;


class ProjectEntityUnitTest extends \PHPUnit_Framework_TestCase {
    
	// Check whether the setPassword function is working correctly
	public function testTechnicalSolutions(){
		
		// new entity
		$p = new Project();
		
		$technicalSolutions = array("water engineering","energy","rain gardening","spray ponds","systems administration","multifunctional playground", "green roof");
		
		// Use the setPassword method 
		$p->setTechnicalSolutions($technicalSolutions);
		
		// Assertions
        $this->assertContains("energy", $p->getTechnicalSolutions());
        $this->assertContains("water engineering", $p->getTechnicalSolutions());
        $this->assertNotEmpty($p->getTechnicalSolutions());

	}
	// Check whether the setCost function is working correctly
	public function testSetCost(){
		
		// new entity
		$p = new Project();
		
		// Use the setPhone method 
		$p->setCost(12312312.0);
		
		// Assert the result 
		$this->assertEquals(12312312.0, $p->getCost());
		
	}
    // Check whether the setCost function is working correctly
    public function testSetArea(){

        // new entity
        $p = new Project();

        // Use the setPhone method
        $p->setTotalArea(12312312.0);

        // Assert the result
        $this->assertEquals(12312312.0, $p->getTotalArea());
    }
    // Check whether the setName function is working correctly
    public function testSetName(){

        // new entity
        $p = new Project();
        $name = 'This Project completely incompetent';

        // Use the setPhone method
        $p->setName($name);

        // Assert the result
        $this->assertEquals('This Project completely incompetent', $p->getName());

    }
    // Check whether the setSoilConditions function is working correctly
    public function testSetSoilConditions(){

        // new entity
        $p = new Project();

        // Use the setSoilConditions method
        $p->setSoilConditions("Soil needs only be normal");

        // Assert the result
        $this->assertEquals("Soil needs only be normal", $p->getSoilConditions());

    }
    // Check whether the setProjectType function is working correctly
    public function testSetProjectType(){

        // new entity
        $p = new Project();

        // Use the setType method
        $p->setProjectType("engineering");

        // Assert the result
        $this->assertEquals("engineering", $p->getProjectType());
    }
    // Check whether the setProjectType function is working correctly
    public function testSetAreaType(){

        // new entity
        $p = new Project();

        // Use the setType method
        $p->setAreaType("residential");

        // Assert the result
        $this->assertEquals("residential", $p->getAreaType());
    }
    // Check whether the setLocation function is working correctly
    public function testSetLocation(){

        // new entity
        $p = new Project();

        // Use the setLoc method
        $p->setLocation("Elvebakk, Åfjord");

        // Assert the result
        $this->assertEquals("Elvebakk, Åfjord", $p->getLocation());
    }

}