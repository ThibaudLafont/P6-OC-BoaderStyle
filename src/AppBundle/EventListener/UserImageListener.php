<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\Media\Local;
use AppBundle\Entity\User\User;
use AppBundle\Service\ImageUploader;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserImageListener
 * Execute actions when Doctrine work with TrickImage entities
 *
 * @package AppBundle\EventListener
 */
class UserImageListener
{

    /**
     * @var ImageUploader
     */
    private $uploader;

    public function __construct(ImageUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /** @ORM\PrePersist */
    public function prePersist(Local $img)
    {

        // Upload of img related file
        $this->uploader->upload($img);

    }

    /** @ORM\PreFlush */
    public function preFlush(Local $img)
    {

        // En cas de changement de mot de passe
        if(
            !is_null($img->getFile()) &&    // Check if a file has been given
            'cli' != php_sapi_name()
        ){
            $this->uploader->replace($img);
        }

    }

}
