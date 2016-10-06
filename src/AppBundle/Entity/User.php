<?php
namespace AppBundle\Entity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * AppBundle\Entity\User.
 *
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(
 *      fields={"email"},
 *      message="Denne Eposten er allerede i bruk.",
 * )
 *
 */
class User implements AdvancedUserInterface, \Serializable
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
    private $lastName;
    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank(message="Dette feltet kan ikke være tomt.")
     * @Assert\Type("string")
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\Url(message = "'{{ value }}'er ikke en gyldig url")
     */
    private $picture_path;
    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank(message="Dette feltet kan ikke være tomt.")
     * @Assert\Type("string")
     */
    private $phone;
    /**
     * @ORM\Column(type="string", length=64, nullable=false)
     * @Assert\NotBlank(message="Dette feltet kan ikke være tomt.")
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=45, unique=true)
     * @Assert\NotBlank(message="Dette feltet kan ikke være tomt.")
     * @Assert\Email(message="Ikke gyldig e-post.")
     * @Assert\Type("string")
     */
    private $email;
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive; // Activated by an Admin
    /**
     * @ORM\Column(type="array")
     * @Assert\Valid
     * @Assert\All({
     *     @Assert\NotBlank(message="Dette feltet kan ikke være tomt."),
     *     @Assert\Length(min = 3),
	 *     @Assert\Choice({"ROLE_GUEST", "ROLE_USER", "ROLE_ADMIN", "ROLE_EDITOR", "IS_AUTHENTICATED_FULLY"})
     * })
     */
    private $roles;
    /**
     * @ORM\column(type="string", nullable=true)
     */
    private $new_user_code;

    /**
     * The auto generated salt for the user
     *
     * The salt is stored as a 64 byte string
     *
     * @var string  $salt      the salt
     *
     * @ORM\Column(type="string", length = 64)
     */
    private $salt;

    /**
     * @ORM\OneToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    private $person;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->isActive = false;
        $this->picture_path = 'static/images/person/defaultprofile.png';
    }
    public function getId()
    {
        return $this->id;
    }
    public function getFirstName()
    {
        return $this->firstName;
    }
    public function getLastName()
    {
        return $this->lastName;
    }
    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstName().' '.$this->getLastName();
    }
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Hash and set the (hashed) password of the user
     *
     * @param string $password      the password, in hashed form
     * @param \Symfony\Component\Security\Core\Encoder\ $encoderFactory      encoder factory for hasher
     *
     * @return User      returns self after setting the password hash
     */
    public function setPassword($password)
    {
        // Set password to the hashed value (which is the controller's responsibility)
        $this->password = $password;

        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * Get the user's roles in the system.
     *
     * @return string[]
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }
    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }
    /**
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }
    /**
     * Set picture_path.
     *
     * @param string $picturePath
     *
     * @return User
     */
    public function setPicturePath($picturePath)
    {
        $this->picture_path = $picturePath;
        return $this;
    }
    /**
     * Get picture_path.
     *
     * @return string
     */
    public function getPicturePath()
    {
        return $this->picture_path;
    }
    /**
     * Set phone.
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }
    /**
     * Get phone.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Add roles.
     *
     * @param string $roles
     *
     * @return User
     */
    public function addRole($roles)
    {
        $this->roles[] = $roles;
        return $this;
    }
    /**
     * Remove roles.
     *
     * @param string $roles
     */
    public function removeRole($roles)
    {
        $this->roles->removeElement($roles);
    }
    /**
     * Set new_user_code.
     *
     * @param string $newUserCode
     *
     * @return User
     */
    public function setNewUserCode($newUserCode)
    {
        $this->new_user_code = $newUserCode;
        return $this;
    }
    /**
     * Get new_user_code.
     *
     * @return string
     */
    public function getNewUserCode()
    {
        return $this->new_user_code;
    }

    // Used for unit testing 
    public function fromArray($data = array())
    {
        foreach ($data as $property => $value) {
            $method = "set{$property}";
            $this->$method($value);
        }
    }
    // toString method used to display the user in twig files. TODO: Copy into person entity
    public function __toString()
    {
        $firstName = $this->getFirstName();
        $lastName = $this->getLastName();
        return "$firstName $lastName";
    }
    /*
    
    You may or may not need the code below depending on the algorithm you chose to hash and salt passwords with.
    The methods below are taken from the login guide on Symfony.com, which can be found here:
    http://symfony.com/doc/current/cookbook/security/form_login_setup.html
    http://symfony.com/doc/current/cookbook/security/entity_provider.html

    */
    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    { // TODO: Implement this method, if time allows.
    }
    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
                // see section on salt below
                // $this->salt,
        ));
    }
    /**
     * @see \Serializable::unserialize(
     */
    public function unserialize($serialized)
    {
        list(
                $this->id,
                $this->email,
                $this->password,
                // see section on salt below
                // $this->salt
                ) = unserialize($serialized);
    }
    // Extra, optional authentication functionality
	public function isAccountNonExpired()
    {
        return true;
    }
    public function isAccountNonLocked()
    {
        return true;
    }
    public function isCredentialsNonExpired()
    {
        return true;
    }
    public function isEnabled()
    {
        return $this->isActive;
    }
    /**
     * {@inheritdoc}. Sets the salt of the user
     *
     * @param string $salt  the salt
     *
     * @return User      returns self after setting the salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }
    /**
     * {@inheritdoc}. Gets the salt of the user
     *
     * @return string   the salt
     */
    public function getSalt()
    {
        return $this->salt;
    }


    /**
     * Get username by email.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
    }

}

