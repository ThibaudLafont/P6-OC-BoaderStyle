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
     *     mimeTypes={ "image/jpeg", "image/png" },
     *     maxSize="150k",
     *     maxSizeMessage="Taille maximale : 150ko"
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

    /**
     * @Assert\IsTrue(message="Les fichiers des images sont nécessaires.")
     */
    public function isFileUploaded()
    {
        if(
            is_null($this->getId()) &&
            is_null($this->getFile())
        ) return false;
        return true;
    }

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
        if($this->getFormat() !== null){
            return $this->getWebDir() . $this->getFullName();
        }else{
            return null;
        }
    }

    public function getFullName(){
        return $this->getName() . '.' . $this->getFormat();
    }
}
