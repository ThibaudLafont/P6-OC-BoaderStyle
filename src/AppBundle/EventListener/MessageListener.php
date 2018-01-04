<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 09/12/17
 * Time: 14:52
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\Message\Message;
use AppBundle\Entity\Trick\Trick;
use AppBundle\Service\TrickImageUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class MessageListener
 * Execute actions when Doctrine work with Messages entities
 *
 * @package AppBundle\EventListener
 */
class MessageListener
{
    /**
     * Need to access to the session user, so inject token storage depency
     *
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * MessageListener constructor.
     * Depency injection of TokenStorageInterface
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Before Message persist, assign user and creation date
     *
     * @ORM\PrePersist
     */
    public function prePersist(Message $message)
    {
        // Get user from auth session and assign
        $user = $this->tokenStorage->getToken()->getUser();
        $message->setUser($user);

        // Create a new dateTime for creation date and assign
        $now =  new \DateTime(
            'now',
            new \DateTimeZone('Europe/Paris')
        );
        $message->setCreationDate($now);
    }
}
