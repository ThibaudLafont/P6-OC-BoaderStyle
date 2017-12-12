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
use AppBundle\Entity\User\User;
use AppBundle\Service\TrickImageUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class TrickImageListener
{
    private $uploader;

    public function __construct(TrickImageUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // TrickImage
        if($entity instanceof TrickImage) $this->uploader->uploadImg($entity);

    }


    public function preUpdate(PreUpdateEventArgs $args)
    {
        $img = $args->getEntity();

        if($img instanceof TrickImage && $args->hasChangedField('name')) {
            $this->uploader->renameImg($img, $args->getOldValue('name'));
        }
    }

    public function postUpdate(LifecycleEventArgs $args){

        $entity = $args->getEntity();
        if(!$entity instanceof TrickImage && !$entity instanceof TrickVideo) return;

        if(count($entity->getTricks()) === 0){

            $em = $args->getEntityManager();
            $em->remove($entity);

        }

    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $img = $args->getEntity();
        if($img instanceof TrickImage) $this->uploader->removeImg($img);
    }

}