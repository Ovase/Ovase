<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AppBundle\Entity\Project.
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectRepository")
 */
class Project
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	/**
	 * @ORM\Column(type="string", length=45)
	 * @Assert\NotBlank( message="Dette feltet kan ikke være tomt." )
	 * @Assert\Type("string")
	 */
	private $name;
	/**
	 * @ORM\Column(type="string")
	 */
	private $startdate;
	/**
	 * @ORM\Column(type="string")
	 */
	private $enddate;
    /**
     * @var float
     * @ORM\Column(type="float")
     * @Assert\Type("float")
     * @Assert\GreaterThanOrEqual(value=0, message="Verdien av feltet MÅ være ikke-negativ")
     */
    private $waterArea;
    /**
     * @ORM\Column(type="text")
     */
    private $dimentionalDemands;
    /**
     * @ORM\Column(type="text")
     */
    private $summary;
	/**
	 * @ORM\Column(type="text")
	 */
	private $description;
	/**
	 * Field for storing the address of the project
	 * @ORM\Column(type="text")
	 */
	private $location;

	/**
	 * The total area of the space the project took.
	 * @var float
     * @ORM\Column(type="float")
	 * @Assert\Type("float")
	 * @Assert\GreaterThanOrEqual(value=0, message="Verdien av feltet MÅ være ikke-negativ")
	 */
	private $totalArea = 0.0;

	/**
	 * @var string
     * @ORM\Column(type="string")
	 * @Assert\NotBlank
     * @Assert\Type("string")
	 * @Assert\Length(min = 1)
	 */
	private $areaType = "";

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(min = 1)
     */
	private $projectType = "";

    /**
     * @var array
     * @ORM\Column(type="array")
     * @Assert\All({
     *   @Assert\Type("string"),
     * })
     */
    private $images;

    /**
     * @var array
     * @ORM\Column(type="array")
     * @Assert\All({
     *	 @Assert\NotBlank,
     *   @Assert\Type("string"),
     *	 @Assert\Length(min = 1)
     * })
     */
    private $technicalSolutions;

    /**
     * Field for storing the required soil condition of the project
     * @ORM\Column(type="text")
     */
    private $soilConditions;

	/**
	 * @var int
 	 * @ORM\Column(type="integer")
 	 */
	private $version = 1;

    /**
     * The current total cost of the project, measured in NOK.
     * @var float
     * @ORM\Column(type="float")
     * @Assert\Type("float")
     * @Assert\GreaterThanOrEqual(value=0, message="Verdien av feltet MÅ være ikke-negativ")
     */
    private $cost;

	/**
	 * @var array
	 * @ORM\ManyToMany(targetEntity="Actor", inversedBy="projects")
	 * @ORM\JoinTable(name="actor_in_project")
	 */
	private $actors;

    /**
     * @ORM\ManyToMany(targetEntity="Measure", cascade={"remove", "persist"})
     * @ORM\JoinTable(name="projects_measures",
     *     joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")
     * },
     *     inverseJoinColumns={@ORM\JoinColumn(name="measure_id", referencedColumnName="id", unique=true, onDelete="cascade")}
     *     )
     * @Assert\Valid
     */
    private $measures;

	public function __construct()
	{
		$this->actors = new ArrayCollection();
        $this->technicalSolutions = array();
        $this->images = new ArrayCollection();
        $this->measures = new ArrayCollection();
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
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Project
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set location.
	 *
	 * @param string $location
	 *
	 * @return Project
	 */
	public function setLocation($location)
	{
		$this->location = $location;

		return $this;
	}

	/**
	 * Get location
	 *
	 * @return string
	 */
	public function getLocation()
	{
		return $this->location;
	}

	/**
	 * Get contributors to the project
	 *
	 * @return array
	 */
	public function getActors()
	{
		return $this->actors;
	}

	/**
	 * Set startdate
	 *
	 * @param \string $startdate
	 *
	 * @return Project
	 */
	public function setStartdate($startdate)
	{
		$this->startdate = $startdate;

		return $this;
	}

	/**
	 * Get startdate
	 *
	 * @return \string
	 */
	public function getStartdate()
	{
		return $this->startdate;
	}

	/**
	 * Set enddate
	 *
	 * @param \string $enddate
	 *
	 * @return Project
	 */
	public function setEnddate($enddate)
	{
		$this->enddate = $enddate;

		return $this;
	}

	/**
	 * Get enddate
	 *
	 * @return \string
	 */
	public function getEnddate()
	{
		return $this->enddate;
	}

	/**
	 * Set technicalSolutions
	 *
	 * @param array $technicalSolutions
	 *
	 * @return Project
	 */
	public function setTechnicalSolutions($technicalSolutions)
	{
		$this->technicalSolutions = $technicalSolutions;

		return $this;
	}

	/**
	 * Get technicalSolutions
	 *
	 * @return array
	 */
	public function getTechnicalSolutions()
	{
		return $this->technicalSolutions;
	}

	/**
	 * Set description
	 *
	 * @param string $description
	 *
	 * @return Project
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
	/**
	 * Add Actors.
	 *
	 * @param actor $actor
	 *
	 * @return Project
	 */
	public function addActor($actor)
	{
		$this->actors[] = $actor;
		return $this;
	}
	/**
	 * Remove Actors.
	 *
	 * @param actor $actor
	 */
	public function removeActor($actor)
	{
		$this->actors->removeElement($actor);
	}

	/**
	 * Increment version counter
	 */
	public function incrementVersion()
	{
		$this->version++;
		return $this;
	}

	/**
	 * Reset version counter
	 */
	public function resetVersion()
	{
		$this->version = 0;
		return $this;
	}
    /**
     * @return float
     */
    public function getTotalArea()
    {
        return $this->totalArea;
    }

    /**
     * @param float $totalArea
     */
    public function setTotalArea($totalArea)
    {
        $this->totalArea = $totalArea;
    }

    /**
     * @return string
     */
    public function getAreaType()
    {
        return $this->areaType;
    }

    /**
     * @param string $areaType
     */
    public function setAreaType($areaType)
    {
        $this->areaType = $areaType;
    }

    /**
     * @return string
     */
    public function getProjectType()
    {
        return $this->projectType;
    }

    /**
     * @param string $projectType
     */
    public function setProjectType($projectType)
    {
        $this->projectType = $projectType;
    }

    /**
     * @return mixed
     */
    public function getSoilConditions()
    {
        return $this->soilConditions;
    }

    /**
     * @param mixed $soilConditions
     */
    public function setSoilConditions($soilConditions)
    {
        $this->soilConditions = $soilConditions;
    }

    /**
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param float $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * Set version
     *
     * @param integer $version
     *
     * @return Project
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * Get version
     *
     * @return integer
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return array
     */
    public function getImages()
    {
        return $this->images->toArray();
    }

    /**
     * Appends an array of images to existing images
     * @param array $images
     * @return Project
     */
    public function addImages($images)
    {
        foreach ($images as $img) {
            if (!($this->images->contains($img))) {
                $this->images->add($img);
            }
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMeasures()
    {
        return $this->measures;
    }

    /**
     * @param mixed $measures
     */
    public function setMeasures($measures)
    {
        $this->measures = $measures;
    }

    public function addMeasure($measure)
    {
        $this->measures->add($measure);
    }

    /**
     * @return mixed
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param mixed $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return mixed
     */
    public function getWaterArea()
    {
        return $this->waterArea;
    }

    /**
     * @param mixed $waterArea
     */
    public function setWaterArea($waterArea)
    {
        $this->waterArea = $waterArea;
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

}
