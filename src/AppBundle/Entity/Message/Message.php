<?php

namespace AppBundle\Entity\Message;

use AppBundle\Entity\Trick\Trick;
use AppBundle\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
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
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\User", inversedBy="messages")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Trick\Trick", inversedBy="messages")
     */
    private $trick;

    public function getFrenchDate(){
        return $this->getCreationDate()->format('d/m/y à H:i');
    }

    ///////////////////
    ///// SETTERS /////
    ///////////////////

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Message
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Message
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param Trick $trick
     */
    public function setTrick(Trick $trick){
        $this->trick = $trick;
    }


    ///////////////////
    ///// GETTERS /////
    ///////////////////

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
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Trick
     */
    public function getTrick(){
        return $this->trick;
    }
}

