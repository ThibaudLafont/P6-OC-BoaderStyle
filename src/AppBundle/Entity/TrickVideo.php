<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\Media;

/**
 * TrickMedia
 *
 * @ORM\Table(name="trick_video")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrickVideoRepository")
 */
class TrickVideo
{

    use Media;

    /**
     * @ORM\ManyToOne(targetEntity="Trick", inversedBy="imgs")
     */
    private $trick;

    private function setFormat(String $format){
        $supported = ['mp3', 'wav'];
        return in_array($format, $supported);
    }
}