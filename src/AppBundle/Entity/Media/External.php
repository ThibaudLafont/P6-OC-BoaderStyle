<?php
namespace AppBundle\Entity\Media;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * This class is the parent of every media wich is stored on a distant server
 *
 * @ORM\MappedSuperclass()
 */
abstract class External extends Media
{

    /**
     * URL of the target media
     *
     * @var string
     *
     * @ORM\Column(name="src", type="string", length=255)
     * @Assert\NotBlank(
     *     message="Veuillez renseigner une URL"
     * )
     */
    protected $src;

    public function getSrc(){
        return $this->src;
    }
    public function setSrc($src){
        $this->src = $src;
    }
}
