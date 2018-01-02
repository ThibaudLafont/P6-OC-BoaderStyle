<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 09/12/17
 * Time: 14:52
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\Trick\TrickImage;
use AppBundle\Entity\Trick\TrickVideo;
use AppBundle\Service\ImageUploader;
use AppBundle\Service\TrickImageUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TrickImageListener
 * Execute actions when Doctrine work with TrickImage entities
 *
 * @package AppBundle\EventListener
 */
class TrickImageListener
{
    /**
     * In order to move the uploaded file, we store the ImageUploader
     * @var ImageUploader
     */
    private $uploader;

    /**
     * TrickImageListener constructor.
     * Assign ImageUploader though depency injection
     *
     * @param ImageUploader $uploader
     */
    public function __construct(ImageUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * Ask the uploader to handle the upload of the media
     *
     * @ORM\PrePersist
     */
    public function prePersist(TrickImage $img)
    {
        $this->uploader->upload($img);
    }

    /**
     * If a TrickImage is modified, perform the uploader to update it attributes
     *
     * @ORM\PreUpdate
     */
    public function preUpdate(TrickImage $img, PreUpdateEventArgs $args)
    {
        // Check if the name has change
        if($args->hasChangedField('name')) {
            // If there is a change, ask the uploader for rename the img
            $this->uploader->renameImg($img, $args->getOldValue('name'));
        }
    }

    /**
     * After update Doctrine will check if this TrickImage is still related to a trick
     * If not Doctrine is call to remove the Img from DB and callback this->postRemove() method
     *
     * @ORM\PostUpdate
     */
    public function postUpdate(TrickImage $img, LifecycleEventArgs $args){

        // Check if TrickImage is related to a trick
        if(count($img->getTricks()) === 0){

            // If no related trick, get EntityManager and remove TrickImage
            $em = $args->getEntityManager();
            $em->remove($img); // this->postRemove() is called after remove

        }

    }

    /**
     * After a TrickImage removing from DB, ask the uploader for remove related file in /web
     *
     * @ORM\PostRemove
     */
    public function postRemove(TrickImage $img)
    {
        $this->uploader->remove($img);
    }

}
