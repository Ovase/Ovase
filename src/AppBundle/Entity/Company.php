<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompanyRepository")
 */
class Company extends Actor
{
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=100)
     * @Assert\Type("string")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="org_nr", type="string", length=18, unique=true)
     * @Assert\Type("string")
     */
    private $orgNr;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     * @Assert\Type("string")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Person", inversedBy="companies")
     * @ORM\JoinTable(name="person_in_company")
     */
    private $persons;

    public function __construct() {
        parent::__construct(); // Not needed? C2C: It's not in "Person"
        $this->persons = new ArrayCollection();
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Company
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
     * Set orgNr
     *
     * @param string $orgNr
     *
     * @return Company
     */
    public function setOrgNr($orgNr)
    {
        $this->orgNr = $orgNr;

        return $this;
    }

    /**
     * Get orgNr
     *
     * @return string
     */
    public function getOrgNr()
    {
        return $this->orgNr;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Company
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
     * Add persons.
     *
     * @param Person $person
     *
     * @return Company
     */
    public function addPerson($person)
    {
        $this->persons[] = $person;
        return $this;
    }
    /**
     * Remove persons.
     *
     * @param Person $person
     */
    public function removePerson($person)
    {
        $this->persons->removeElement($person);
    }
    /**
     * get persons
     *
     * @return \doctrine\common\collections\collection
     */
    public function getpersons()
    {
        return $this->persons;
    }
}
