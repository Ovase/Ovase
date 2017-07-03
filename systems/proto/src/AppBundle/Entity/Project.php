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
	 * @Assert\NotBlank(
     *      groups = {"flow_editProject_step1"},
     *      message="Dette feltet kan ikke være tomt." )
	 * @Assert\Type(
     *      groups = {"flow_editProject_step1"},
     *      type = "string")
	 */
	private $name;
	/**
	 * @ORM\Column(type="string")
	 */
	private $enddate;

    /**
     * @ORM\Column(type="string")
     */
    private $projectOwner;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      groups = {"flow_editProject_step1"},
     *      min = 5,
     *      max = 140,
     *      minMessage = "Teksten må ha minst fem tegn.",
     *      maxMessage = "Teksten kan ikke være lengre enn 128 tegn.")
     */
    private $leadText;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $summary;
	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $description;
	/**
	 * @ORM\Column(type="text")
	 */
	private $location;

    /**
     * Field for storing lat coordinate found for address
     * @ORM\Column(type="float")
     * @Assert\Type(
     *      groups = {"flow_editProject_step1"},
     *      type = "numeric")
     */
    private $coordLat;
    /**
     * Field for storing long coordinate found for address
     * @ORM\Column(type="float")
     * @Assert\Type(
     *      groups = {"flow_editProject_step1"},
     *      type = "numeric")
     */
    private $coordLong;
    /**
     * One product has many images
     * 
     * @ORM\OneToMany(targetEntity="ProjectImage", mappedBy="project", cascade={"persist", "remove"})
     */
    private $images;
    /**
     * Holds files, but is not persisted to DB
     */
    private $imageFiles;
	/**
	 * @var int
 	 * @ORM\Column(type="integer")
 	 */
	private $version = 1;
	/**
	 * @ORM\ManyToMany(targetEntity="Actor", inversedBy="projects")
	 * @ORM\JoinTable(name="actor_in_project")
	 */
	private $actors;
    /**
     * @ORM\OneToMany(targetEntity="Measure", mappedBy="project", cascade={"remove", "persist"})
     * @Assert\Valid
     */
    private $measures;

	public function __construct()
	{
		$this->actors = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->imageFiles = new ArrayCollection();
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
		return $this->actors->toArray();
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
	 * @param Actor $actor
	 *
	 * @return Project
	 */
	public function addActor(Actor $actor)
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
     * Add image
     *
     * @param \AppBundle\Entity\ProjectImage $image
     *
     * @return Product
     */
    public function addImage(\AppBundle\Entity\ProjectImage $image)
    {
        // Ensure that the image-belongs-to-product relationship is set
        $image->setProject($this);
        $this->images[] = $image;
        return $this;
    }

    /**
     * Remove image
     *
     * @param \AppBundle\Entity\ProjectImage $image
     */
    public function removeImage(\AppBundle\Entity\ProjectImage $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    public function getImageFiles()
    {
        return $this->imageFiles;
    }

    public function setImageFiles($imageFiles)
    {
        $this->imageFiles = $imageFiles;
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

    /**
     * @return mixed
     */
    public function getUniqueMeasureTypes()
    {
        $measureTypes = array();
        foreach ($this->measures as $measure)
            $measureTypes[] = $measure->getType();
        return array_unique($measureTypes);
    }

    public function addMeasure($measure)
    {
        $measure->setProject($this);
        $this->measures[] = $measure;
        return $this;
    }

    /**
     * Remove measure
     *
     * @param \AppBundle\Entity\Measure $measure
     */
    public function removeMeasure(\AppBundle\Entity\Measure $measure)
    {

        $this->measures->removeElement($measure);
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
     * Set coordLat
     *
     * @param float $coordLat
     *
     * @return Project
     */
    public function setCoordLat($coordLat)
    {
        $this->coordLat = $coordLat;

        return $this;
    }

    /**
     * Get coordLat
     *
     * @return float
     */
    public function getCoordLat()
    {
        return $this->coordLat;
    }

    /**
     * Set coordLong
     *
     * @param float $coordLong
     *
     * @return Project
     */
    public function setCoordLong($coordLong)
    {
        $this->coordLong = $coordLong;

        return $this;
    }

    /**
     * Get coordLong
     *
     * @return float
     */
    public function getCoordLong()
    {
        return $this->coordLong;
    }

    public function __toString()
    {
        $my_string = 'Name: ' . $this->getName() . "\n";
        $my_string = $my_string . "Images: \n";
        foreach ($this->getImages() as $img) {
            $my_string = $my_string . $img->getUrl() . "\n";
        }
        return $my_string;
    }

    /**
     * Set leadText
     *
     * @param string $leadText
     *
     * @return Project
     */
    public function setLeadText($leadText)
    {
        $this->leadText = $leadText;

        return $this;
    }

    /**
     * Get leadText
     *
     * @return string
     */
    public function getLeadText()
    {
        return $this->leadText;
    }

    /**
     * Set projectOwner
     *
     * @param string $projectOwner
     *
     * @return Project
     */
    public function setProjectOwner($projectOwner)
    {
        $this->projectOwner = $projectOwner;

        return $this;
    }

    /**
     * Get projectOwner
     *
     * @return string
     */
    public function getProjectOwner()
    {
        return $this->projectOwner;
    }
}
