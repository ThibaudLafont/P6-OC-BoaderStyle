<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Media\TrickImage;
use AppBundle\Entity\Media\TrickVideo;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\ManyToMany(
     *     targetEntity="\AppBundle\Entity\Media\TrickImage",
     *     mappedBy="trick",
     *     cascade={"persist", "remove"}
     *     )
     */
    private $imgs;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="\AppBundle\Entity\Media\TrickVideo",
     *     mappedBy="trick",
     *     cascade={"persist", "remove"}
     * )
     */
    private $videos;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="trick")
     */
    private $messages;

    public function __construct()
    {
        $this->imgs = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }

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

    public function addImg(TrickImage $img){
        $this->imgs->add($img);
    }
    public function removeImg(TrickImage $img){
        $img->removeTrick($this);
        $this->imgs->removeElement($img);
    }


    public function addVideo(TrickVideo $video){
        $this->videos->add($video);
    }
    public function removeVideos(TrickVideo $video){
        echo 'coucou';
        $video->removeTrick($this);
        $this->videos->removeElement($video);
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

