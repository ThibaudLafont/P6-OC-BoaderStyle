<?php
namespace AppBundle\Entity\Media;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrickMedia
 *
 * @ORM\Table(name="trick_video")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrickVideoRepository")
 */
class TrickVideo extends TrickMedia
{

    // CONSTS
    const WEB_DIRECTORY = '/web/video/tricks/';
    const VALID_FORMATS = ['mp4', 'avi'];

}