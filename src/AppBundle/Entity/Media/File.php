<?php
namespace AppBundle\Entity\Media;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class File
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
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="format", type="string", length=255)
     */
    protected $format;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    protected $alt;

    // CONSTS
    const WEB_DIRECTORY = '/root/path/to/web/directory/';
    const VALID_FORMATS = ['expected', 'formats'];

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

    public function getFormat(){
        return $this->format;
    }
    public function setFormat($format){
        if(in_array($format, static::VALID_FORMATS))  $this->format = $format;
    }

    public function getAlt(){
        return $this->alt;
    }
    public function setAlt($alt){
        $this->alt = $alt;
    }

    public function getUrl(){
        $url = static::WEB_DIRECTORY . $this->getName() . '.' . $this->getFormat();
        return $url;
    }

}