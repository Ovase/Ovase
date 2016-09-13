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
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
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
     */
    private $lastName;
    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank(message="Dette feltet kan ikke være tomt.")
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $picture_path;
    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank(message="Dette feltet kan ikke være tomt.")
     */
    private $phone;
    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=45, unique=true)
     * @Assert\NotBlank(message="Dette feltet kan ikke være tomt.")
     * @Assert\Email(message="Ikke gyldig e-post.")
     */
    private $email;
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     * @ORM\JoinColumn(onDelete="cascade")
     * @Assert\Valid
     */
    private $roles; // Revise this.
    /**
     * @ORM\column(type="string", nullable=true)
     */
    private $new_user_code;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->fieldOfStudy = new ArrayCollection();
        $this->certificateRequests = new ArrayCollection();
        $this->isActive = false;
        $this->picture_path = 'images/defaultProfile.png';
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
    public function getEmail()
    {
        return $this->email;
    }
    public function getIsActive()
    {
        return $this->isActive;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
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
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }
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
     * @param Role $roles
     *
     * @return User
     */
    public function addRole(Role $roles)
    {
        $this->roles[] = $roles;
        return $this;
    }
    /**
     * Remove roles.
     *
     * @param Role $roles
     */
    public function removeRole(Role $roles)
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

}