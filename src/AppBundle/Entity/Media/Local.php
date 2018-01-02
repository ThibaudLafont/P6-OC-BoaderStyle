<?php
namespace AppBundle\Entity\Media;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * This class is the parent of every media wich is stored on a local server
 *
 * @ORM\MappedSuperclass()
 */
abstract class Local extends Media
{

    /**
     * Hold the extension of the file
     *
     * @var string
     *
     * @ORM\Column(name="format", type="string", length=255)
     */
    protected $format;

    /**
     * @Assert\Image(
     *     mimeTypesMessage="Les seuls formats acceptés sont JPG et PNG",
     *     mimeTypes={ "image/jpeg", "image/png" }
     * )
     */
    public $file;

    // CONSTS

    /**
     * Root web path
     */
    const WEB_DIRECTORY = '/root/path/to/web/directory/';

    /**
     * Allowed extensions
     */
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

    public function getWebDir(){
        return static::WEB_DIRECTORY;
    }

    public function getUrl(){
        if($this->getId() !== null){
            return $this->getWebDir() . $this->getFullName();
        }
    }

    public function getFullName(){
        return $this->getName() . '.' . $this->getFormat();
    }
}
