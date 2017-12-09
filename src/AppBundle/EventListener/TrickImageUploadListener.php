<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 09/12/17
 * Time: 14:52
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\Media\TrickImage;
use AppBundle\Service\Sluggifier;
use AppBundle\Service\TrickImageFileUpload;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;

class TrickImageUploadListener
{
    private $uploader;
    private $sluggifier;

    public function __construct(TrickImageFileUpload $uploader, Sluggifier $sluggifier)
    {
        $this->uploader = $uploader;
        $this->sluggifier = $sluggifier;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $img = $args->getEntity();
        if(!$img instanceof TrickImage) return;

        $file = $img->getFile();
        if(!$file instanceof UploadedFile) return;

        $img->setFormat($file->guessExtension());
        $img->setName($this->sluggifier->sluggify($img->getName()));

        $this->uploader->upload($file, $img->getFullName());
    }

}