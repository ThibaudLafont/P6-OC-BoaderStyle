<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\User\User;
use AppBundle\Service\ImageUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserListener
 * Execute actions when Doctrine work with TrickImage entities
 *
 * @package AppBundle\EventListener
 */
class UserListener
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /** @ORM\PrePersist */
    public function prePersist(User $user, LifecycleEventArgs $args)
    {

        // Chiffrement et assignation du mdp renseigné
        $pwd = $this->encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($pwd);

        // Hydratation de img selon user
        $img = $user->getImg();
        $img->setName($user->getFullName());
        $img->setAlt("Photo de {$user->getFullName()}");
        // Get EM and ask for UserImagePersist (Call UserImageListener prePersist)
        $args->getEntityManager()->persist($img);

    }

    /** @ORM\PreFlush */
    public function preFlush(User $user)
    {

        // In case of password change
        if(!is_null($user->getPlainPassword())){

            // Chiffrement et assignation du mdp renseigné
            $pwd = $this->encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($pwd);

        }

    }

}
