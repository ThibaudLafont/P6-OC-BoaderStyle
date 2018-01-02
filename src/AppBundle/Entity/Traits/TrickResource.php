<?php
namespace AppBundle\Entity\Traits;


use AppBundle\Entity\Trick\Trick;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait TrickResource
 * Used as Trick's medias trait, allow to add/remove trick
 *
 * @package AppBundle\Entity\Traits
 */
trait TrickResource
{

    /**
     * For ordering the of medias
     *
     * @ORM\Column(name="position", type="integer")
     */
    protected $position;

    /**
     * TrickResource constructor.
     * Create a ArrayCollection as trick property
     */
    public function __construct(){
        $this->trick = new ArrayCollection();
    }

      ///////////////////
     ///// SPECIFIC ////
    ///////////////////

    /**
     * Remove specified trick of this->trick
     *
     * @param Trick $trick
     */
    public function removeTrick(Trick $trick){
        $this->trick->removeElement($trick);
    }


    ///////////////////
    ///// SETTERS /////
    ///////////////////

    /**
     * Add a new trick in $this->trick
     *
     * @param Trick $trick
     */
    public function addTrick(Trick $trick){
        $this->trick->add($trick);
    }

    /**
     * Set the position of the media
     *
     * @param $position
     */
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
    public function getTricks(){
        return $this->trick;
    }

    /**
     * @return mixed
     */
    public function getPosition(){
        return $this->position;
    }

}
