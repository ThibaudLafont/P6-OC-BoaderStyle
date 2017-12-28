<?php
namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader
{

    private $webRootDir;

    public function __construct(String $webRootDir)
    {
        $this->webRootDir = $webRootDir;
    }

    public function upload($file, $filename, $webPath)
    {
        $file->move(
            $this->getWebRootDir().$webPath,
            $filename
        );
    }

    public function getWebRootDir()
    {
        return $this->webRootDir;
    }

}
