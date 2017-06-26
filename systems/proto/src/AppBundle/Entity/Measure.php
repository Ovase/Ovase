<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="measures")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $project;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text")
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="area", type="integer")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0, message="Verdien av feltet MÅ være ikke-negativ")
     */
    private $area;

    /**
     * @ORM\Column(type="text")
     */
    private $dimentionalDemands;

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
     * Set area
     *
     * @param integer $area
     *
     * @return Measure
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return int
     */
    public function getArea()
    {
        return $this->area;
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

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDimentionalDemands()
    {
        return $this->dimentionalDemands;
    }

    /**
     * @param mixed $dimentionalDemands
     */
    public function setDimentionalDemands($dimentionalDemands)
    {
        $this->dimentionalDemands = $dimentionalDemands;
    }


    /**
     * Set project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return Measure
     */
    public function setProject(\AppBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \AppBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }
}
