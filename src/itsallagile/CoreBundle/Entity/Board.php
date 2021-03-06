<?php

namespace itsallagile\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM, 
    Doctrine\Common\Collections\ArrayCollection,
    Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity,
    Symfony\Component\Validator\Constraints as Assert;
;

/**
 * @ORM\Entity
 * @ORM\Table(name="board") 
 * @UniqueEntity(fields={"slug"})
 */
class Board {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $boardId;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    protected $slug;
    
    /**
     * @ORM\OneToMany(targetEntity="Story", mappedBy="board")
     */
    protected $stories;
    
    public function __construct()
    {
        $this->stories = new ArrayCollection();
    }
    
    
    /**
     * Get boardId
     *
     * @return integer 
     */
    public function getBoardId()
    {
        return $this->boardId;
    }   

    /**
     * Set name
     *
     * @param text $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return text 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add stories
     *
     * @param itsallagile\CoreBundle\Entity\Story $stories
     */
    public function addStory(\itsallagile\CoreBundle\Entity\Story $stories)
    {
        $this->stories[] = $stories;
    }

    /**
     * Get stories
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getStories()
    {
        return $this->stories;
    }

    /**
     * Set slug
     *
     * @param text $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return text 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    public function getArray()
    {
        $data = array(
            'id' => $this->boardId,
            'name' => $this->name,
            'slug' => $this->slug
        );
        
        foreach ($this->getStories() as $story) {
            $data['stories'][] = $story->getArray(); 
        }
        return $data;
    }
}