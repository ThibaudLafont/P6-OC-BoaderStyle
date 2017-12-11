<?php
namespace AppBundle\Service;

use AppBundle\Entity\Media\TrickImage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TrickImageUploader extends Uploader
{

    private $sluggifier;

    public function __construct($targetDir, Sluggifier $sluggifier)
    {
        parent::__construct($targetDir);
        $this->sluggifier = $sluggifier;
    }

    public function uploadImg(TrickImage $img)
    {
        $file = $img->getFile();
        $imgName = $this->getSluggifier()->sluggify($img->getName());
        $imgExt = $file->guessExtension();

        $img->setFormat($imgExt);
        $img->setName($imgName);

        $this->upload($file, $img->getFullName());
    }

    public function renameImg(TrickImage $img, $oldName){
        $imgName = $this->getSluggifier()->sluggify($img->getName());
        $img->setName($imgName);

        $path = $this->getTargetDir().'/';
        $newName = $path . $img->getFullName();
        $oldName = $path . $oldName .'.'. $img->getFormat();

        rename($oldName, $newName);
    }

    public function removeImg(TrickImage $img){
        $imgPath = $this->getTargetDir().'/'.$img->getFullName();
        unlink($imgPath);
    }

    public function getSluggifier(){
        return $this->sluggifier;
    }

}