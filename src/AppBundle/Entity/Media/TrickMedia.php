<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 29/11/17
 * Time: 09:39
 */

namespace AppBundle\Entity\Media;


use AppBundle\Entity\Trick;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class TrickMedia extends File
{

    ///////////////////
    ///// SETTERS /////
    ///////////////////

    /**
     * @param Trick $trick
     */
    public function setTrick(Trick $trick){
        $this->trick = $trick;
    }


    ///////////////////
    ///// GETTERS /////
    ///////////////////

    /**
     * @return Trick
     */
    public function getTrick(){
        return $this->trick;
    }

}