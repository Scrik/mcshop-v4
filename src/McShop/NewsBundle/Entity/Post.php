<?php

namespace McShop\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use McShop\UserBundle\Entity\User;

/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="McShop\NewsBundle\Repository\PostRepository")
 */
class Post
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
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="less_content", type="text", nullable=true)
     */
    private $lessContent;

    /**
     * @var string
     *
     * @ORM\Column(name="full_content", type="text")
     */
    private $fullContent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetimetz")
     */
    private $createdAt;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="McShop\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var Commentary
     * @ORM\OneToMany(targetEntity="Commentary", mappedBy="news")
     */
    private $commentaries;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return Post
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set lessContent
     *
     * @param string $lessContent
     * @return Post
     */
    public function setLessContent($lessContent)
    {
        $this->lessContent = $lessContent;

        return $this;
    }

    /**
     * Get lessContent
     *
     * @return string 
     */
    public function getLessContent()
    {
        return $this->lessContent;
    }

    /**
     * Set fullContent
     *
     * @param string $fullContent
     * @return Post
     */
    public function setFullContent($fullContent)
    {
        $this->fullContent = $fullContent;

        return $this;
    }

    /**
     * Get fullContent
     *
     * @return string 
     */
    public function getFullContent()
    {
        return $this->fullContent;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Post
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commentaries = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set user
     *
     * @param \McShop\UserBundle\Entity\User $user
     * @return Post
     */
    public function setUser(\McShop\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \McShop\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add commentaries
     *
     * @param \McShop\NewsBundle\Entity\Commentary $commentaries
     * @return Post
     */
    public function addCommentary(\McShop\NewsBundle\Entity\Commentary $commentaries)
    {
        $this->commentaries[] = $commentaries;

        return $this;
    }

    /**
     * Remove commentaries
     *
     * @param \McShop\NewsBundle\Entity\Commentary $commentaries
     */
    public function removeCommentary(\McShop\NewsBundle\Entity\Commentary $commentaries)
    {
        $this->commentaries->removeElement($commentaries);
    }

    /**
     * Get commentaries
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommentaries()
    {
        return $this->commentaries;
    }
}
