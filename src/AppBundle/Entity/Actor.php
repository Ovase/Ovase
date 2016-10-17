<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Actor
 *
 * @ORM\Table(name="actor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActorRepository")
 *
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"actor" = "Actor", "person" = "Person", "company" = "Company"})
 */
class Actor
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
	 * @var string
	 *
	 * @ORM\Column(name="tlf", type="string", length=22, nullable=true)
	 */
	private $tlf;

	/**
	 * @var array
	 *
	 * @ORM\Column(name="images", type="array")
	 * @Assert\All({
	 *	 @Assert\NotBlank,
	 *	 @Assert\Url
	 * })
	 */
	private $images;

	/**
	 * @var array
	 *
	 * @ORM\Column(name="key_knowledges", type="array")
	 * @Assert\All({
	 *	 @Assert\NotBlank,
	 *	 @Assert\Length(min = 3)
	 * })
	 */
	private $keyKnowledges;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="field", type="string", length=255, nullable=true)
	 * @Assert\Type("string")
	 */
	private $field;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=45)
	 * @Assert\Email
	 * @Assert\Type("string")
	 */
	private $email;
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

	public function __construct()
	{
		$this->keyKnowledges = new ArrayCollection();
		$this->images = new ArrayCollection();
		$this->location = new ArrayCollection();
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
	 * Set tlf
	 *
	 * @param string $tlf
	 *
	 * @return Actor
	 */
	public function setTlf($tlf)
	{
		$this->tlf = $tlf;

		return $this;
	}

	/**
	 * Get tlf
	 *
	 * @return string
	 */
	public function getTlf()
	{
		return $this->tlf;
	}

	/**
	 * Set images
	 *
	 * @param array $images
	 *
	 * @return Actor
	 */
	public function setImages($images)
	{
		$this->images = $images;

		return $this;
	}

	/**
	 * Get images
	 *
	 * @return array
	 */
	public function getImages()
	{
		return $this->images;
	}

	/**
	 * Set keyKnowledges
	 *
	 * @param array $keyKnowledges
	 *
	 * @return Actor
	 */
	public function setKeyKnowledges($keyKnowledges)
	{
		$this->keyKnowledges = $keyKnowledges;

		return $this;
	}

	/**
	 * Get keyKnowledges
	 *
	 * @return array
	 */
	public function getKeyKnowledges()
	{
		return $this->keyKnowledges;
	}

	/**
	 * Set field
	 *
	 * @param string $field
	 *
	 * @return Actor
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
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}
	/**
	 * Set email
	 *
	 * @param string $email
	 *
	 * @return Actor
	 */
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
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
}

