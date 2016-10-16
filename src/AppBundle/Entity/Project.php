<?php
namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ivory\GoogleMap\Base\Coordinate;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Ivory\GoogleMap\Places\AutocompleteType;

/**
 * AppBundle\Entity\Project.
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectRepository")
 * @UniqueEntity(
 *	  fields={"id"},
 *	  message="Denne ID er allerede i bruk.",
 * )
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
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Type("string")
	 */
	private $field;
	/**
	 * @ORM\Column(type="datetime")
	 */
	private $startdate;
	/**
	 * @ORM\Column(type="datetime")
	 */
	private $enddate;
	/**
	 * An array of two floats, a latitude (N) and a longitude (E)
	 * @var Coordinate
	 * @Assert\NotBlank,
	 * @Assert\NotNull
	 */
	private $location;
	/**
	 * @ORM\Column(type="array")
	 * @Assert\All({
	 *	 @Assert\NotBlank,
	 *	 @Assert\Length(min = 5)
	 * })
	 */
	private $technicalSolutions;
	/**
	 * @ORM\Column(type="text")
	 */
	private $description;
	// @var string
	private $place;

	/**
	 * @var array
	 * @ORM\ManyToMany(targetEntity="Actor")
	 * @ORM\JoinTable(name="projects_actors",
	 *	  joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id", onDelete="CASCADE")},
	 *	  inverseJoinColumns={@ORM\JoinColumn(name="actor_id", referencedColumnName="id", onDelete="CASCADE")}
	 *	  )
	 */
	private $actors;

	public function __construct()
	{
		$this->technicalSolutions = new ArrayCollection();
		$this->actors = new ArrayCollection();
		$this->location = new Coordinate(0.0,0.0); // Default value of location is Equator :o
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
	 * Set place. To be converted to Location??
	 *
	 * @param string $place
	 *
	 * @return Project
	 */
	public function setPlace($place)
	{
		$this->place = $place;

		return $this;
	}

	/**
	 * Get place
	 *
	 * @return string
	 */
	public function getPlace()
	{
		return $this->place;
	}


	/**
	 * Set field
	 *
	 * @param string $field
	 *
	 * @return Project
	 */
	public function setField($field)
	{
		$this->field = $field;

		return $this;
	}

	/**
	 * Get field
	 *
	 * @return string
	 */
	public function getField()
	{
		return $this->field;
	}

	/**
	 * Set startdate
	 *
	 * @param \DateTime $startdate
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
	 * @return \DateTime
	 */
	public function getStartdate()
	{
		return $this->startdate;
	}

	/**
	 * Set enddate
	 *
	 * @param \DateTime $enddate
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
	 * @return \DateTime
	 */
	public function getEnddate()
	{
		return $this->enddate;
	}

	/**
	 * Set location from an array{latitude, longitude}
	 *
	 * @param Coordinate $location
	 *
	 * @return Project
	 */
	public function setLocation($location)
	{
		$this->location->setLatitude($location->getLatitude()); // does it work?
		$this->location->setLongitude($location->getLongitude()); // does it work?

		return $this;
	}

	/**
	 * Get location
	 *
	 * @return Coordinate
	 */
	public function getLocation()
	{
		return $this->location;
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
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getTechnicalSolutions()
	{
		return $this->technicalSolutions;  // \
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
	}}

