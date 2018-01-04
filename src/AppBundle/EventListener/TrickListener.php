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

/**
 * Class TrickListener
 * Execute actions when Doctrine work with Trick entities
 *
 * @package AppBundle\EventListener
 */
class TrickListener
{
    /**
     * When a Trick is persisted or updated, this attribute is used in order to
     * fetch the user from session
     *
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * TrickListener constructor.
     * Assign tokenStorage Attribute though Depency Injection
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Before persisting a Trick, get user from session and assign it
     *
     * @ORM\PrePersist
     */
    public function prePersist(Trick $trick)
    {

        // Get the session
        $session = $this->tokenStorage->getToken();

        // If session exists, assign the user to the trick
        // ( we check if session exist cause of fixtures feature )
        if(!is_null($session)) $trick->setAuthor($session->getUser());

    }

    /**
     * Before updating a Trick, fetch and assign the user
     *
     * @ORM\PreUpdate
     */
    public function preUpdate(Trick $trick)
    {
        // Get user object from the session
        $author = $this->tokenStorage->getToken()->getUser();

        // Assign the user to the trick
        $trick->setAuthor($author);
    }

    /**
     * Before removing a Trick, check if messages exists and remove them if needed
     *
     * @ORM\PostRemove
     */
    public function postRemove(Trick $trick, LifecycleEventArgs $args)
    {
        // Get the EntityManager and ask it the trick's messages
        $em = $args->getEntityManager();
        $messages = $trick->getMessages();  // Store the messages

        // Remove found messages
        foreach($messages as $message){
            $em->remove($message);          // For each index, ask the message remove
        }

    }

}
