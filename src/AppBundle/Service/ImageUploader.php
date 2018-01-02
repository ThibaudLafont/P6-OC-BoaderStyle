<?php
namespace AppBundle\Service;

use AppBundle\Entity\Media\Local;
use AppBundle\Entity\Trick\TrickImage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ImageUploader
 * This class is used to handle the AppBundle\Media\Local object upload
 *
 * @package AppBundle\Service
 */
class ImageUploader
{

    /**
     * Store an Uploader instance
     *
     * @var Uploader
     */
    private $uploader;
    /**
     * Store a Sluggifier instance
     *
     * @var Sluggifier
     */
    private $sluggifier;


    /**
     * ImageUploader constructor.
     * Store a sluggifier and an uploader instances in own attributes though dependency injection
     *
     * @param Uploader $uploader
     * @param Sluggifier $sluggifier
     */
    public function __construct(Uploader $uploader, Sluggifier $sluggifier)
    {
        $this->sluggifier = $sluggifier;
        $this->uploader = $uploader;
    }

    /**
     * Sluggify and set the media name of given img
     * Upload the image file in target web root path from Local entity attributes
     *
     * @param Local $img
     */
    public function upload(Local $img)
    {
        // Work on the given entity
        $imgName = $this->getSluggifier()->sluggify($img->getName());  // Get, sluggify and reassign the given image name
        $file = $img->getFile();                                       // Get the file from image entity
        $img->setFormat($file->guessExtension());                      // Set the image extension from given file extension
        $img->setName($imgName);

        // Move the uploaded file from image instance attributes
        $this->getUploader()->upload(
            $file,                // Uploaded file
            $img->getFullName(),  // Image full name (with path and extension)
            $img->getWebDir()     // Targeted web root dir for the file, given by Image entity
        );
    }

    /**
     * This property is used to rename an existent local image
     * The database update request is done though the doctrine listener
     *
     * @param TrickImage $img
     * @param $oldName
     */
    public function renameImg(TrickImage $img, $oldName){
        // Work on entity attributes
        $imgName = $this->getSluggifier()->sluggify($img->getName());  // Get the current name of the entity and sluggify it
        $img->setName($imgName);                                       // Set the sluggified name to the entity

        // TODO : should we specify and assign the new image extension ?

        // Define the actual and the wanted image full path
        $path = $this->getUploader()->getWebRootDir() . $img->getWebDir();  // Define the root path to image folder
        $newName = $path . $img->getFullName();                             // Store the new image full path
        $oldName = $path . $oldName .'.'. $img->getFormat();                // Store the old image full path

        // Ask to rename the image
        rename($oldName, $newName);
    }

    /**
     * Property used to remove file related to the given entity
     * Database update is done though the doctrine listener
     *
     * @param Local $img
     */
    public function remove(Local $img){
        // Define the path to img from given entity instance
        $imgPath =
            $this->getUploader()->getWebRootDir() . // Get server root path to project
            $img->getWebDir() .                     // Get image web dir
            $img->getFullName()                     // Get full name of the image (with extension)
        ;

        // Ask to delete the image file
        unlink($imgPath);
    }

    /**
     * Get sluggifier stored instance
     *
     * @return Sluggifier
     */
    public function getSluggifier(){
        return $this->sluggifier;
    }

    /**
     * Get uploader stored instance
     *
     * @return Uploader
     */
    public function getUploader(){
        return $this->uploader;
    }
}
