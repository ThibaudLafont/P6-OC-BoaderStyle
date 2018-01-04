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

/**
 * Class TrickVideoListener
 * Execute actions when Doctrine work with TrickVideos entities
 *
 * @package AppBundle\EventListener
 */
class TrickVideoListener
{

    /**
     * After a TrickVideo update, check if it's not a orphan one
     *
     * @ORM\PostUpdate
     */
    public function postUpdate(TrickVideo $video, LifecycleEventArgs $args){

        // Check if video is linked to a trick
        if(count($video->getTricks()) === 0){

            // If not related to anything, get EntityManager and remove the DB entry
            $em = $args->getEntityManager();
            $em->remove($video);

        }

    }

}
