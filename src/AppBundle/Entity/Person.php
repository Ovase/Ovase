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
     * @ORM\ManyToMany(targetEntity="Company", mappedBy="persons")
     */
    private $companies;

    public function __construct() {
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
    /**
     * Remove companies.
     *
     * @param Company $company
     */
    public function removeCompany($company)
    {
        $this->companies->removeElement($company);
    }
    /**
     * Get companies
     *
     * @return \doctrine\common\collections\collection
     */
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


}
