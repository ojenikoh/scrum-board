<?php
namespace itsallagile\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="team") 
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $teamId;
    
    /**
     * @ORM\Column(type="integer", length=11)
     */
    protected $owner;
    
    /**
     * @ORM\Column(type="string", length=255) 
     */
    protected $name;
    
    /**
     * @ORM\Column(type="integer", length=11) 
     */
    protected $velocity;
    
    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="teams") 
     * 
     */
    protected $users;
    
    /**
     * @ORM\OneToMany(targetEntity="Invitation", mappedBy="team")
     */
    protected $invitations;
    
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->invitations = new ArrayCollection();
    }
    
    /**
     * Get teamId
     * @return integer 
     */
    public function getTeamId()
    {
        return $this->teamId;
    }
    
    /**
     * Set Owner
     * @param integer $owner 
     */
    public function setOwner($owner)
    {
        $this->owner = (int)$owner;
    }
    
    /**
     * get owner
     * @return integer 
     */
    public function getOwner()
    {
        return $this->owner;
    }
    
    /**
     * Set name
     * @param string $name 
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Get name
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set Velocity
     * @param integer $velocity 
     */
    public function setVelocity($velocity)
    {
        $this->velocity = $velocity;
    }
    
    /**
     * Get velocity
     * @return integer 
     */
    public function getVelocity()
    {
        return $this->velocity;
    }
    
    public function getUsers()
    {
        return $this->users;
    }
    
    public function getInvitations()
    {
        return $this->invitations;
    }
    
    public function setInvitations(ArrayCollection $invitations)
    {
        $this->invitations = $invitations;
    }
    
    public function addInvitation(\itsallagile\CoreBundle\Entity\Invitation $invitation)
    {
        $this->getInvitations()->add($invitation);
    }

    /**
     * Add users
     *
     * @param itsallagile\CoreBundle\Entity\User $users
     */
    public function addUser(\itsallagile\CoreBundle\Entity\User $users)
    {
        $this->users[] = $users;
    }
}