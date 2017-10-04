<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 */
class Person extends Actor
{
	/**
	 * @var string
	 *
	 * @ORM\Column(name="first_name", type="string", length=100)
	 * @Assert\Type("string")
	 */
	private $firstName;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="last_name", type="string", length=100)
	 * @Assert\Type("string")
	 */
	private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=true)
     * @Assert\Email
     * @Assert\Type("string")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\Type("string")
     */
    private $workplace;

	/**
     * @ORM\ManyToMany(targetEntity="Company", mappedBy="persons")
     */
    private $companies;

    public function __construct() {
        parent::__construct(); // Not really necessary.
        $this->companies = new ArrayCollection();
    }
	/**
	 * Set firstName
	 *
	 * @param string $firstName
	 *
	 * @return Person
	 */
	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;

		return $this;
	}

	/**
	 * Get firstName
	 *
	 * @return string
	 */
	public function getFirstName()
	{
		return $this->firstName;
	}

	/**
	 * Set lastName
	 *
	 * @param string $lastName
	 *
	 * @return Person
	 */
	public function setLastName($lastName)
	{
		$this->lastName = $lastName;

		return $this;
	}

	/**
	 * Get lastName
	 *
	 * @return string
	 */
	public function getLastName()
	{
		return $this->lastName;
	}

	/**
	 * Get full name
	 *
	 * @return string
	 */
	public function getName()
    {
    	return $this->firstName . " " . $this->lastName;
    }

    public function addCompany($company)
    {
        $this->companies[] = $company;
        return $this;
    }
    public function removeCompany($company)
    {
        $this->companies->removeElement($company);
    }
    public function getCompanies()
    {
        return $this->companies;
    }

    /**
     * Get name of subclass. Used when viewing 
     *
     * @return string
     */
    public function getClassName()
    {
        return "Person";
    }



    /**
     * Set workplace
     *
     * @param string $workplace
     *
     * @return Person
     */
    public function setWorkplace($workplace)
    {
        $this->workplace = $workplace;

        return $this;
    }

    /**
     * Get workplace
     *
     * @return string
     */
    public function getWorkplace()
    {
        return $this->workplace;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Person
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
