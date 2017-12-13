<?php
namespace AppBundle\Entity\Trick;

use AppBundle\Entity\Media\Local;
use AppBundle\Entity\Traits\TrickResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Events;

/**
 * TrickMedia
 *
 * @ORM\Table(name="trick_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrickImageRepository")
 * @ORM\EntityListeners({"AppBundle\EventListener\TrickImageListener"})
 */
class TrickImage extends Local
{

    use TrickResource;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="Trick",
     *     inversedBy="imgs",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $trick;

    // CONSTS
    const WEB_DIRECTORY = '/media/img/tricks/';
    const VALID_FORMATS = ['jpeg', 'jpg', 'png'];

}