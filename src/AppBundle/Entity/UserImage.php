<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\Media;

/**
 * UserImage
 *
 * @ORM\Table(name="user_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserImageRepository")
 */
class UserImage
{

    use Media;

    private function setFormat(String $format){
        $supported = ['jpg', 'png', 'gif'];
        return in_array($format, $supported);
    }
}