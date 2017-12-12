<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\User\User;
use AppBundle\Service\Uploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

class UserListener
{

    private $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /** @ORM\PrePersist */
    public function prePersist(User $user, LifecycleEventArgs $args)
    {
        // Chiffrement et assignation du mdp renseigné
        $user->setPassword(sha1($user->getPlainPassword()));

        // Hydratation de img selon user
        $img = $user->getImg();
//        $img->setName($user->getFullName());
        $img->setAlt("Photo de {$user->getFullName()}");

        $file = $img->getFile();
        $imgName = 'test';
        $imgExt = $file->guessExtension();

        $img->setFormat($imgExt);
        $img->setName($imgName);

        $this->getUploader()->upload(
            $file,
            $img->getFullName(),
            $img->getWebDir()
        );
    }

    public function getUploader(){
        return $this->uploader;
    }

}