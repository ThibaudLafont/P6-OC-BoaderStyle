<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 29/11/17
 * Time: 09:39
 */

namespace AppBundle\Entity\Media;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class TrickMedia extends File
{

    public function getTrick(){
        return $this->trick;
    }
    public function setTrick($trick){
        $this->trick = $trick;
    }

}