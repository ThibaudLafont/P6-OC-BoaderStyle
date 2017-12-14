<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\User\User;
use AppBundle\Service\ImageUploader;
use AppBundle\Service\Uploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserListener
{

    private $uploader;

    public function __construct(ImageUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /** @ORM\PrePersist */
    public function prePersist(User $user, LifecycleEventArgs $args)
    {
//        // Chiffrement et assignation du mdp renseigné
//        $pwd = $encoder->encodePassword($user, $user->getPlainPassword());
//        $user->setPassword($pwd);

        // Hydratation de img selon user
        $img = $user->getImg();
        $img->setName($user->getFullName());
        $img->setAlt("Photo de {$user->getFullName()}");

        $this->uploader->upload($img);
    }

    public function getUploader(){
        return $this->uploader;
    }

}