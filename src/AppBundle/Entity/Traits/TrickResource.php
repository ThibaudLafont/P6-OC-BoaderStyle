<?php
namespace AppBundle\Entity\Traits;


use AppBundle\Entity\Trick;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

trait TrickResource
{

    /**
     * @ORM\Column(name="position", type="integer")
     */
    protected $position;


    public function __construct(){
        $this->trick = new ArrayCollection();
    }

      ///////////////////
     ///// SPECIFIC ////
    ///////////////////

    public function removeTrick(Trick $trick){
        $this->trick->removeElement($trick);
    }


    ///////////////////
    ///// SETTERS /////
    ///////////////////

    public function addTrick(Trick $trick){
        $this->trick->add($trick);
    }
    public function setPosition($position){
        if($position === null) $position = 0;
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