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
     * @ORM\OneToOne(
     *     targetEntity="CoverImage",
     *     cascade={"persist", "remove"}
     * )
     */
    private $cover;

    /**
     * @ORM\ManyToOne(targetEntity="Trick", inversedBy="imgs")
     */
    private $trick;

    /**
     * @param String $format
     * @return bool
     */
    public function setFormat($format){
        $supported = ['mp3', 'wav', 'mp4'];
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

    public function getCover(){
        return $this->cover;
    }
    public function setCover($cover){
        $this->cover = $cover;
    }

}