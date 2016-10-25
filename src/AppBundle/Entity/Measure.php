<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Measure
 *
 * @ORM\Table(name="measure")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MeasureRepository")
 */
class Measure
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="totalArea", type="integer")
     */
    private $totalArea;

    /**
     * @var int
     *
     * @ORM\Column(name="costs", type="integer", nullable=true)
     */
    private $costs;

    /**
     * @var string
     *
     * @ORM\Column(name="technicalFunctions", type="text")
     */
    private $technicalFunctions;

    /**
     * @var string
     *
     * @ORM\Column(name="elaboration", type="text")
     */
    private $elaboration;

    /**
     * @var string
     *
     * @ORM\Column(name="additionalValues", type="text", nullable=true)
     */
    private $additionalValues;

    /**
     * @var string
     *
     * @ORM\Column(name="geometricDesignElaboration", type="text", nullable=true)
     */
    private $geometricDesignElaboration;

    /**
     * @var string
     *
     * @ORM\Column(name="constructionDetails", type="text", nullable=true)
     */
    private $constructionDetails;

    /**
     * @var string
     *
     * @ORM\Column(name="maintenance", type="text", nullable=true)
     */
    private $maintenance;

    /**
     * @var string
     *
     * @ORM\Column(name="experiencesGained", type="text", nullable=true)
     */
    private $experiencesGained;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set totalArea
     *
     * @param integer $totalArea
     *
     * @return Measure
     */
    public function setTotalArea($totalArea)
    {
        $this->totalArea = $totalArea;

        return $this;
    }

    /**
     * Get totalArea
     *
     * @return int
     */
    public function getTotalArea()
    {
        return $this->totalArea;
    }

    /**
     * Set costs
     *
     * @param integer $costs
     *
     * @return Measure
     */
    public function setCosts($costs)
    {
        $this->costs = $costs;

        return $this;
    }

    /**
     * Get costs
     *
     * @return int
     */
    public function getCosts()
    {
        return $this->costs;
    }

    /**
     * Set technicalFunctions
     *
     * @param string $technicalFunctions
     *
     * @return Measure
     */
    public function setTechnicalFunctions($technicalFunctions)
    {
        $this->technicalFunctions = $technicalFunctions;

        return $this;
    }

    /**
     * Get technicalFunctions
     *
     * @return string
     */
    public function getTechnicalFunctions()
    {
        return $this->technicalFunctions;
    }

    /**
     * Set elaboration
     *
     * @param string $elaboration
     *
     * @return Measure
     */
    public function setElaboration($elaboration)
    {
        $this->elaboration = $elaboration;

        return $this;
    }

    /**
     * Get elaboration
     *
     * @return string
     */
    public function getElaboration()
    {
        return $this->elaboration;
    }

    /**
     * Set additionalValues
     *
     * @param string $additionalValues
     *
     * @return Measure
     */
    public function setAdditionalValues($additionalValues)
    {
        $this->additionalValues = $additionalValues;

        return $this;
    }

    /**
     * Get additionalValues
     *
     * @return string
     */
    public function getAdditionalValues()
    {
        return $this->additionalValues;
    }

    /**
     * Set geometricDesignElaboration
     *
     * @param string $geometricDesignElaboration
     *
     * @return Measure
     */
    public function setGeometricDesignElaboration($geometricDesignElaboration)
    {
        $this->geometricDesignElaboration = $geometricDesignElaboration;

        return $this;
    }

    /**
     * Get geometricDesignElaboration
     *
     * @return string
     */
    public function getGeometricDesignElaboration()
    {
        return $this->geometricDesignElaboration;
    }

    /**
     * Set constructionDetails
     *
     * @param string $constructionDetails
     *
     * @return Measure
     */
    public function setConstructionDetails($constructionDetails)
    {
        $this->constructionDetails = $constructionDetails;

        return $this;
    }

    /**
     * Get constructionDetails
     *
     * @return string
     */
    public function getConstructionDetails()
    {
        return $this->constructionDetails;
    }

    /**
     * Set maintenance
     *
     * @param string $maintenance
     *
     * @return Measure
     */
    public function setMaintenance($maintenance)
    {
        $this->maintenance = $maintenance;

        return $this;
    }

    /**
     * Get maintenance
     *
     * @return string
     */
    public function getMaintenance()
    {
        return $this->maintenance;
    }

    /**
     * Set experiencesGained
     *
     * @param string $experiencesGained
     *
     * @return Measure
     */
    public function setExperiencesGained($experiencesGained)
    {
        $this->experiencesGained = $experiencesGained;

        return $this;
    }

    /**
     * Get experiencesGained
     *
     * @return string
     */
    public function getExperiencesGained()
    {
        return $this->experiencesGained;
    }

}

