<?php
namespace itsallagile\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Security\Core\User\UserInterface,
    Symfony\Component\Security\Core\User\EquatableInterface,
    Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity,
    Symfony\Component\Validator\Constraints as Assert,
    Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user") 
 * @UniqueEntity("email")
 */
class User implements UserInterface, EquatableInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $userId;
    
    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\Email()
     */
    protected $email;
    
    /**
     * @ORM\Column(type="string", length=255) 
     */
    protected $fullName;
    
    /**
     * @ORM\Column(type="string", length=255) 
     */
    protected $password;
    
    /**
     * @ORM\Column(type="string", length=32)
     */
    protected $salt;
    
    /**
     * @ORM\ManyToMany(targetEntity="Team", inversedBy="users") 
     * @ORM\JoinTable(name="teamUser", 
     *     joinColumns={@ORM\JoinColumn(name="userId", referencedColumnName="userId")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="teamId", referencedColumnName="teamId")})
     */
    protected $teams; 
    
    public function __construct()
    {
        $this->salt = md5(uniqid(null, true));
        
        $this->teams = new ArrayCollection();
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }
    
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }
    
    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }
    
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * Set fullName
     *
     * @param string $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }
    
    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Get fullName
     *
     * @return string 
     */
    public function getFullName()
    {
        return $this->fullName;
    }
    
    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @inheritDoc
     */
    public function isEqualTo(UserInterface $user)
    {
        return $this->getUsername() === $user->getUsername();
    }
    
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * Add teams
     *
     * @param itsallagile\CoreBundle\Entity\Team $teams
     */
    public function addTeam(\itsallagile\CoreBundle\Entity\Team $teams)
    {
        $this->teams[] = $teams;
    }
}