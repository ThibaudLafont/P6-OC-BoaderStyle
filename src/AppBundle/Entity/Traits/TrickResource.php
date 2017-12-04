<?php
namespace AppBundle\Entity\Traits;


use AppBundle\Entity\Trick;
use Doctrine\ORM\Mapping as ORM;

trait TrickResource
{

    /**
     * @ORM\Column(name="position", type="integer")
     */
    protected $position;

    ///////////////////
    ///// SETTERS /////
    ///////////////////

    /**
     * @param Trick $trick
     */
    public function setTrick(Trick $trick){
        $this->trick = $trick;
    }
    public function setPosition($position){
        $this->position = $position;
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
    public function getPosition(){
        return $this->position;
    }

}