<?php

namespace AppBundle\Entity\Trick;

use AppBundle\Entity\Message\Message;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Validator\Constraints as AppAssert;


/**
 * Figure
 * Represent a trick object with his assets (media, author, messages)
 *
 * @ORM\Table(name="trick")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrickRepository")
 * @ORM\EntityListeners({"AppBundle\EventListener\TrickListener"})
 *
 * @UniqueEntity(
 *     "name",
 *     message="Ce titre est déjà pris. Vérifiez si la figure existe déjà sur le site !"
 * )
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
     * Name of the trick
     *
     * @var string
     * @ORM\Column(
     *     name="name",
     *     type="string",
     *     length=255,
     *     unique=true
     * )
     *
     * // Validators
     * @Assert\NotBlank(
     *     message="Le nom est obligatoire"
     * )
     * @AppAssert\AllowedTags(
     *     message="Aucune balise HTML ici..."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 55,
     *      minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom doit faire moins de {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * Trick's description
     *
     * @var string
     *
     * @ORM\Column(
     *     name="description",
     *     type="text"
     * )
     *
     * // Validators
     * @Assert\NotBlank(
     *     message="Le nom est obligatoire"
     * )
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "La description doit faire au moins {{ limit }} caractères"
     * )
     * @AppAssert\AllowedTags(
     *     allowedTags = "<h3><h2><br>"
     * )
     */
    private $description;

    /**
     * User who post or edit the trick
     *
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\User\User",
     *     inversedBy="tricks"
     * )
     */
    private $author;

    /**
     * The trick belong to a category, which is this property
     *
     * @ORM\ManyToOne(
     *     targetEntity="Category",
     *     inversedBy="tricks"
     * )
     * @Assert\NotBlank(
     *     message="Veuillez choisir une catégorie"
     * )
     */
    private $category;

    /**
     *
     * @ORM\ManyToMany(
     *     targetEntity="TrickImage",
     *     mappedBy="trick",
     *     cascade={"persist", "remove"}
     * )
     * @Assert\NotNull(
     *     message="Une image principale est demandée"
     * )
     * @Assert\Valid()
     */
    private $imgs;

    /**
     * Videos related to the trick
     *
     * @ORM\ManyToMany(
     *     targetEntity="TrickVideo",
     *     mappedBy="trick",
     *     cascade={"persist", "remove"}
     * )
     * @Assert\Valid()
     */
    private $videos;

    /**
     * Posted messages related to the trick
     *
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Message\Message",
     *     mappedBy="trick"
     * )
     * @Assert\Valid()
     */
    private $messages;

    /**
     * Trick constructor.
     * Create to ArrayCollections for medias attributes
     */
    public function __construct()
    {
        $this->imgs = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

      ///////////////////
     ///// SPECIFIC ////
    ///////////////////

    /**
     * @Assert\IsTrue(message="Une image principale est requise")
     */
    public function isImgsValid()
    {
        return $this->getImgs()->count() !== 0;
    }

    /**
     * Return url to trick_show
     *
     * @return string
     */
    public function getUrl(){
        return '/trick/' . $this->getId();
    }

    /**
     * Add a new TrickImage to the ArrayCollection
     * @param TrickImage $img
     */
    public function addImg(TrickImage $img){
        if($img->getId() === null) $img->addTrick($this);
        $this->imgs->add($img);
    }

    /**
     * Remove a specified image of the ArrayCollection
     * @param TrickImage $img
     */
    public function removeImg(TrickImage $img){
        $img->removeTrick($this);
        $this->imgs->removeElement($img);
    }

    /**
     * Add a new video related to the trick
     * @param TrickVideo $video
     */
    public function addVideo(TrickVideo $video){
        if($video->getId() === null) $video->addTrick($this);
        $this->videos->add($video);
    }

    /**
     * Remove an existent video related to the trick
     * @param TrickVideo $video
     */
    public function removeVideo(TrickVideo $video){
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
    public function getMessages($start = null){

        if(is_null($start)) return $this->messages;
        else return $this->messages->slice($start, 10);

    }
}
