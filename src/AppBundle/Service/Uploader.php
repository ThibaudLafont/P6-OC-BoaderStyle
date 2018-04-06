<?php
namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Uploader
 * From the server project root dir given at construct, handle the upload of a file in a specified folder
 *
 * @package AppBundle\Service
 */
class Uploader
{

    /**
     * Store the server root dir to the symfony project
     * Have to be set in app/config/service.yml file
     *
     * @var String : Root server path to the project root directory
     */
    private $webRootDir;

    /**
     * Uploader constructor.
     * Store the given server root dir in attribute
     *
     * This value is autowire by register the web root dir parameter and the Uploader
     * definition in the service.yml app file
     *
     * @param String $webRootDir : Root server path to the project root directory
     */
    public function __construct(String $webRootDir)
    {
        $this->webRootDir = $webRootDir;
    }

    /**
     * Upload a given File from name and targeted web root dir
     *
     * @param $file      : File object to upload
     * @param $filename  : Name you want for the target file
     * @param $webPath   : Web path to folder (and not the server root path)
     */
    public function upload(File $file, $filename, $webPath)
    {
        // Call the move property of the given File instance
        $file->move(
            $this->getWebRootDir().$webPath,  // Specify the server root path to the target folder
            $filename                         // Specify the desired name for the file
        );
    }

    /**
     * Return the server path to the project web root dir
     *
     * @return String : Server root path to web server directory
     */
    public function getWebRootDir()
    {
        return $this->webRootDir;
    }

}
