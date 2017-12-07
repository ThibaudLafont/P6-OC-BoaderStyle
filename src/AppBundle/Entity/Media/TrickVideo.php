<?php
namespace AppBundle\Entity\Media;

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
     * @ORM\ManyToOne(
     *     targetEntity="\AppBundle\Entity\Trick",
     *     inversedBy="videos",
     *     cascade={"persist"}
     * )
     */
    private $trick;

    public function setSrc($src){
        if($src === null) return;
        if(strpos($src, 'watch?v=')) $src = str_replace('watch?v=', 'embed/', $src);
        $this->src = $src;
    }
}