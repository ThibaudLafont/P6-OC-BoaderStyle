<?php
namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader
{

    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file, $filename)
    {
        $file->move(
            $this->getTargetDir(),
            $filename
        );
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }

}