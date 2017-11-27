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

    public function setFormat($format){
        $supported = ['jpg', 'png', 'gif'];
        if(in_array($format, $supported)){
            $this->format = $format;
        }
    }

    public function getTrick(){
        return $this->trick;
    }
    public function setTrick($trick){
        $this->trick = $trick;
    }
}