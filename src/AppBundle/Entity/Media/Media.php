<?php
namespace AppBundle\Entity\Media;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Parent of every media
 *
 * @ORM\MappedSuperclass()
 */
abstract class Media
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank(
     *     groups={"trick"},
     *     message="Le nom est obligatoire"
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 55,
     *      minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom doit faire moins de {{ limit }} caractères"
     * )
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     * @Assert\NotBlank(
     *     message="La description alternative est obligatoire",
     *     groups={"trick"}
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 55,
     *      minMessage = "La description alternative doit faire au moins {{ limit }} caractères",
     *      maxMessage = "La description alternative doit faire moins de {{ limit }} caractères"
     * )
     */
    protected $alt;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $length = strlen($name);
        if($length>0 && $length<256){
            $this->name = $name;
        }
        return $this;
    }

    public function getAlt(){
        return $this->alt;
    }
    public function setAlt($alt){
        $this->alt = $alt;
    }
}
