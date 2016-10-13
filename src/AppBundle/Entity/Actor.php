<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Ivory\GoogleMap\Base\Coordinate;

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
	 * An array of two floats, a latitude (N) and a longitude (E)
	 * @var Coordinate
	 * @Assert\NotBlank,
	 */
	private $location;


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
	 * Set location from an array{latitude, longitude}
	 *
	 * @param array $location
	 *
	 * @return Project
	 */
	public function setLocation($location)
	{
		$this->location->setLatitude($location[0]); // does it work?
		$this->location->setLongitude($location[1]); // does it work?

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
}

