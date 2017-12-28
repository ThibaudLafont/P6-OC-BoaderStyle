<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 09/12/17
 * Time: 14:52
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\Trick\Trick;
use AppBundle\Service\TrickImageUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TrickListener
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /** @ORM\PrePersist */
    public function prePersist(Trick $trick)
    {

        $session = $this->tokenStorage->getToken();
        if(!is_null($session)) $trick->setAuthor($session->getUser());

    }

    /** @ORM\PreUpdate */
    public function preUpdate(Trick $trick)
    {
        $author = $this->tokenStorage->getToken()->getUser();

        $trick->setAuthor($author);
    }

    /** @ORM\PreRemove */
    public function preRemove(Trick $trick, LifecycleEventArgs $args)
    {
        $em = $args->getEntityManager();
        $messages = $trick->getMessages();

        foreach($messages as $message){
            $em->remove($message);
        }
    }

}
