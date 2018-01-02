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
    /**
     * Web root dir where UserImages are stored
     */
    const WEB_DIRECTORY = '/media/img/users/';
    /**
     * Allowed formats for profil image
     */
    const VALID_FORMATS = ['jpg', 'jpeg'];

}
