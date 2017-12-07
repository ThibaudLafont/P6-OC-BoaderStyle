<?php
namespace AppBundle\Entity\Media;

use AppBundle\Entity\Traits\TrickResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Trick;

/**
 * TrickMedia
 *
 * @ORM\Table(name="trick_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrickImageRepository")
 */
class TrickImage extends Local
{

    use TrickResource;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="\AppBundle\Entity\Trick",
     *     inversedBy="imgs",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $trick;

    // CONSTS
    const WEB_DIRECTORY = '/media/img/tricks/';
    const VALID_FORMATS = ['jpeg', 'jpg', 'png'];

    public function addTrick(Trick $trick){
        $this->trick->add($trick);
    }
    public function removeTrick(Trick $trick){
        $this->trick->removeElement($trick);
    }
}