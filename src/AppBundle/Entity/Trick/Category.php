<?php

namespace AppBundle\Entity\Trick;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Validator\Constraints as AppAssert;

/**
 * Category
 * Groups where tricks are stored
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @ORM\EntityListeners({"AppBundle\EventListener\CategoryListener"})
 *
 * @UniqueEntity(
 *     "name",
 *     message="Cette catégorie existe déjà"
 * )
 */
class Category
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
     * Name of the category
     *
     * @var string
     *
     * @ORM\Column(
     *     name="name",
     *     type="string",
     *     length=255,
     *     unique=true
     * )
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom doit faire moins de {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @var string
     *
     *
     * @ORM\Column(
     *     name="slug_name",
     *     type="string",
     *     length=255,
     *     unique=true
     * )
     */
    private $slugName;

    /**
     * Tricks belong to the category
     *
     * @ORM\OneToMany(
     *     targetEntity="Trick",
     *     mappedBy="category"
     * )
     * @ORM\OrderBy({"name"="ASC"})
     */
    private $tricks;

    ///////////////////
     ///// SPECIFIC ////
    ///////////////////

    public function getEditUrl(){
        return '/' . $this->getId() .  '/tricks/';
    }


    ///////////////////
    ///// SETTERS /////
    ///////////////////

    /**
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param Trick $trick
     *
     * @return Category
     */
    public function setTricks(Trick $trick){
        $this->tricks[] = $trick;

        return $this;
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Trick
     */
    public function getTricks(){
        return $this->tricks;
    }

    /**
     * @return string
     */
    public function getSlugName(): string
    {
        return $this->slugName;
    }

    /**
     * @param string $slugName
     */
    public function setSlugName(string $slugName)
    {
        $this->slugName = $slugName;
    }
}
