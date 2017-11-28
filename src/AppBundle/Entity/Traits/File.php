<?php
namespace AppBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

abstract class File
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
     * @ORM\Column(name="format", type="string", length=255)
     */
    private $format;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    // CONSTS
    const WEB_DIRECTORY = 'web/directory/for/this/type/of/file';
    const VALID_FORMATS = ['expected', 'formats'];

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
    public function setFormat($format){
        if(in_array($format, self::VALID_FORMATS))  $this->format = $format;
    }

    public function getAlt(){
        return $this->alt;
    }
    public function setAlt($alt){
        $this->alt = $alt;
    }

    public function getUrl(){
        $url = '/web/media' . $this->getPath() . $this->getName() . '.' . $this->getFormat();
        return $url;
    }

}