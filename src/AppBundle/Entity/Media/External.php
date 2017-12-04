<?php
namespace AppBundle\Entity\Media;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 */
abstract class External extends Resource
{

    /**
     * @var string
     *
     * @ORM\Column(name="src", type="string", length=255)
     */
    protected $src;

    public function getSrc(){
        return $this->src;
    }
    public function setSrc($src){
        $this->src = $src;
    }

    public function getType(){
        return $this->type;
    }
    public function setType($type){
        $this->type = $type;
    }
}