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

class TrickImageListener
{
    private $uploader;

    public function __construct(ImageUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /** @ORM\PrePersist */
    public function prePersist(TrickImage $img)
    {
        $this->uploader->upload($img);
    }

    /** @ORM\PreUpdate */
    public function preUpdate(TrickImage $img, PreUpdateEventArgs $args)
    {
        if($args->hasChangedField('name')) {
            $this->uploader->renameImg($img, $args->getOldValue('name'));
        }
    }

    /** @ORM\PostUpdate */
    public function postUpdate(TrickImage $img, LifecycleEventArgs $args){

        if(count($img->getTricks()) === 0){

            $em = $args->getEntityManager();
            $em->remove($img);

        }

    }

    /** @ORM\PostRemove */
    public function postRemove(TrickImage $img)
    {
        $this->uploader->remove($img);
    }

}
