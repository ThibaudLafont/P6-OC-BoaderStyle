<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 09/12/17
 * Time: 14:52
 */

namespace AppBundle\EventListener;

use AAppBundle\Entity\Message\Message;
use AppBundle\Entity\Trick\Trick;
use AppBundle\Service\TrickImageUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MessageListener
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /** @ORM\PrePersist */
    public function prePersist(Message $message)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $now =  new \DateTime(
            'now',
            new \DateTimeZone('Europe/Paris')
        );

        $message->setUser($user);
        $message->setCreationDate($now);
    }
}
