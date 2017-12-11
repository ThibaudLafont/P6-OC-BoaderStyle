<?php
namespace AppBundle\Entity\Media;

use AppBundle\Entity\Traits\TrickResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Trick;
use Doctrine\ORM\Events;

/**
 * TrickMedia
 *
 * @ORM\Table(name="trick_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrickImageRepository")
 * @ORM\HasLifecycleCallbacks()
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

}