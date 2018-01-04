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
        if($src === null) return;
        if(strpos($src, 'watch?v=')) $src = str_replace('watch?v=', 'embed/', $src);
        $this->src = $src;
    }
}
