<?php

namespace AppBundle\Entity\Message;

use AppBundle\Entity\Trick\Trick;
use AppBundle\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Message
 * Entity used to persist trick's messages posted by authentificated users
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 * @ORM\EntityListeners({"AppBundle\EventListener\MessageListener"})
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
     * Creation date of the message
     *
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     * @Assert\DateTime()
     */
    private $creationDate;

    /**
     * Content of the message
     *
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\Length(
     *      max = 500,
     *      maxMessage = "La description doit faire au maximum {{ limit }} caractères"
     * )
     */
    private $content;

    /**
     * User who post the mesage
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\User", inversedBy="messages")
     */
    private $user;

    /**
     * Trick related to the message
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Trick\Trick", inversedBy="messages")
     */
    private $trick;

    /**
     * Format the creation date to the french format
     *
     * @return string
     */
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

