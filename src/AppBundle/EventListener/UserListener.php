<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\User\User;
use AppBundle\Service\ImageUploader;
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
        $pwd = $this->encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($pwd);

        // Hydratation de img selon user
        $img = $user->getImg();
        $img->setName($user->getFullName());
        $img->setAlt("Photo de {$user->getFullName()}");

        $this->uploader->upload($img);
    }


    /** @ORM\PreFlush */
    public function preFlush(User $user)
    {
        // TODO : Fix fixture problem at preflush (or optimize user_edit)
//        if(!is_null($user->getId())){
//
//            // En cas de changement de la photo
//            if(!is_null($user->getImg()->getFile())){
//                $this->uploader->replace($user->getImg());
//            }
//
//            // En cas de changement de mot de passe
//            if(!is_null($user->getPlainPassword())){
//                // Chiffrement et assignation du mdp renseigné
//                $pwd = $this->encoder->encodePassword($user, $user->getPlainPassword());
//                $user->setPassword($pwd);
//            }
//
//        }

    }

    public function getUploader(){
        return $this->uploader;
    }

}
