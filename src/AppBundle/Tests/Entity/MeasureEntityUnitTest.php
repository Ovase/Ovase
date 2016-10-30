<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Measure;

class MeasureEntityUnitTest extends \PHPUnit_Framework_TestCase {
    
	// Check whether the setPassword function is working correctly
	public function testTechnicalSolutions(){
		
		// new entity
		$p = new Measure();
		
		$technicalFunction = implode(", ",array("water engineering","energy","rain gardening","spray ponds","systems administration","multifunctional playground", "green roof"));
		//
		// Use the setPassword method 
		$p->setTechnicalFunctions($technicalFunction);

        // Assert the result
        $this->assertEquals("water engineering, energy, rain gardening, spray ponds, systems administration, multifunctional playground, green roof", $p->getTechnicalFunctions());

	}
	// Check whether the setCost function is working correctly
	public function testSetCost(){
		
		// new entity
		$p = new Measure();
		
		// Use the setPhone method 
		$p->setCosts(12312312.0);
		
		// Assert the result 
		$this->assertEquals(12312312.0, $p->getCosts());
	}
    // Check whether the setCost function is working correctly
    public function testSetArea(){

        // new entity
        $p = new Measure();

        // Use the setPhone method
        $p->setTotalArea(12312312.0);

        // Assert the result
        $this->assertEquals(12312312.0, $p->getTotalArea());
    }
    // Check whether the setTitle function is working correctly
    public function testSetName(){

        // new entity
        $p = new Measure();
        $name = 'This Measure completely incompetent';

        // Use the setPhone method
        $p->setTitle($name);

        // Assert the result
        $this->assertEquals('This Measure completely incompetent', $p->getTitle());
    }
    // Check whether the setElaboration function is working correctly
    public function testSetElaboration(){

        // new entity
        $p = new Measure();

        // Use the setSoilConditions method
        $p->setElaboration("test");

        // Assert the result
        $this->assertEquals("test", $p->getElaboration());
    }
    public function testSetAdditionalValues(){

        // new entity
        $p = new Measure();

        // Use the setSoilConditions method
        $p->setAdditionalValues("test");

        // Assert the result
        $this->assertEquals("test", $p->getAdditionalValues());
    }
    public function testSetDesignElaboration(){

        // new entity
        $p = new Measure();

        // Use the setSoilConditions method
        $p->setGeometricDesignElaboration("test");

        // Assert the result
        $this->assertEquals("test", $p->getGeometricDesignElaboration());
    }


    public function testSetConstructionDetails(){

        // new entity
        $p = new Measure();

        // Use the setSoilConditions method
        $p->setConstructionDetails("test");

        // Assert the result
        $this->assertEquals("test", $p->getConstructionDetails());
    }
    public function testSetMaintenance(){

        // new entity
        $p = new Measure();

        // Use the setSoilConditions method
        $p->setMaintenance("test");

        // Assert the result
        $this->assertEquals("test", $p->getMaintenance());
    }
    public function testSetExperiencesGained(){

        // new entity
        $p = new Measure();

        // Use the setSoilConditions method
        $p->setExperiencesGained("test");

        // Assert the result
        $this->assertEquals("test", $p->getExperiencesGained());
    }

    public function testSetDimensionalDemands(){

        // new entity
        $p = new Measure();

        // Use the setSoilConditions method
        $p->setDimentionalDemands("We do not know about this field");

        // Assert the result
        $this->assertEquals("We do not know about this field", $p->getDimentionalDemands());
    }

}