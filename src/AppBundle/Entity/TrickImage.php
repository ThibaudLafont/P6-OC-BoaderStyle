<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\Media;

/**
 * TrickMedia
 *
 * @ORM\Table(name="trick_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrickImageRepository")
 */
class TrickImage
{

    use Media;

    /**
     * @ORM\ManyToOne(targetEntity="Trick", inversedBy="imgs")
     */
    private $trick;

    private function setFormat(String $format){
        $supported = ['jpg', 'png', 'gif'];
        return in_array($format, $supported);
    }
}