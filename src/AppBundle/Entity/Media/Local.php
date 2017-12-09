<?php
namespace AppBundle\Entity\Media;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 */
abstract class Local extends Resource
{

    /**
     * @var string
     *
     * @ORM\Column(name="format", type="string", length=255)
     */
    protected $format;

    /**
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\Image(
     *     mimeTypes={ "image/jpeg", "image/png" }
     * )
     */
    public $file;

    // CONSTS
    const WEB_DIRECTORY = '/root/path/to/web/directory/';
    const VALID_FORMATS = ['expected', 'formats'];

    public function getFormat(){
        return $this->format;
    }
    public function setFormat($format){
        if(in_array($format, static::VALID_FORMATS))  $this->format = $format;
    }

    public function getFile(){
        return $this->file;
    }
    public function setFile($file){
        $this->file = $file;
    }

    public function getUrl(){
        $url = static::WEB_DIRECTORY . $this->getFullName();
        return $url;
    }

    public function getFullName(){
        return $this->getName() . '.' . $this->getFormat();
    }
}