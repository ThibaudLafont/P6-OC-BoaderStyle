<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\Media;

/**
 * TrickMedia
 *
 * @ORM\Table(name="cover_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CoverImageRepository")
 */
class CoverImage
{

    use Media;

    public function setFormat($format){
        $supported = ['jpg', 'png', 'gif'];
        if(in_array($format, $supported)){
            $this->format = $format;
        }
    }

}