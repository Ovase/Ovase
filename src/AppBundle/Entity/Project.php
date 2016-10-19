<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

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
	/**
	 * Field for storing the address of the project
	 * @ORM\Column(type="text")
	 */
	private $location;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="version", type="integer")
	 * @Assert\Type("integer")
	 */
	private $version = 0;

	/**
	 * @var array
	 * @ORM\ManyToMany(targetEntity="Actor")
	 * @ORM\JoinTable(name="projects_actors",
	 *	  joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id", onDelete="CASCADE")},
	 *	  inverseJoinColumns={@ORM\JoinColumn(name="actor_id", referencedColumnName="id", onDelete="CASCADE")}
	 *	  )
	 */
	private $actors;

    /**
     * @var array
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="user_can_edit_project",
     *      joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $users;

	public function __construct()
	{
		$this->technicalSolutions = new ArrayCollection();
		$this->actors = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * @return array
     */
    public function getActors()
    {
        return $this->actors;
    }

    /**
     * Add Users.
     *
     * @param user $user
     *
     * @return Project
     */
    public function addUser($user)
    {
        $this->users[] = $user;
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
     * @return array
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Remove Users.
     *
     * @param user $user
     */
    public function removeUser($user)
    {
        $this->users->removeElement($user);
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

}
