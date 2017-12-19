<?php
namespace AppBundle\Service;

use AppBundle\Entity\Media\Local;
use AppBundle\Entity\Trick\TrickImage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader
{

    private $uploader;
    private $sluggifier;

    public function __construct(Uploader $uploader, Sluggifier $sluggifier)
    {
        $this->sluggifier = $sluggifier;
        $this->uploader = $uploader;
    }

    public function upload(Local $img)
    {
        $file = $img->getFile();
        $imgName = $this->getSluggifier()->sluggify($img->getName());
        $imgExt = $file->guessExtension();

        $img->setFormat($imgExt);
        $img->setName($imgName);

        $this->getUploader()->upload(
            $file,
            $img->getFullName(),
            $img->getWebDir()
        );
    }

    public function renameImg(TrickImage $img, $oldName){
        $imgName = $this->getSluggifier()->sluggify($img->getName());
        $img->setName($imgName);

        $path = $this->getUploader()->getWebRootDir() . $img->getWebDir();
        $newName = $path . $img->getFullName();
        $oldName = $path . $oldName .'.'. $img->getFormat();

        rename($oldName, $newName);
    }

    public function remove(Local $img){
        $imgPath = $this->getUploader()->getWebRootDir() . $img->getWebDir() . $img->getFullName();
        unlink($imgPath);
    }

    public function replace(Local $img){
        $this->remove($img);
        $this->upload($img);
    }

    public function getSluggifier(){
        return $this->sluggifier;
    }

    public function getUploader(){
        return $this->uploader;
    }
}
