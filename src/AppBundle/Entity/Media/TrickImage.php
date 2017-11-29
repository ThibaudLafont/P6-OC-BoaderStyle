<?php
namespace AppBundle\Entity\Media;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Trick;

/**
 * TrickMedia
 *
 * @ORM\Table(name="trick_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrickImageRepository")
 */
class TrickImage extends TrickMedia
{

    // CONSTS
    const WEB_DIRECTORY = '/web/img/tricks/';
    const VALID_FORMATS = ['jpg', 'png'];

}