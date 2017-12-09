<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 08/12/17
 * Time: 16:34
 */

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class TrickImageFileUpload
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