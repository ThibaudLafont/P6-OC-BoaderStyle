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
    private $encoder;

    public function __construct(ImageUploader $uploader, UserPasswordEncoderInterface $encoder)
    {
        $this->uploader = $uploader;
        $this->encoder = $encoder;
    }

    /** @ORM\PrePersist */
    public function prePersist(User $user)
    {
        // Chiffrement et assignation du mdp renseigné
//        $pwd = $this->encoder->encodePassword($user, $user->getPlainPassword());
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
