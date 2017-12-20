<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 09/12/17
 * Time: 14:52
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\Trick\TrickVideo;
use AppBundle\Service\TrickImageUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

class TrickVideoListener
{

    /** @ORM\PostUpdate */
    public function postUpdate(TrickVideo $video, LifecycleEventArgs $args){

        if(count($video->getTricks()) === 0){

            $em = $args->getEntityManager();
            $em->remove($video);

        }

    }

}
