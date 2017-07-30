<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var string
     *
     * TODO: This should use type string with max length
     * @ORM\Column(name="type", type="text")
     */
    private $type;

    /**
     * @var mixed
     * @ORM\Column(type="array", nullable=true)
     */
    private $functions;

    /***** Numerical, technical data *****/

    /**
     * @var int
     *
     * @ORM\Column(name="dimentionalWaterAmount", type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(value=0, message="Verdien av feltet kan ikke være negativ.")
     */
    private $dimentionalWaterAmount;

    /**
     * Tiltakets overflateareal
     * @var int
     *
     * @ORM\Column(name="area", type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(value=0, message="Verdien av feltet kan ikke være negativ.")
     */
    private $area;

    /**
     * Areal av (del)nedbørsfelt
     * @var int
     *
     * @ORM\Column(name="catchmentArea", type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(value=0, message="Verdien av feltet kan ikke være negativ.")
     */
    private $catchmentArea;

    /**
     * (Målt) hydraulisk konduktivitet
     * @var int
     *
     * @ORM\Column(name="hydraulicConductivity", type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(value=0, message="Verdien av feltet kan ikke være negativ.")
     */
    private $hydraulicConductivity;

    /**
     * Kostnadsramme
     * @var int
     *
     * @ORM\Column(name="costs", type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(value=0, message="Verdien av feltet kan ikke være negativ.")
     */
    private $costs;

    /**
     * Er det benyttet instrumentering?
     * @var string
     *
     * @ORM\Column(name="instrumentation", type="string", length=20, nullable=true)
     */
    private $instrumentation;

    /***** Free Text *****/

    /**
     * Beskrivelse (WYSIWYG/HTML-tekst)
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function __construct() {
        // TODO: Render this from a template instead
        $this->description = <<< EOT
<h1>Formål, uforming og konstruksjonsutførelse</h1>

<p>For eksempel oppbygning, innløp, utløp og mengderegulering?</p>

<h1>Nedbørsfelt</h1>

<p>For eksempel aktiviteter og typer flater. Hvordan er vanntilførselen? Kilder til forurensning?</p>

<h1>Dimensjonerende krav</h1>

<h1>Grunnforhold</h1>

<h1>Erfaringer og tips</h1>

<p>Hva er viktig i utformingen, anleggelsen og driften av lignende tiltak?</p>
EOT;
    }

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

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Measure
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * Set dimentionalWaterAmount
     *
     * @param integer $dimentionalWaterAmount
     *
     * @return Measure
     */
    public function setDimentionalWaterAmount($dimentionalWaterAmount)
    {
        $this->dimentionalWaterAmount = $dimentionalWaterAmount;

        return $this;
    }

    /**
     * Get dimentionalWaterAmount
     *
     * @return integer
     */
    public function getDimentionalWaterAmount()
    {
        return $this->dimentionalWaterAmount;
    }

    /**
     * Set dimentionalFlood
     *
     * @param integer $dimentionalFlood
     *
     * @return Measure
     */
    public function setDimentionalFlood($dimentionalFlood)
    {
        $this->dimentionalFlood = $dimentionalFlood;

        return $this;
    }

    /**
     * Get dimentionalFlood
     *
     * @return integer
     */
    public function getDimentionalFlood()
    {
        return $this->dimentionalFlood;
    }

    /**
     * Set catchmentArea
     *
     * @param integer $catchmentArea
     *
     * @return Measure
     */
    public function setCatchmentArea($catchmentArea)
    {
        $this->catchmentArea = $catchmentArea;

        return $this;
    }

    /**
     * Get catchmentArea
     *
     * @return integer
     */
    public function getCatchmentArea()
    {
        return $this->catchmentArea;
    }

    /**
     * Set hydraulicConductivity
     *
     * @param integer $hydraulicConductivity
     *
     * @return Measure
     */
    public function setHydraulicConductivity($hydraulicConductivity)
    {
        $this->hydraulicConductivity = $hydraulicConductivity;

        return $this;
    }

    /**
     * Get hydraulicConductivity
     *
     * @return integer
     */
    public function getHydraulicConductivity()
    {
        return $this->hydraulicConductivity;
    }

    /**
     * Set soilConditions
     *
     * @param string $soilConditions
     *
     * @return Measure
     */
    public function setSoilConditions($soilConditions)
    {
        $this->soilConditions = $soilConditions;

        return $this;
    }

    /**
     * Get soilConditions
     *
     * @return string
     */
    public function getSoilConditions()
    {
        return $this->soilConditions;
    }

    /**
     * Set designAndConstruction
     *
     * @param string $designAndConstruction
     *
     * @return Measure
     */
    public function setDesignAndConstruction($designAndConstruction)
    {
        $this->designAndConstruction = $designAndConstruction;

        return $this;
    }

    /**
     * Get designAndConstruction
     *
     * @return string
     */
    public function getDesignAndConstruction()
    {
        return $this->designAndConstruction;
    }

    /**
     * Set functions
     *
     * @param array $functions
     *
     * @return Measure
     */
    public function setFunctions($functions)
    {
        $this->functions = $functions;

        return $this;
    }

    /**
     * Get functions
     *
     * @return array
     */
    public function getFunctions()
    {
        return $this->functions;
    }

    /**
     * Set functionsElaboration
     *
     * @param string $functionsElaboration
     *
     * @return Measure
     */
    public function setFunctionsElaboration($functionsElaboration)
    {
        $this->functionsElaboration = $functionsElaboration;

        return $this;
    }

    /**
     * Get functionsElaboration
     *
     * @return string
     */
    public function getFunctionsElaboration()
    {
        return $this->functionsElaboration;
    }

    /**
     * Set instrumentation
     *
     * @param string $instrumentation
     *
     * @return Measure
     */
    public function setInstrumentation($instrumentation)
    {
        $this->instrumentation = $instrumentation;

        return $this;
    }

    /**
     * Get instrumentation
     *
     * @return string
     */
    public function getInstrumentation()
    {
        return $this->instrumentation;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Measure
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
