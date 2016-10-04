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
 *      fields={"id"},
 *      message="Denne ID er allerede i bruk.",
 * )
 *
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
     */
    private $name;
    /**
     * @ORM\Column(type="string", length=255)
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
     * @ORM\Column(type="string", length=45)
     */
    private $location;
    /**
     * 
     *
     * @ORM\Column(type="array")
     * @Assert\Valid
     */
    private $technicalSolutions;
    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ManyToMany(targetEntity="Actor")
     * @JoinTable(name="projects_actors",
     *      joinColumns={@JoinColumn(name="project_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="actor_id", referencedColumnName="id")}
     *      )
     */
    private $actors;

    public function __construct()
    {
        $this->technicalSolutions = new ArrayCollection();
        $this->actors = new ArrayCollection();
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
     * Set location
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
}

