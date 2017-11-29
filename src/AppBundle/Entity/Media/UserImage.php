<?php
namespace AppBundle\Entity\Media;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserImage
 *
 * @ORM\Table(name="user_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserImageRepository")
 */
class UserImage extends File
{

    // CONSTS
    const WEB_DIRECTORY = '/web/media/img/users/';
    const VALID_FORMATS = ['jpg'];

}