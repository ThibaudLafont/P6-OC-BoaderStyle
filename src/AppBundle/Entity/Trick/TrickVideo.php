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
 */
class TrickVideo extends External
{

    use TrickResource;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="Trick",
     *     inversedBy="videos",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $trick;

    public function setSrc($src){
        if($src === null) return;
        if(strpos($src, 'watch?v=')) $src = str_replace('watch?v=', 'embed/', $src);
        $this->src = $src;
    }
}