<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Media\TrickImage;
use AppBundle\Entity\Media\TrickVideo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Figure
 *
 * @ORM\Table(name="trick")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrickRepository")
 */
class Trick
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(
     *      min = 2,
     *      max = 55,
     *      minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom doit faire moins de {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "La description doit faire au moins {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tricks")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="tricks")
     */
    private $category;

    /**
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Media\TrickImage",
     *     mappedBy="trick",
     *     cascade={"persist"}
     *     )
     */
    private $imgs;

    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Media\TrickVideo", mappedBy="trick")
     */
    private $videos;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="trick")
     */
    private $messages;


      ///////////////////
     ///// SPECIFIC ////
    ///////////////////

    /**
     * Return url to trick_show
     *
     * @return string
     */
    public function getUrl(){
        return '/trick/' . $this->getId();
    }

    /**
     * Return the 200 first characters of trick's description
     *
     * @return bool|string
     */
    public function getDescriptionFrag(){
        return substr($this->description, 0, 200);
    }


      ///////////////////
     ///// SETTERS /////
    ///////////////////

    /**
     * @param string $name
     *
     * @return Trick
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return Trick
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param User $author
     *
     * @return Trick
     */
    public function setAuthor(User $author){
        $this->author = $author;

        return $this;
    }

    /**
     * @param Category $category
     *
     * @return Trick
     */
    public function setCategory(Category $category){
        $this->category = $category;

        return $this;
    }

    /**
     * @param TrickImage $img
     *
     * @return Trick
     */
    public function setImgs(TrickImage $img){
        $this->imgs[] = $img;

        return $this;
    }

    /**
     * @param TrickVideo $video
     *
     * @return Trick
     */
    public function setVideos(TrickVideo $video){
        $this->videos[] = $video;

        return $this;
    }

    /**
     * @param Message $message
     *
     * @return Trick
     */
    public function setMessages(Message $message){
        $this->messages[] = $message;

        return $this;
    }


    ///////////////////
    ///// GETTERS /////
    ///////////////////

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return User
     */
    public function getAuthor(){
        return $this->author;
    }

    /**
     * @return Category
     */
    public function getCategory(){
        return $this->category;
    }

    /**
     * @return TrickImage
     */
    public function getImgs()
    {
        return $this->imgs;
    }

    /**
     * @return TrickVideo
     */
    public function getVideos(){
        return $this->videos;
    }

    /**
     * @return Message
     */
    public function getMessages(){
        return $this->messages;
    }
}

