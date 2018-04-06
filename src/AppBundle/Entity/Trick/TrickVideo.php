<?php
namespace AppBundle\Entity\Trick;

use AppBundle\Entity\Media\External;
use AppBundle\Entity\Traits\TrickResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * TrickMedia
 *
 * @ORM\Table(name="trick_video")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrickVideoRepository")
 * @ORM\EntityListeners({"AppBundle\EventListener\TrickVideoListener"})
 */
class TrickVideo extends External
{

    use TrickResource;

    /**
     * Every TrickVideo belong to a trick, witch is stored in this attribute
     *
     * @ORM\ManyToMany(
     *     targetEntity="Trick",
     *     inversedBy="videos",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $trick;

    /**
     * Set the source of the external media
     * Format Youtube link if it's not an embed one
     *
     * @param $src
     */
    public function setSrc($src){

        // If no source given, return
        if($src === null) return;

        // Youtube
        if(strpos($src, 'watch?v=')){
            $src = str_replace('watch?v=', 'embed/', $src);
        }

        // DailyMotion
        if(strpos($src, 'dailymotion')){
            $pos = strpos($src, '/video');
            $src = substr_replace($src, '/embed', $pos, 0);
        }

        // Assign to attribute
        $this->src = $src;
    }
}
