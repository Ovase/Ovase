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
        $p->setWaterArea(7231.0);

        // Assert the result
        $this->assertEquals(12312312.0, $p->getTotalArea());
        $this->assertEquals(7231.0, $p->getWaterArea());
    }
    // Check whether the setName function is working correctly
    public function testSetName(){

        // new entity
        $p = new Measure();
        $name = 'This Measure completely incompetent';

        // Use the setPhone method
        $p->setName($name);

        // Assert the result
        $this->assertEquals('This Measure completely incompetent', $p->getName());
    }
    // Check whether the setSoilConditions function is working correctly
    public function testSetDates(){

        // new entity
        $p = new Measure();
        $p->setStartdate('2016-01-01');
        $p->setEnddate('2016-10-10');
        //$this->assertT
        $result = $p->getEnddate();
        $start = $p->getStartdate();
        $this->assertEquals('2016-01-01', $start);
        $this->assertEquals('2016-10-10', $result);
    }
    // Check whether the setSoilConditions function is working correctly
    public function testSetSoilConditions(){

        // new entity
        $p = new Measure();

        // Use the setSoilConditions method
        $p->setSoilConditions("Soil needs only be normal");

        // Assert the result
        $this->assertEquals("Soil needs only be normal", $p->getSoilConditions());

    }

    public function testSetDimensionalDemands(){

        // new entity
        $p = new Measure();

        // Use the setSoilConditions method
        $p->setDimentionalDemands("We do not know about this field");

        // Assert the result
        $this->assertEquals("We do not know about this field", $p->getDimentionalDemands());
    }

    public function testSetSummary(){

        // new entity
        $p = new Measure();

        // Use the setSoilConditions method
        $p->setSummary("We do not know jack about this field");

        // Assert the result
        $this->assertEquals("We do not know jack about this field", $p->getSummary());
    }

    public function testSetDescription(){

        // new entity
        $p = new Measure();

        // Use the setSoilConditions method
        $p->setDescription("We do not know about this field");

        // Assert the result
        $this->assertEquals("We do not know about this field", $p->getDescription());
    }

    // Check whether the setMeasureType function is working correctly
    public function testSetMeasureType(){

        // new entity
        $p = new Measure();

        // Use the setType method
        $p->setMeasureType("engineering");

        // Assert the result
        $this->assertEquals("engineering", $p->getMeasureType());
    }
    // Check whether the setMeasureType function is working correctly
    public function testSetAreaType(){

        // new entity
        $p = new Measure();

        // Use the setType method
        $p->setAreaType("residential");

        // Assert the result
        $this->assertEquals("residential", $p->getAreaType());
    }
    // Check whether the setLocation function is working correctly
    public function testSetLocation(){

        // new entity
        $p = new Measure();

        // Use the setLoc method
        $p->setLocation("Elvebakk, Åfjord");

        // Assert the result
        $this->assertEquals("Elvebakk, Åfjord", $p->getLocation());
    }

}