<?php
namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Media
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
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="format", type="string", length=255)
     */
    private $format;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

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

    public function getPath(){
        return $this->path;
    }

    public function setPath($path){
        $this->path = $path;
        return $this;
    }

    public function getFormat(){
        return $this->format;
    }

    public function getAlt(){
        return $this->alt;
    }
    public function setAlt($alt){
        $this->alt = $alt;
    }

}