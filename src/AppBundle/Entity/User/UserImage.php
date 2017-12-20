<?php
namespace AppBundle\Entity\User;

use AppBundle\Entity\Media\Local;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserImage
 *
 * @ORM\Table(name="user_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserImageRepository")
 */
class UserImage extends Local
{

    // CONSTS
    const WEB_DIRECTORY = '/media/img/users/';
    const VALID_FORMATS = ['jpg', 'jpeg'];

}
